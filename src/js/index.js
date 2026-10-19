import "sweetalert2/dist/sweetalert2.min.css";
import "../css/style.css";

import persist from "@alpinejs/persist";
import Alpine from "alpinejs";
import { setupI18n } from "./i18n";

import chart01 from "./components/charts/chart-01";
import chart02 from "./components/charts/chart-02";
import { registerApp } from "./app";

// TailAdmin Theme Manager: baca dari localStorage
(function () {
  var stored = localStorage.getItem("darkMode");
  var isDark = stored !== null ? JSON.parse(stored) : false;

  if (isDark) {
    document.documentElement.classList.add("dark");
    document.documentElement.setAttribute("data-color-scheme", "dark");
  } else {
    document.documentElement.classList.remove("dark");
    document.documentElement.setAttribute("data-color-scheme", "light");
  }
})();

Alpine.plugin(persist);
window.Alpine = Alpine;

// i18next + $t() magic dari TailAdmin
setupI18n(Alpine);

// Komponen CRUD (Master Karyawan, Supplier, dan User)
registerApp(Alpine);

Alpine.start();

// Dipanggil static/js/menu-nav.js setelah isi Dashboard dimuat lewat perpindahan menu
// (tanpa reload halaman), supaya grafiknya ikut digambar.
window.__initCharts = () => {
  chart01();
  chart02();
};

document.addEventListener("DOMContentLoaded", () => {
  // chart hanya dirender jika elemennya ada (halaman dashboard)
  chart01();
  chart02();

  // tahun di footer (jika ada)
  const year = document.getElementById("year");
  if (year) year.textContent = new Date().getFullYear();

  // shortcut Cmd/Ctrl + K untuk fokus ke pencarian header
  const searchInput = document.getElementById("search-input");
  const searchButton = document.getElementById("search-button");
  if (searchInput) {
    if (searchButton) {
      searchButton.addEventListener("click", (e) => {
        e.preventDefault();
        searchInput.focus();
      });
    }
    document.addEventListener("keydown", (event) => {
      if ((event.metaKey || event.ctrlKey) && event.key === "k") {
        event.preventDefault();
        searchInput.focus();
      }
    });
  }
});
