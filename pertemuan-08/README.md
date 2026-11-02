# Pertemuan 08 — Profil Mahasiswa

## Proses pengerjaan

1. Mempertahankan halaman profil mahasiswa, navigasi, dan formulir Kontak dari pertemuan sebelumnya.
2. Menambahkan formulir Rencana Kegiatan mahasiswa dan tautan menu ke bagiannya.
3. Memisahkan pemrosesan POST berdasarkan jenis formulir agar pengiriman Rencana Kegiatan tidak mengganggu Kontak.
4. Menambahkan validasi sisi klien dan sisi peladen, penyimpanan session, serta pola Post-Redirect-Get (PRG).
5. Menampilkan kembali data kegiatan dan Kontak yang valid dengan escaping HTML.
6. Memperbaiki kesalahan sintaks pada `session_start()` yang menyebabkan PHP gagal memuat halaman.

## Hasil pengujian

| Pemeriksaan | Hasil |
|---|---|
| Analisis editor untuk `index.php` dan `script.js` | Lolos; tidak ada error yang dilaporkan. |
| PHP lint (`php -l`) | Belum dijalankan pada sesi ini. |
| Membuka halaman melalui server Laragon | Belum diverifikasi melalui browser. |
| Navigasi dan pengiriman kedua formulir melalui browser | Belum diverifikasi melalui browser. |

Validasi server pada formulir Rencana Kegiatan memeriksa nama, kategori, tanggal, lokasi, dan deskripsi. Validasi Kontak memeriksa nama, email, semester, tanggal, jenis pesan, topik, program studi, dan pesan. Jika input tidak valid, halaman menampilkan kesalahan dan mengisi kembali nilai yang telah dikirim. Data valid disimpan di session dan ditampilkan setelah redirect.

## Menjalankan dan menguji

1. Jalankan Apache/PHP melalui Laragon.
2. Buka `http://localhost/pwd/2627/ti1a/2611500025-PWD-TI1A-2627O/pertemuan-08/`.
3. Uji tautan navigasi Beranda, Tentang, Kontak, dan Rencana Kegiatan.
4. Kirim masing-masing formulir dengan data kosong/tidak valid, lalu pastikan pesan validasi dan nilai sebelumnya ditampilkan.
5. Kirim kedua formulir dengan data valid, lalu pastikan data tampil setelah redirect dan tetap tampil setelah halaman dimuat ulang.

Pemeriksaan sintaks PHP dapat dijalankan dari terminal dengan `php -l pertemuan-08/index.php`.
