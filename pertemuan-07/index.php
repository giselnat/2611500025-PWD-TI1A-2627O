<?php
session_start();

function escapeHtml($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$nama = '';
$email = '';
$semesterForm = '';
$jenisPesan = '';
$prodi = '';
$pesan = '';
$tanggal = '';
$minat = [];
$pesanKesalahan = [];
$pesanBerhasil = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $semesterForm = trim((string) ($_POST['semester'] ?? ''));
    $jenisPesan = trim((string) ($_POST['jenis_pesan'] ?? ''));
    $prodi = trim((string) ($_POST['prodi'] ?? ''));
    $pesan = trim((string) ($_POST['pesan'] ?? ''));
    $tanggal = trim((string) ($_POST['tanggal'] ?? ''));
    $minatInput = $_POST['minat'] ?? [];
    $minatDiizinkan = ['HTML', 'CSS'];

    if ($nama === '' || strlen($nama) < 3 || strlen($nama) > 50) {
        $pesanKesalahan[] = 'Nama lengkap wajib diisi antara 3 dan 50 karakter.';
    }
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $pesanKesalahan[] = 'Masukkan alamat email yang valid.';
    }

    $semesterAngka = filter_var($semesterForm, FILTER_VALIDATE_INT);
    if ($semesterAngka === false || $semesterAngka < 1 || $semesterAngka > 14) {
        $pesanKesalahan[] = 'Semester harus berupa bilangan bulat antara 1 dan 14.';
    }

    $tanggalObjek = DateTime::createFromFormat('!Y-m-d', $tanggal);
    if (
        $tanggalObjek === false ||
        $tanggalObjek->format('Y-m-d') !== $tanggal
    ) {
        $pesanKesalahan[] = 'Tanggal kunjungan tidak valid.';
    }
    if (!in_array($jenisPesan, ['pertanyaan', 'saran'], true)) {
        $pesanKesalahan[] = 'Pilih jenis pesan yang valid.';
    }
    if (!in_array($prodi, ['SI', 'TI'], true)) {
        $pesanKesalahan[] = 'Pilih program studi yang valid.';
    }
    if (!is_array($minatInput)) {
        $pesanKesalahan[] = 'Format pilihan topik tidak valid.';
        $minat = [];
    } else {
        $minat = array_values(array_intersect($minatInput, $minatDiizinkan));
        if (count($minat) !== count($minatInput)) {
            $pesanKesalahan[] = 'Pilihan topik tidak valid.';
        }
        if ($minat === []) {
            $pesanKesalahan[] = 'Pilih minimal satu topik yang diminati.';
        }
    }
    if ($pesan === '' || strlen($pesan) > 300) {
        $pesanKesalahan[] = 'Pesan wajib diisi dan maksimal 300 karakter.';
    }

    $_SESSION['form'] = [
        'nama' => $nama,
        'email' => $email,
        'semester' => $semesterForm,
        'jenis_pesan' => $jenisPesan,
        'prodi' => $prodi,
        'pesan' => $pesan,
        'tanggal' => $tanggal,
        'minat' => $minat,
    ];
    $_SESSION['pesanKesalahan'] = $pesanKesalahan;
    $_SESSION['pesanBerhasil'] = $pesanKesalahan === [];

    header('Location: index.php');
    exit;
}

$form = $_SESSION['form'] ?? [];
$nama = $form['nama'] ?? '';
$email = $form['email'] ?? '';
$semesterForm = $form['semester'] ?? '';
$jenisPesan = $form['jenis_pesan'] ?? '';
$prodi = $form['prodi'] ?? '';
$pesan = $form['pesan'] ?? '';
$tanggal = $form['tanggal'] ?? '';
$minat = $form['minat'] ?? [];
$pesanKesalahan = $_SESSION['pesanKesalahan'] ?? [];
$pesanBerhasil = $_SESSION['pesanBerhasil'] ?? false;
unset($_SESSION['pesanKesalahan'], $_SESSION['pesanBerhasil']);

$nim = '2611500025';
$namaMahasiswa = 'Gisell anastasia';
$programStudi = 'TI';
$tahunAkademik = '2026/2027';
$semester = 1;
$ipk = 0.00;
$statusAktif = true;
$catatanTambahan = null;
const NAMA_MATA_KULIAH = 'Pemrograman Web Dasar';
const PROFIL_GITHUB = 'giselnat';

