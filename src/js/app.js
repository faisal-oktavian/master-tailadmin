import Swal from "sweetalert2";

/* ------------------------------------------------------------------ helpers */
const meta = (name) =>
  document.querySelector(`meta[name="${name}"]`)?.getAttribute("content") || "";
const baseUrl = () => meta("base-url").replace(/\/?$/, "/");
const csrf = () => ({ name: meta("csrf-name"), hash: meta("csrf-hash") });
const MODAL_LOADING_DELAY = 1000; // untuk mengatur durasi loading modal agar tidak terlalu cepat hilang (jika server cepat merespon)
window.__modalLoadingDelay = MODAL_LOADING_DELAY;
const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
const waitForMinimumLoading = (startedAt) =>
  wait(Math.max(0, MODAL_LOADING_DELAY - (Date.now() - startedAt)));
const formatRupiah = (value) => {
  const digits = String(value ?? "").replace(/\D/g, "");
  return digits ? new Intl.NumberFormat("id-ID").format(Number(digits)) : "";
};

/* ---------------------------------------------------------------- SweetAlert */
const swalTw = {
  popup: "rounded-2xl! dark:bg-gray-900! dark:text-white/90!",
  title: "text-gray-800! dark:text-white/90!",
  htmlContainer: "text-gray-500! dark:text-gray-400!",
  confirmButton:
    "bg-brand-500 hover:bg-brand-600 shadow-theme-xs mx-1 rounded-lg px-4 py-3 text-sm font-medium text-white transition",
  denyButton:
    "bg-error-500 hover:bg-error-600 shadow-theme-xs mx-1 rounded-lg px-4 py-3 text-sm font-medium text-white transition",
  cancelButton:
    "mx-1 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition ring-inset hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/3",
};

const swal = Swal.mixin({ buttonsStyling: false, customClass: swalTw });
window.__showNavigationLoading = (title) =>
  swal.fire({
    title,
    allowOutsideClick: false,
    showConfirmButton: false,
    didOpen: () => swal.showLoading(),
  });
window.__closeNavigationLoading = () => swal.close();

const toast = (icon, title) =>
  swal.fire({
    toast: true,
    position: "top-end",
    icon,
    title,
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
  });

const confirmDanger = ({ title, text, confirmText = "Ya, hapus" }) =>
  swal.fire({
    icon: "warning",
    title,
    text,
    showCancelButton: true,
    confirmButtonText: confirmText,
    cancelButtonText: "Batal",
    reverseButtons: true,
    focusCancel: true,
    customClass: {
      ...swalTw,
      confirmButton:
        "bg-error-500 hover:bg-error-600 shadow-theme-xs mx-1 rounded-lg px-4 py-3 text-sm font-medium text-white transition",
    },
  });

const confirmSave = (title = "Simpan data?", text = "Pastikan data yang Anda isi sudah benar.") =>
  swal.fire({
    icon: "question",
    title,
    text,
    showCancelButton: true,
    confirmButtonText: "Ya, simpan",
    cancelButtonText: "Batal",
    reverseButtons: true,
  });

/* ------------------------------------------------------------------ request */
async function post(url, formData) {
  const fd = formData || new FormData();
  const c = csrf();
  if (!fd.has(c.name)) fd.append(c.name, c.hash);

  const res = await fetch(url, {
    method: "POST",
    body: fd,
    credentials: "same-origin",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  });

  if (res.status === 401) {
    window.location.href = baseUrl() + "login";
    return { res, json: { status: false } };
  }

  let json;
  try {
    json = await res.json();
  } catch (e) {
    json = {
      status: false,
      message:
        res.status === 403
          ? "Token keamanan tidak valid. Muat ulang halaman lalu coba lagi."
          : "Respon server tidak valid.",
    };
  }
  return { res, json };
}

