// Navigasi responsif.
const navToggle = document.getElementById("navToggle");
const navMenu = document.getElementById("navMenu");

if (navToggle && navMenu) {
  navToggle.addEventListener("click", () => {
    const isOpen = navMenu.classList.toggle("nav-open");
    navToggle.setAttribute("aria-expanded", String(isOpen));
    navToggle.setAttribute(
      "aria-label",
      isOpen ? "Tutup navigasi" : "Buka navigasi",
    );
  });
}

// Validasi formulir Kontak.
// Selector menggunakan atribut/class, bukan ID formulir tertentu,
// sehingga formulir lain dapat ditambahkan dengan ID yang berbeda.
const contactForms = document.querySelectorAll(
  'form[data-validation="contact"]',
);

contactForms.forEach((contactForm) => {
  const formFeedback = contactForm.querySelector("[data-form-feedback]");

  const ambilInput = (nama) => contactForm.elements.namedItem(nama);

  contactForm.addEventListener("submit", (event) => {
    // Mencegah pengiriman otomatis sebelum seluruh validasi selesai.
    event.preventDefault();

    const namaInput = ambilInput("nama");
    const emailInput = ambilInput("email");
    const semesterInput = ambilInput("semester");
    const tanggalInput = ambilInput("tanggal");
    const prodiInput = ambilInput("prodi");
    const pesanInput = ambilInput("pesan");
    const jenisPesan = contactForm.querySelector(
      'input[name="jenis_pesan"]:checked',
    );
    const topikDipilih = contactForm.querySelectorAll(
      'input[name="minat[]"]:checked',
    );

    const nama = namaInput.value.trim();
    const email = emailInput.value.trim();
    const semester = Number(semesterInput.value);
    const tanggal = tanggalInput.value;
    const prodi = prodiInput.value;
    const pesan = pesanInput.value.trim();

    const tampilkanKesalahan = (pesanKesalahan) => {
      if (formFeedback) {
        formFeedback.textContent = pesanKesalahan;
        formFeedback.className = "form-feedback-error";
      }
    };

    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }

    if (nama.length < 3 || nama.length > 50) {
      tampilkanKesalahan("Nama lengkap harus diisi 3 sampai 50 karakter.");
      return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      tampilkanKesalahan("Masukkan alamat email yang valid.");
      return;
    }

    if (
      semesterInput.value.trim() === "" ||
      !Number.isInteger(semester) ||
      semester < 1 ||
      semester > 14
    ) {
      tampilkanKesalahan("Semester harus diisi dengan angka 1 sampai 14.");
      return;
    }

    if (tanggal === "") {
      tampilkanKesalahan("Tanggal kunjungan harus diisi.");
      return;
    }

    if (!jenisPesan) {
      tampilkanKesalahan("Pilih jenis pesan.");
      return;
    }

    if (topikDipilih.length === 0) {
      tampilkanKesalahan("Pilih minimal satu topik yang diminati.");
      return;
    }

    if (prodi === "") {
      tampilkanKesalahan("Pilih program studi.");
      return;
    }

    if (pesan.length === 0 || pesan.length > 300) {
      tampilkanKesalahan("Pesan harus diisi dan maksimal 300 karakter.");
      return;
    }

    // Mengirim formulir setelah seluruh validasi JavaScript berhasil.
    // HTMLFormElement.submit() tidak memicu event submit kembali.
    contactForm.submit();
  });

  contactForm.addEventListener("reset", () => {
    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }
  });

  contactForm.addEventListener("input", () => {
    if (formFeedback) {
      formFeedback.textContent = "";
      formFeedback.className = "form-feedback";
    }
  });
});

const activityForm = document.querySelector(
  'form[data-validation="rencana"]',
);

if (activityForm) {
  const errorBox = activityForm.querySelector("#js-error-message");
  const activityFields = {
    nama: activityForm.elements.namedItem("nama_kegiatan"),
    kategori: activityForm.elements.namedItem("kategori_kegiatan"),
    tanggal: activityForm.elements.namedItem("tanggal_pelaksanaan"),
    lokasi: activityForm.elements.namedItem("lokasi_kegiatan"),
    deskripsi: activityForm.elements.namedItem("deskripsi_kegiatan"),
  };

  const clearErrors = () => {
    if (errorBox) {
      errorBox.textContent = "";
      errorBox.className = "form-feedback";
    }
  };

  activityForm.addEventListener("submit", (event) => {
    const errors = [];

    if (activityFields.nama.value.trim().length < 3) {
      errors.push("Nama kegiatan minimal 3 karakter.");
    }
    if (!activityFields.kategori.value) {
      errors.push("Pilih kategori kegiatan.");
    }
    if (!activityFields.tanggal.value) {
      errors.push("Tanggal pelaksanaan wajib diisi.");
    }
    if (!activityFields.lokasi.value.trim()) {
      errors.push("Lokasi kegiatan wajib diisi.");
    }
    if (activityFields.deskripsi.value.trim().length < 10) {
      errors.push("Deskripsi kegiatan minimal 10 karakter.");
    }

    if (errors.length > 0) {
      event.preventDefault();
      if (errorBox) {
        const list = document.createElement("ul");
        errors.forEach((message) => {
          const item = document.createElement("li");
          item.textContent = message;
          list.append(item);
        });
        errorBox.replaceChildren(list);
        errorBox.className = "form-feedback-error";
      }
    }
  });

  activityForm.addEventListener("input", clearErrors);
  activityForm.addEventListener("change", clearErrors);
  activityForm.addEventListener("reset", clearErrors);
}