$batasSemester = 8;
$sisaSemester = $batasSemester - $semester;
$semesterValid = $semester >= 1 && $semester <= $batasSemester;
$statusSemester = ($semesterValid && $statusAktif) ? 'Sesuai rentang' : 'Perlu diperiksa';

if ($semester < 3) {
    $keteranganSemester = 'Semester awal';
} elseif ($semester <= 6) {
    $keteranganSemester = 'Semester menengah';
} else {
    $keteranganSemester = 'Semester akhir';
}

$namaProdi = $programStudi === 'SI'
    ? 'Sistem Informasi'
    : ($programStudi === 'TI' ? 'Teknik Informatika' : 'Lainnya');

switch ($programStudi) {
    case 'SI':
        $fokusProgramStudi = 'Sistem informasi dan proses bisnis';
        break;
    case 'TI':
        $fokusProgramStudi = 'Komputasi dan pengembangan perangkat lunak';
        break;
    default:
        $fokusProgramStudi = 'Belum ditentukan';
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="header-top">
        <h1>Profil Mahasiswa</h1>
        <button
            class="nav-toggle"
            id="navToggle"
            type="button"
            aria-label="Buka navigasi"
            aria-controls="navMenu"
            aria-expanded="false">
            &#9776;
        </button>
    </div>
    <nav>
        <ul id="navMenu">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
    </nav>
</header>
<main>
    <section id="home">
        <h2>Selamat Datang</h2>
        <p>Halo, saya <strong><?= escapeHtml($namaMahasiswa) ?></strong>. Saya sedang mempelajari
            matakuliah <strong><?= escapeHtml(NAMA_MATA_KULIAH) ?></strong> pada tahun akademik
            <?= escapeHtml($tahunAkademik) ?>.</p>
        <img src="img/foto-profil.jpg" alt="Foto profil <?= escapeHtml($namaMahasiswa) ?>">
    </section>
    <section id="about">
        <h2>Tentang Saya</h2>
        <article>
            <h3>Profil Singkat</h3>
            <p>Program Studi: <?= escapeHtml($namaProdi . ' (' . $programStudi . ')') ?></p>
            <p>Fokus program studi: <?= escapeHtml($fokusProgramStudi) ?></p>
            <p>Status mahasiswa: <?= $statusAktif ? 'Aktif' : 'Tidak aktif' ?></p>
            <p>Semester: <?= escapeHtml($semester . ' (' . $keteranganSemester . ')') ?></p>
            <p>Sisa semester hingga batas: <?= escapeHtml($sisaSemester) ?></p>
            <p>Pemeriksaan rentang semester: <?= escapeHtml($statusSemester) ?></p>
            <p>IPK: <?= number_format($ipk, 2, ',', '.') ?></p>
            <p>Catatan tambahan: <?= escapeHtml($catatanTambahan ?? 'Belum ada') ?></p>
            <h3>Target Belajar (Perulangan for)</h3>
            <ol>
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo '<li>Target belajar ke-' . $i . ': ';
                    switch ($i) {
                        case 1:
                            echo 'Memahami sintaks dasar PHP.';
                            break;
                        case 2:
                            echo 'Menggunakan variabel dan konstanta.';
                            break;
                        case 3:
                            echo 'Menerapkan operator dan percabangan.';
                            break;
                        case 4:
                            echo 'Menggunakan perulangan for dan while.';
                            break;
                        default:
                            echo 'Belum dipetakan';
                    }
                    echo '</li>';
                }
                ?>
            </ol>
            <h3>Semester (Perulangan while):</h3>
            <ol>
                <?php
                $nomorSemester = 1;
                while ($nomorSemester <= 3) {
                    echo '<li>Semester ' . $nomorSemester . '</li>';
                    $nomorSemester++;
                }
                ?>
            </ol>
        </article>
    </section>
    <section id="contact">
        <h2>Kontak</h2>
        <p>Kunjungi <a target="_blank" rel="noopener noreferrer"
            href="https://github.com/<?= escapeHtml(PROFIL_GITHUB) ?>">profil GitHub saya</a>.</p>

        <?php if ($pesanKesalahan !== []): ?>
            <div class="form-feedback-error" role="alert">
                <ul>
                    <?php foreach ($pesanKesalahan as $kesalahan): ?>
                        <li><?= escapeHtml($kesalahan) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($pesanBerhasil): ?>
            <p class="form-feedback-success" role="status">
                Form berhasil dikirim. Terima kasih, <?= escapeHtml($nama) ?>.
            </p>
        <?php endif; ?>

        <form id="contactForm" action="index.php" method="post" novalidate>
            <div class="form-group">
                <label for="nama">Nama Lengkap</label><br>
                <input class="input-form" type="text" id="nama" name="nama"
                    placeholder="Masukkan nama lengkap" minlength="3" maxlength="50"
                    value="<?= escapeHtml($nama) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label><br>
                <input class="input-form" type="email" id="email" name="email"
                    placeholder="nama@email.com" value="<?= escapeHtml($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label><br>
                <input class="input-form" type="number" id="semester" name="semester"
                    min="1" max="14" value="<?= escapeHtml($semesterForm) ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal Kunjungan</label><br>
                <input class="input-form" type="date" id="tanggal" name="tanggal"
                    value="<?= escapeHtml($tanggal) ?>" required>
            </div>
            <div class="form-group">
                <p>Jenis Pesan</p>
                <input type="radio" id="pertanyaan" name="jenis_pesan" value="pertanyaan"
                    <?= $jenisPesan === 'pertanyaan' ? 'checked' : '' ?> required>
                <label for="pertanyaan">Pertanyaan</label>
                <input type="radio" id="saran" name="jenis_pesan" value="saran"
                    <?= $jenisPesan === 'saran' ? 'checked' : '' ?>>
                <label for="saran">Saran</label>
            </div>
            <div class="form-group">
                <p>Topik yang Diminati</p>
                <input type="checkbox" id="minat-html" name="minat[]" value="HTML"
                    <?= in_array('HTML', $minat, true) ? 'checked' : '' ?>>
                <label for="minat-html">HTML</label>
                <input type="checkbox" id="minat-css" name="minat[]" value="CSS"
                    <?= in_array('CSS', $minat, true) ? 'checked' : '' ?>>
                <label for="minat-css">CSS</label>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label><br>
                <select class="input-form" id="prodi" name="prodi" required>
                    <option value="">-- Pilih Program Studi --</option>
                    <option value="SI" <?= $prodi === 'SI' ? 'selected' : '' ?>>Sistem Informasi</option>
                    <option value="TI" <?= $prodi === 'TI' ? 'selected' : '' ?>>Teknik Informatika</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pesan">Pesan</label><br>
                <textarea class="input-form" id="pesan" name="pesan" maxlength="300"
                    placeholder="Tulis pesan Anda" required><?= escapeHtml($pesan) ?></textarea>
            </div>
            <button type="submit">Kirim</button>
            <button type="reset">Batal</button>
            <p id="formFeedback" aria-live="polite"></p>
        </form>

        <?php if ($pesanBerhasil): ?>
            <section aria-labelledby="hasilForm">
                <h3 id="hasilForm">Ringkasan Pesan</h3>
                <p>Nama: <?= escapeHtml($nama) ?></p>
                <p>Email: <?= escapeHtml($email) ?></p>
                <p>Semester: <?= escapeHtml($semesterForm) ?></p>
                <p>Tanggal kunjungan: <?= escapeHtml($tanggal) ?></p>
                <p>Jenis pesan: <?= escapeHtml($jenisPesan) ?></p>
                <p>Program studi: <?= escapeHtml($prodi) ?></p>
                <p>Topik: <?= escapeHtml(implode(', ', $minat)) ?></p>
                <p>Pesan: <?= escapeHtml($pesan) ?></p>
            </section>
        <?php endif; ?>
    </section>
</main>
<footer>
    <p>&copy; <?= date('Y') ?> <?= escapeHtml($namaMahasiswa) ?> [<?= escapeHtml($nim) ?>]</p>
</footer>
<script src="script.js"></script>
</body>
</html>