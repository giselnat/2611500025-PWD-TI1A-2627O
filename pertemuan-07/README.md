di pertemuan 7 saya mengembangkan, menguji dan menghasilkan:
1. event.preventDefault() ternyata menghalangi eksekusi submit
2. Mencoba superglobal $_GET untuk nama, emai, semester 
3. Mencoba superglobal $_POST untuk nama, emai, semester 
4. menguji GET dan berhasil tanpa kesalahan
5. dapat mengirimkan formulir menggunakan GET, mengamati parameter yang terbentuk pada URL, dan menjelaskan hubungan antara atribut method , parameter URL, serta
penerimaan data menggunakan $_GET .
6. Menguji HTML maupun CSS, dan validasi dapat berfungsi

## Tujuan

Menerapkan pengiriman formulir dengan metode POST, validasi JavaScript dan PHP, pola POST/Redirect/GET, serta menampilkan kembali data dengan aman.

## Tahapan Pengerjaan

1. *Pemeriksaan awal* — memeriksa baseline profil dan formulir serta perubahan lokal yang sudah ada. Form utama diarahkan memakai POST; berkas lama indexGet.php tidak digunakan.
2. *Pemrosesan peladen* — memeriksa kolom wajib, panjang nama dan pesan, format email/tanggal, rentang semester, serta nilai pilihan. Data POST dipindahkan melalui session dan redirect agar refresh tidak mengirim ulang formulir.
3. *Tampilan dan keamanan* — mengisi kembali nilai form setelah redirect, hanya menampilkan ringkasan data bila valid, dan melakukan escaping pada semua nilai yang ditampilkan. Ikon navigasi diperbaiki agar tidak tampil sebagai teks rusak.
4. *Pengujian* — hasil tercatat di bagian berikut.

## Cara Menjalankan
http://localhost/pwd/2627/ti1a/2611500025-PWD-TI1A-2627O/pertemuan-07/
Nyalakan Apache melalui Laragon, lalu buka:

## Hasil Pengujian

- php -l index.php — lulus, tidak ada kesalahan sintaks (PHP 8.3).
- node --check script.js — lulus, tidak ada kesalahan sintaks.
- Uji GET melalui server PHP lokal — menerima HTTP 200.
- Uji POST valid — redirect dan menampilkan status berhasil serta ringkasan.
- Uji masukan HTML — karakter HTML di-escape saat ditampilkan kembali.

## Catatan Git

README diperbarui untuk tahap pemeriksaan, implementasi, dan pengujian. Seluruh perubahan pertemuan 7 dipublikasikan setelah pemeriksaan selesai.