async function deleteRecord({ url, nama, label, onLoading, onSuccess, onFinish }) {
  const answer = await confirmDanger({
    title: `Hapus ${label}?`,
    text: `Data "${nama}" akan dihapus permanen.`,
  });
  if (!answer.isConfirmed) return;

  const requestStartedAt = Date.now();
  let tableLoadingStartedAt = null;
  if (!onLoading && !onSuccess) {
    swal.fire({
      title: "Menghapus...",
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => swal.showLoading(),
    });
  }

  try {
    const { json } = await post(url);
    if (json.status) {
      if (onSuccess) {
        tableLoadingStartedAt = Date.now();
        if (onLoading) onLoading();
        await onSuccess(json);
      } else {
        await waitForMinimumLoading(requestStartedAt);
        window.location.reload(); // notifikasi sukses ditampilkan dari flashdata
      }
    } else {
      if (!onFinish) swal.close();
      swal.fire({ icon: "error", title: "Gagal", text: json.message || "Data tidak dapat dihapus." });
    }
  } catch (e) {
    if (!onFinish) swal.close();
    swal.fire({ icon: "error", title: "Gagal", text: "Tidak dapat terhubung ke server." });
  } finally {
    if (tableLoadingStartedAt !== null) {
      await waitForMinimumLoading(tableLoadingStartedAt);
    }
    if (onFinish) onFinish();
  }
}

/* ------------------------------------------------- tabel: cari + pagination */
const tableState = () => ({
  query: "",
  page: 1,
  perPage: 10,
  filteredCount: 0,
  rows: [],

  initTable() {
    this.rows = Array.from(this.$root.querySelectorAll("tbody tr[data-row]"));
    this.apply();
    this.$watch("query", () => {
      this.page = 1;
      this.apply();
    });
    this.$watch("page", () => this.apply());
  },

  get totalPages() {
    return Math.max(1, Math.ceil(this.filteredCount / this.perPage));
  },
  get from() {
    return this.filteredCount === 0 ? 0 : (this.page - 1) * this.perPage + 1;
  },
  get to() {
    return Math.min(this.page * this.perPage, this.filteredCount);
  },

  apply() {
    const q = this.query.trim().toLowerCase();
    const matched = this.rows.filter((r) => !q || r.textContent.toLowerCase().includes(q));
    this.filteredCount = matched.length;

    const pages = Math.max(1, Math.ceil(matched.length / this.perPage));
    if (this.page > pages) {
      this.page = pages;
      return;
    }

    const start = (this.page - 1) * this.perPage;
    const visible = new Set(matched.slice(start, start + this.perPage));
    this.rows.forEach((r) => {
      r.hidden = !visible.has(r);
    });
  },

  prev() {
    if (this.page > 1) this.page--;
  },
  next() {
    if (this.page < this.totalPages) this.page++;
  },
});

