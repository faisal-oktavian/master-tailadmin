/*
 * Perpindahan menu tanpa memuat ulang seluruh halaman.
 *
 * Klik menu di sidebar (atau link breadcrumb) -> ambil hanya isi halaman dari server
 * (controller mengirim breadcrumb + isi saja bila ada header "X-Partial: 1"), lalu ganti
 * isi #page-root. Sidebar dan header tidak ikut dimuat ulang; loading hanya tampil di
 * area konten (#content-loading).
 *
 * Jika sesuatu tidak memungkinkan (sesi habis, error server, halaman yang butuh script
 * khusus), otomatis kembali ke perpindahan halaman biasa, jadi tidak pernah buntu.
 *
 * File ini berdiri sendiri (tidak lewat webpack), jadi tidak perlu `npm run build`.
 */
(function () {
  "use strict";

  var root = document.getElementById("page-root");
  var loading = document.getElementById("content-loading");
  if (!root || !loading || !window.fetch || !window.history || !history.pushState) return;

  var navId = 0; // penanda navigasi terakhir; respon navigasi lama diabaikan
  var controller = null;
  var navigationLoading = false;
  var currentKey = location.pathname + location.search;

  function setLoading(on) {
    loading.hidden = !on;
    root.setAttribute("aria-busy", on ? "true" : "false");
  }

  function appState() {
    try {
      return window.Alpine ? window.Alpine.$data(document.body) : null;
    } catch (e) {
      return null;
    }
  }

  /** Link yang diperlakukan sebagai menu: di sidebar atau breadcrumb, satu situs yang sama. */
  function isMenuLink(a) {
    if (!a.hasAttribute("data-menu-nav") && !a.closest("aside, #page-root nav")) return false;
    if (a.hasAttribute("data-logout") || a.hasAttribute("download") || a.hasAttribute("data-full-page")) return false;
    if (a.target && a.target !== "_self") return false;
    var raw = a.getAttribute("href") || "";
    if (!raw || raw.charAt(0) === "#" || /^(javascript|mailto|tel):/i.test(raw)) return false;
    return new URL(a.href, location.href).origin === location.origin;
  }

  /** Halaman yang tidak aman diganti sebagian harus dimuat penuh seperti biasa. */
  function canSwap(fragment) {
    // grafik Dashboard butuh window.__initCharts (ada setelah `npm run build` dengan index.js terbaru)
    if (!window.__initCharts && fragment.querySelector("#chartOne, #chartTwo")) return false;
    return true;
  }

  function parsePageData(raw) {
    try {
      var d = JSON.parse(decodeURIComponent(raw || ""));
      return d && !Array.isArray(d) && Object.keys(d).length ? d : undefined;
    } catch (e) {
      return undefined;
    }
  }

  /** Pindah halaman dengan cara biasa (overlay loading dibiarkan sampai halaman berganti). */
  function hardNavigate(url, replace) {
    if (replace) location.replace(url);
    else location.assign(url);
  }

  async function navigate(url, push, requestOptions) {
    var id = ++navId;
    var startedAt = Date.now();
    var minimumLoadingMs = Number(requestOptions && requestOptions.minimumLoadingMs) || 0;
    var loadingTitle = requestOptions && requestOptions.loadingTitle;
    if (controller) controller.abort();
    controller = new AbortController();
    if (navigationLoading && window.__closeNavigationLoading) {
      window.__closeNavigationLoading();
      navigationLoading = false;
    }
    if (loadingTitle && window.__showNavigationLoading) {
      setLoading(false);
      window.__showNavigationLoading(loadingTitle);
      navigationLoading = true;
    } else {
      setLoading(true);
    }
    var method = requestOptions && requestOptions.method;

    try {
      var res = await fetch(url, {
        credentials: "same-origin",
        cache: "no-store",
        signal: controller.signal,
        method: method,
        body: requestOptions && requestOptions.body,
        headers: { "X-Partial": "1", "X-Requested-With": "XMLHttpRequest" },
      });
      if (id !== navId) return;

      var key = res.headers.get("X-Page-Key");
      if (requestOptions && res.redirected && !key && res.url !== url) {
        return navigate(res.url, true);
      }
      if (!res.ok || !key) return hardNavigate(url, !push); // sesi habis / error / bukan halaman menu

      var html = await res.text();
      if (id !== navId) return;

      var tpl = document.createElement("template");
      tpl.innerHTML = html;
      if (!canSwap(tpl.content)) return hardNavigate(url, !push);
      var hasCharts = !!tpl.content.querySelector("#chartOne, #chartTwo");

      var title = res.headers.get("X-Page-Title");
      if (title) document.title = decodeURIComponent(title);
      var mainClass = res.headers.get("X-Main-Class");
      if (mainClass) root.className = decodeURIComponent(mainClass);
      window.__pageData = parsePageData(res.headers.get("X-Page-Data"));

      var state = appState();
      if (state) {
        state.page = key; // menu aktif di sidebar
        if (window.innerWidth < 1280) state.sidebarToggle = false; // tutup sidebar di layar kecil
      }

      var nextUrl = res.redirected ? res.url : url;
      if (push && (!method || res.redirected)) history.pushState({ menuNav: true }, "", nextUrl);
      currentKey = location.pathname + location.search;

      root.innerHTML = html; // Alpine otomatis menginisialisasi x-data di dalamnya
      var scroller = root.closest(".overflow-y-auto");
      if (scroller) scroller.scrollTop = 0;
      if (hasCharts && typeof window.__initCharts === "function") window.__initCharts(); // hanya halaman yang punya grafik

      var remainingLoadingMs = minimumLoadingMs - (Date.now() - startedAt);
      if (remainingLoadingMs > 0) {
        await new Promise(function (resolve) { setTimeout(resolve, remainingLoadingMs); });
      }
      if (id !== navId) return;

      if (navigationLoading && window.__closeNavigationLoading) {
        window.__closeNavigationLoading();
        navigationLoading = false;
      }
      setLoading(false);
      document.dispatchEvent(new Event("app:page-updated"));
    } catch (e) {
      if (e && e.name === "AbortError") return; // digantikan navigasi yang lebih baru
      hardNavigate(url, !push);
    }
  }

  window.__submitPartialForm = function (form) {
    return navigate(form.action, true, {
      method: (form.method || "POST").toUpperCase(),
      body: new FormData(form),
    });
  };
  // opsi kedua (opsional): { minimumLoadingMs: 1000 } supaya loading konten terlihat jelas
  window.__navigateMenu = function (url, push, options) {
    return navigate(url, !!push, options);
  };

  document.addEventListener("click", function (e) {
    if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
    var a = e.target.closest && e.target.closest("a[href]");
    if (!a || !isMenuLink(a)) return;
    e.preventDefault();
    var loadingTitle = a.getAttribute("data-loading-title");
    navigate(a.href, true, {
      loadingTitle: loadingTitle,
      minimumLoadingMs: loadingTitle ? window.__modalLoadingDelay : 0,
    });
  });

  // Tombol Back / Forward browser. Perubahan #hash saja diabaikan.
  window.addEventListener("popstate", function () {
    if (location.pathname + location.search === currentKey) return;
    navigate(location.href, false);
  });
})();
