# Pertemuan 10 
Nama Basis Data : db_pwd_2611500025
Nama tabel : tbl_kontak_2611500025
1. menyalin artefak pertemuan 9, sebagai baselane ke pertemuan 10, dan hasilnya masih sama dengan artefak pertemuan ke 9
2. Membuka PhpMyadmin, PhpMyadmin dapat dibuka dan digunakan
3. Mengidentifikasi data formulir, kedelapan data tersebut
sesuai dengan atribut name dan jenis input yang tersedia pada kode yang diberikan
4. Menganalisis data untuk disimpan ke basis data.
- Kedelapan data tersebut sudah sesuai dengan elemen input yang ada pada bagian formulir Kontak di `pertemuan-10\index.php`.
- Informasi bagian profil mahasiswa (seperti NIM, nama mahasiswa, dan program studi pada bagian profil) dipastikan tidak dimasukkan sebagai bagian dari data formulir Kontak yang disimpan ke basis data.
Mencocokkan kedelapan data yang akan disimpan dengan elemen formulir pada pertemuan -10 \index.php .
Memeriksa kembali kode formulir pada pertemuan - 10 \index.php , dan memastikan kedua checkbox menggunakan atribut name="minat[]" dan memiliki nilai HTML serta CSS.
## Rancangan Atribut dan Tipe Data (`tbl_kontak_2611500025`)

| No | Atribut | Tipe Data | Keterangan |
|---|---|---|---|
| 1 | nama | VARCHAR(50) | Menyimpan nama lengkap, maksimal 50 karakter. |
| 2 | email | VARCHAR(255) | Menyimpan alamat email. |
| 3 | semester | TINYINT | Menyimpan nomor semester. |
| 4 | tanggal | DATE | Menyimpan tanggal kunjungan. |
| 5 | jenis_pesan | VARCHAR(20) | Menyimpan jenis pesan (pertanyaan/saran). |
| 6 | minat | VARCHAR(50) | Menyimpan pilihan minat sebagai teks. |
| 7 | program studi | VARCHAR(2) | Menyimpan kode program studi (TI). |
| 8 | pesan | VARCHAR(300) | Menyimpan isi pesan, maksimal 300 karakter. |
## D.3. Primary Key dan AUTO_INCREMENT

- **Atribut:** `id`
- **Tipe Data:** `INT`
- **Ketentuan:** `PRIMARY KEY`, `AUTO_INCREMENT`
- **Keterangan:** Identitas unik otomatis untuk membedakan setiap baris data kontak..
## D.4. Rancangan Akhir Struktur Tabel (`tbl_kontak_2611500025`)

| No | Atribut | Tipe Data | Ketentuan |
|---|---|---|---|
| 1 | id | INT | PRIMARY KEY, AUTO_INCREMENT |
| 2 | nama | VARCHAR(50) | - |
| 3 | email | VARCHAR(255) | - |
| 4 | semester | TINYINT | - |
| 5 | tanggal | DATE | - |
| 6 | jenis_pesan | VARCHAR(20) | - |
| 7 | minat | VARCHAR(50) | - |
| 8 | program Studi | VARCHAR(2) | - |
| 9 | pesan | VARCHAR(300) | - |
## E.1. Membuka phpMyAdmin

- Layanan Apache dan MySQL pada Laragon telah berjalan.
- Halaman phpMyAdmin (`http://localhost/phpmyadmin`) berhasil dibuka dan menampilkan antarmuka pengelolaan basis data MySQL.
## E.2. Membuat Basis Data

- **Nama Basis Data:** `db_pwd_2611500025`
- **Status Pengujian:** Basis data berhasil dibuat melalui menu Databases di phpMyAdmin menggunakan collation bawaan dan sudah muncul pada daftar basis data.
formulir pembuatan tabel menampilkan nama tabel yang benar dan menyediakan sembilan kolom untuk diisi.