/* --------------------------------------------------------- Alpine components */
export function registerApp(Alpine) {
  /* ------------------------ Master Karyawan (CRUD memakai popup modal) */
  Alpine.data("karyawanCrud", () =>
    Object.assign(tableState(), {
      open: false,
      saving: false,
      tableLoading: false,
      modalLoading: false,
      passwordVisible: false,
      editId: null,
      level: 5,
      fotoUrl: "",

      init() {
        this.initTable();
      },

      async openCreate() {
        if (this.modalLoading) return;
        const loadingStartedAt = Date.now();
        this.modalLoading = true;
        swal.fire({
          title: "Menyiapkan form...",
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => swal.showLoading(),
        });
        await waitForMinimumLoading(loadingStartedAt);
        this.resetForm();
        swal.close();
        this.modalLoading = false;
        this.open = true;
      },

      async openEdit(id) {
        if (this.modalLoading) return;
        const loadingStartedAt = Date.now();
        this.modalLoading = true;
        swal.fire({
          title: "Memuat data...",
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => swal.showLoading(),
        });
        try {
          const request = fetch(`${baseUrl()}karyawan/get/${id}`, {
              credentials: "same-origin",
              headers: { "X-Requested-With": "XMLHttpRequest" },
            }).then(
              (res) => ({ res }),
              (error) => ({ error }),
            );
          const [{ res, error }] = await Promise.all([
            request,
            waitForMinimumLoading(loadingStartedAt),
          ]);
          if (error) throw error;
          if (res.status === 401) {
            window.location.href = baseUrl() + "login";
            return;
          }
          const json = await res.json();
          swal.close();
          if (!json.status) {
            toast("error", json.message || "Data tidak ditemukan.");
            return;
          }
          this.resetForm();
          this.editId = id;
          this.fill(json.data);
          this.open = true;
        } catch (e) {
          swal.close();
          toast("error", "Tidak dapat memuat data.");
        } finally {
          this.modalLoading = false;
        }
      },

      async refreshTable() {
        const res = await fetch(`${baseUrl()}karyawan/table`, {
          credentials: "same-origin",
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        if (!res.ok) throw new Error("Gagal memuat ulang tabel.");

        const tbody = this.$root.querySelector("tbody");
        tbody.innerHTML = await res.text();
        this.rows = Array.from(tbody.querySelectorAll("tr[data-row]"));
        this.apply();
      },

      close() {
        this.open = false;
      },

      resetForm() {
        this.$refs.form.reset();
        this.clearErrors();
        this.editId = null;
        this.level = 5;
        this.fotoUrl = "";
        this.passwordVisible = false;
      },

      formatGaji(event) {
        event.target.value = formatRupiah(event.target.value);
      },

      togglePassword() {
        this.passwordVisible = !this.passwordVisible;
      },

      fill(d) {
        const f = this.$refs.form;
        [
          "kode", "nama", "email", "telepon", "website", "gaji", "tgl_lahir",
          "jam_masuk", "tgl_bergabung", "warna", "departemen", "alamat",
        ].forEach((name) => {
          if (f.elements[name]) {
            f.elements[name].value = name === "gaji" ? formatRupiah(d[name]) : d[name] ?? "";
          }
        });

        this.level = parseInt(d.level_skill, 10) || 5;

        f.querySelectorAll('input[name="jenis_kelamin"]').forEach((r) => {
          r.checked = r.value === d.jenis_kelamin;
        });
        f.querySelectorAll('input[name="skills[]"]').forEach((c) => {
          c.checked = (d.skills || []).includes(c.value);
        });
        f.querySelectorAll('input[name="bahasa[]"]').forEach((checkbox) => {
          checkbox.checked = (d.bahasa || []).includes(checkbox.value);
        });

        f.elements["aktif"].checked = String(d.aktif) === "1";
        f.elements["setuju"].checked = true; // data lama sudah pernah disetujui
        this.fotoUrl = d.foto_url || "";
      },

      previewFoto(e) {
        const file = e.target.files && e.target.files[0];
        this.fotoUrl = file ? URL.createObjectURL(file) : "";
      },

      clearErrors() {
        this.$refs.form.querySelectorAll("[data-error-for]").forEach((p) => (p.textContent = ""));
        this.$refs.form.querySelectorAll(".border-error-500\\!").forEach((el) => {
          el.classList.remove("border-error-500!", "dark:border-error-500!");
        });
      },

      showErrors(errors) {
        Object.entries(errors).forEach(([name, msg]) => {
          const p = this.$refs.form.querySelector(`[data-error-for="${name}"]`);
          if (p) {
            p.textContent = msg;
          }
          this.$refs.form.querySelectorAll(`[name="${name}"]`).forEach((el) => {
            if (el.type !== "checkbox" && el.type !== "radio") {
              el.classList.add("border-error-500!", "dark:border-error-500!");
            }
          });
        });
      },

      async submit() {
        this.clearErrors();
        let tableLoadingStartedAt = null;
        this.saving = true;
        try {
          const url = this.editId
            ? `${baseUrl()}karyawan/update/${this.editId}`
            : `${baseUrl()}karyawan/store`;
          const formData = new FormData(this.$refs.form);
          formData.set("gaji", String(formData.get("gaji") || "").replace(/\D/g, ""));
          const { res, json } = await post(url, formData);

          if (json.status) {
            this.open = false;
            tableLoadingStartedAt = Date.now();
            this.tableLoading = true;
            try {
              await this.refreshTable();
              toast("success", json.message || "Data karyawan berhasil disimpan.");
            } catch (e) {
              toast("warning", "Data tersimpan, tetapi tabel gagal diperbarui.");
            }
          } else {
            if (json.errors) this.showErrors(json.errors);
            toast("error", json.message || `Gagal menyimpan data (${res.status}).`);
          }
        } catch (e) {
          toast("error", "Tidak dapat terhubung ke server.");
        } finally {
          if (tableLoadingStartedAt !== null) {
            await waitForMinimumLoading(tableLoadingStartedAt);
          }
          this.saving = false;
          this.tableLoading = false;
        }
      },

      remove(id, nama) {
        return deleteRecord({
          url: `${baseUrl()}karyawan/delete/${id}`,
          nama,
          label: "karyawan",
          onLoading: () => { this.tableLoading = true; },
          onSuccess: async (json) => {
            try {
              await this.refreshTable();
              toast("success", json.message || "Data karyawan berhasil dihapus.");
            } catch (e) {
              toast("warning", "Data terhapus, tetapi tabel gagal diperbarui.");
            }
          },
          onFinish: () => { this.tableLoading = false; },
        });
      },
    }),
  );

  /* ------------------------ Master Supplier (CRUD halaman terpisah) */
  Alpine.data("supplierList", () =>
    Object.assign(tableState(), {
      init() {
        this.initTable();
      },
      remove(id, nama) {
        return deleteRecord({
          url: `${baseUrl()}supplier/delete/${id}`,
          nama,
          label: "supplier",
          onSuccess: async () => {
            if (typeof window.__navigateMenu === "function") {
              await window.__navigateMenu(`${baseUrl()}supplier`, false);
            } else {
              window.location.reload();
            }
          },
        });
      },
    }),
  );
}

/* --------------------------------------------------- handler global halaman */
document.addEventListener("DOMContentLoaded", () => {
  // notifikasi flashdata dari CodeIgniter
  const flash = window.__flash || {};
  if (flash.success) toast("success", flash.success);
  if (flash.error) toast("error", flash.error);

  // error validasi dari halaman form (non-AJAX)
  const pd = window.__pageData || {};
  if (pd.swalError) {
    swal.fire({ icon: "error", title: "Data belum valid", text: pd.swalError });
  }
  renderSupplierErrors(pd.supplierErrors);

  // konfirmasi logout
  document.querySelectorAll("[data-logout]").forEach((a) => {
    a.addEventListener("click", async (e) => {
      e.preventDefault();
      const r = await swal.fire({
        icon: "question",
        title: "Keluar dari aplikasi?",
        text: "Sesi Anda akan diakhiri.",
        showCancelButton: true,
        confirmButtonText: "Ya, keluar",
        cancelButtonText: "Batal",
        reverseButtons: true,
      });
      if (r.isConfirmed) window.location.href = a.getAttribute("href");
    });
  });

  // Delegasi agar form Supplier tetap bekerja setelah halaman dimuat secara partial.
  document.addEventListener("submit", async (e) => {
    const form = e.target;
    if (!(form instanceof HTMLFormElement) || !form.matches("form[data-confirm-save]")) return;

    e.preventDefault();
    const r = await confirmSave();
    if (!r.isConfirmed) return;
    if (typeof window.__submitPartialForm === "function") {
      await window.__submitPartialForm(form);
    } else {
      HTMLFormElement.prototype.submit.call(form);
    }
  });
});

document.addEventListener("app:page-updated", () => {
  const pageData = window.__pageData || {};
  renderSupplierErrors(pageData.supplierErrors);
  if (pageData.swalError) {
    swal.fire({ icon: "error", title: "Data belum valid", text: pageData.swalError });
  }
  if (pageData.success) toast("success", pageData.success);
  if (pageData.error) toast("error", pageData.error);
});

function renderSupplierErrors(errors) {
  const form = document.getElementById("supplier-form");
  if (!form || !errors) return;

  Object.entries(errors).forEach(([field, message]) => {
    const placeholder = form.querySelector(`[data-error-for="${CSS.escape(field)}"]`);
    if (placeholder) placeholder.textContent = message;
  });
}

export { Swal, swal, toast };
