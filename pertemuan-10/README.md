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
## E.3. Membuat Basis Data
formulir pembuatan tabel menampilkan nama tabel yang benar dan menyediakan sembilan kolom untuk diisi.
## E.4. Mengisi Struktur Sembilan Kolom

- **Nama Tabel:** `tbl_kontak_nim`
- **Jumlah Kolom:** 9 kolom (`id`, `nama`, `email`, `semester`, `tanggal`, `jenis_pesan`, `minat`, `prodi`, `pesan`).
- **Status Pengujian:** Struktur tabel berhasil disimpan di phpMyAdmin. Kolom `id` sudah ditetapkan sebagai `PRIMARY KEY` dengan `AUTO_INCREMENT`, serta seluruh nama atribut, tipe data, dan panjang `VARCHAR` telah sesuai dengan rancangan.

## E.5. Mengenal Perintah DDL (`CREATE DATABASE` dan `CREATE TABLE`)

Perintah DDL (*Data Definition Language*) merupakan bentuk query SQL asli dari langkah pembuatan basis data dan tabel yang sebelumnya dilakukan melalui antarmuka klik di phpMyAdmin (E.2 sampai E.4):

1. **`CREATE DATABASE db_pwd_2611500025;`** — Mewakili proses pembuatan basis data baru (langkah E.2).
2. **`USE db_pwd_nim;`** — Mewakili proses pemilihan/pengaktifan basis data sebelum membuat tabel (langkah E.3).
3. **`CREATE TABLE tbl_kontak_2611500025 (...);`** — Mewakili proses pembuatan tabel beserta 9 atribut, tipe data, panjang karakter, `PRIMARY KEY`, dan `AUTO_INCREMENT` (langkah E.3 dan E.4).

### Perintah SQL Lengkap:

```sql
CREATE DATABASE db_pwd_nim;

USE db_pwd_nim;

CREATE TABLE tbl_kontak_nim (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(50),
    email VARCHAR(255),
    semester TINYINT,
    tanggal DATE,
    jenis_pesan VARCHAR(20),
    minat VARCHAR(50),
    prodi VARCHAR(2),
    pesan VARCHAR(300)
);
## E.6. Memeriksa Struktur Tabel (`DESCRIBE`)

Pemeriksaan struktur akhir tabel `tbl_kontak_nim` dilakukan melalui tab **Structure** dan perintah SQL `DESCRIBE tbl_kontak_nim;`:

| Field | Type | Key | Extra |
|---|---|---|---|
| id | int | PRI | auto_increment |
| nama | varchar(50) | | |
| email | varchar(255) | | |
| semester | tinyint | | |
| tanggal | date | | |
| jenis_pesan | varchar(20) | | |
| minat | varchar(50) | | |
| prodi | varchar(2) | | |
| pesan | varchar(300) | | |

- **Hasil Pemeriksaan:** Seluruh 9 kolom, tipe data, panjang karakter, serta `PRIMARY KEY` dan `AUTO_INCREMENT` pada kolom `id` sudah sesuai rancangan dan siap digunakan pada Bagian F.
## F.1.
Mencoba memasukkan data, dan berhasil. Dan memeriksa kembali nilai yang diisikan pada setiap atribut.
## F.2. Mengenal Perintah SQL `INSERT` (DML)

Perintah DML (*Data Manipulation Language*) `INSERT INTO` digunakan untuk menambahkan baris data baru ke tabel melalui tab SQL di phpMyAdmin:

```sql
INSERT INTO tbl_kontak_nim
(nama, email, semester, tanggal, jenis_pesan, minat, prodi, pesan)
VALUES
('Andi', 'andi@example.com', 2, '2026-11-15', 'pertanyaan', 'HTML, CSS', 'TI', 'Saya ingin belajar pemrograman web.');
# F.3. Memeriksa Data Menggunakan Fasilitas Browse

- **Hasil Pemeriksaan:** Seluruh data awal dari langkah F.1 dan F.2 telah ditampilkan pada tab **Browse** tabel `tbl_kontak_nim`. Nilai setiap atribut lengkap sesuai input, kolom `id` terisi secara otomatis (`AUTO_INCREMENT`), dan kolom `minat` ditampilkan sebagai teks dengan benar.