# Pertemuan 6 - PHP Dasar dan Pemrograman Sisi Peladen

## Tujuan

Halaman ini merupakan latihan dasar PHP yang dijalankan melalui server lokal.
Materi PHP diterapkan pada halaman profil mahasiswa, sedangkan HTML, CSS, dan
JavaScript digunakan untuk menyusun tampilan dan interaksi halaman.

## Materi dan Implementasi

Implementasi utama terdapat pada `index.php` dan mencakup:

- **Variabel dan konstanta** untuk menyimpan data mahasiswa, seperti NIM,
  nama, program studi, tahun akademik, semester, IPK, dan catatan tambahan.
- **Operator aritmetika** untuk menghitung sisa semester dari batas semester
  yang ditentukan.
- **Operator perbandingan dan logika** untuk memeriksa apakah semester berada
  dalam rentang yang berlaku dan apakah status mahasiswa aktif.
- **Operator ternary** untuk menentukan status semester, nama program studi,
  status mahasiswa, dan teks catatan tambahan.
- **Percabangan `if-elseif-else`** untuk mengelompokkan semester sebagai
  semester awal, menengah, atau akhir.
- **Percabangan `switch`** untuk menampilkan fokus program studi dan menyusun
  teks target belajar.
- **Perulangan `for`** untuk menampilkan lima target belajar.
- **Perulangan `while`** untuk menampilkan tiga semester.
- **Fungsi `number_format()`** untuk menampilkan IPK dengan dua angka desimal.
- **Fungsi `date()`** untuk menampilkan tahun berjalan pada footer.

Nilai yang tampil mengikuti nilai variabel di bagian awal `index.php`. Sebagai
contoh, IPK pada kode saat ini bernilai `0.00`, sehingga ditampilkan sebagai
`0,00` karena format desimal menggunakan koma. Jika nilai `$ipk` diubah,
tampilan IPK juga akan berubah. Demikian pula, `$catatanTambahan` yang bernilai
`null` menampilkan teks `Belum ada`; jika nilainya diganti dengan teks, teks
tersebut yang akan ditampilkan.

## Struktur Berkas

- `index.php` — data profil, logika PHP, dan struktur halaman.
- `style.css` — tata letak, warna, dan tampilan responsif.
- `script.js` — tombol navigasi pada layar kecil dan validasi formulir di sisi
  klien.
- `img/foto-profil.jpg` — gambar profil yang digunakan halaman (jika tersedia).

## Menjalankan Halaman

1. Pastikan PHP tersedia melalui server lokal, misalnya Laragon.
2. Letakkan proyek di direktori web server.
3. Jalankan server web lokal.
4. Buka direktori `pertemuan-06` melalui browser, misalnya
   `http://localhost/pwd/2627/ti1a/2611500025-PWD-TI1A-2627O/pertemuan-06/`.

## Pengujian

Pengujian halaman dilakukan melalui server lokal PHP pada `localhost`.
Pemeriksaan yang dicatat meliputi:

- Halaman dapat dirender tanpa galat PHP.
- Data profil, program studi, status mahasiswa, semester, hasil pemeriksaan
  rentang semester, IPK, dan catatan tambahan ditampilkan sesuai nilai pada
  kode.
- Perulangan `for` menampilkan lima target belajar dan perulangan `while`
  menampilkan tiga semester.
- Tahun pada footer mengikuti tahun saat halaman dibuka karena menggunakan
  `date("Y")`.
- Validasi formulir di browser menampilkan pesan kesalahan jika data belum
  sesuai, dan pesan berhasil jika seluruh pemeriksaan JavaScript terpenuhi.

## Batasan

Formulir belum mengolah atau memvalidasi data di sisi PHP dan belum menyimpan
data yang dikirim. Validasi formulir yang tersedia dilakukan oleh JavaScript
di browser; karena itu, validasi tersebut bukan pengganti validasi sisi
peladen. Pemrosesan dan validasi data formulir menggunakan PHP dibahas pada
pertemuan berikutnya (P7).
