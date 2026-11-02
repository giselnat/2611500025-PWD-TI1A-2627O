<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// 1. Normalisasi / Sanitasi Masukan Context-Aware
$nama_kegiatan = trim($_POST['nama_kegiatan'] ?? '');
$kategori      = trim($_POST['kategori'] ?? '');
$tanggal       = trim($_POST['tanggal'] ?? '');
$lokasi        = trim($_POST['lokasi'] ?? '');
$deskripsi     = trim($_POST['deskripsi'] ?? '');

$errors = [];

// 2. Validasi Sisi Peladen (Server-Side)
if (empty($nama_kegiatan)) {
    $errors[] = "Nama kegiatan wajib diisi.";
} elseif (mb_strlen($nama_kegiatan) < 3) {
    $errors[] = "Nama kegiatan minimal 3 karakter.";
}

$kategori_valid = ['Akademik', 'Organisasi', 'Pengabdian', 'Lomba'];
if (empty($kategori)) {
    $errors[] = "Kategori kegiatan wajib dipilih.";
} elseif (!in_array($kategori, $kategori_valid, true)) {
    $errors[] = "Kategori kegiatan tidak valid.";
}

if (empty($tanggal)) {
    $errors[] = "Tanggal pelaksanaan wajib diisi.";
} else {
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!($d && $d->format('Y-m-d') === $tanggal)) {
        $errors[] = "Format tanggal tidak valid.";
    }
}

if (empty($lokasi)) {
    $errors[] = "Lokasi kegiatan wajib diisi.";
}

if (empty($deskripsi)) {
    $errors[] = "Deskripsi kegiatan wajib diisi.";
} elseif (mb_strlen($deskripsi) < 10) {
    $errors[] = "Deskripsi kegiatan minimal 10 karakter.";
}

// 3. Implementasi Pola Post-Redirect-Get (PRG)
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old_input'] = [
        'nama_kegiatan' => $nama_kegiatan,
        'kategori'      => $kategori,
        'tanggal'       => $tanggal,
        'lokasi'        => $lokasi,
        'deskripsi'     => $deskripsi
    ];
} else {
    if (!isset($_SESSION['rkm_list'])) {
        $_SESSION['rkm_list'] = [];
    }

    $_SESSION['rkm_list'][] = [
        'nama_kegiatan' => $nama_kegiatan,
        'kategori'      => $kategori,
        'tanggal'       => $tanggal,
        'lokasi'        => $lokasi,
        'deskripsi'     => $deskripsi
    ];
}

// Redirect kembali ke index.php pada section RKM (Pola PRG)
header('Location: index.php#rkm');
exit;

<?php
session_start();

// P7: Memproses data formulir dan menyimpannya ke dalam session.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$nama = trim((string) ($_POST["nama"] ?? ""));
	$email = trim((string) ($_POST["email"] ?? ""));
	$semesterForm = trim((string) ($_POST["semester"] ?? ""));
	$tanggal = trim((string) ($_POST["tanggal"] ?? ""));
	$jenisPesan = trim((string) ($_POST["jenis_pesan"] ?? ""));
	$minat = $_POST["minat"] ?? [];
	$prodi = trim((string) ($_POST["prodi"] ?? ""));
	$pesan = trim((string) ($_POST["pesan"] ?? ""));

	// Checkbox dapat mengirimkan lebih dari satu nilai.
	if (!is_array($minat)) {
		$minat = [];
	}

	// Menyimpan setiap nilai formulir ke dalam session secara terpisah.
	$_SESSION["nama"] = $nama;
	$_SESSION["email"] = $email;
	$_SESSION["semester"] = $semesterForm;
	$_SESSION["tanggal"] = $tanggal;
	$_SESSION["jenis_pesan"] = $jenisPesan;
	$_SESSION["minat"] = $minat;
	$_SESSION["prodi"] = $prodi;
	$_SESSION["pesan"] = $pesan;

	// PRG: mencegah pengiriman POST berulang ketika halaman dimuat ulang.
	header("Location: index.php#contact");
	exit;
}

// Mengamankan data sebelum ditampilkan kembali ke halaman HTML.
// P6: PHP dasar dan pemrograman sisi peladen
// Bagian 1: Variabel dan konstanta
$nim = "2611500025";
$namaMahasiswa = "Giselle Anastasia";
$programStudi = "TI";
$tahunAkademik = "2026/2027";
$semester = 1;
$ipk = 0.00;
$statusAktif = true;
$catatanTambahan = null;

const NAMA_MATA_KULIAH = "Pemrograman Web Dasar";
const PROFIL_GITHUB = "satpamal";

// Bagian 2: Operator
$batasSemester = 8;
$sisaSemester = $batasSemester - $semester;
$semesterValid = $semester >= 1 && $semester <= $batasSemester;
$statusSemester = ($semesterValid && $statusAktif) ? "Sesuai rentang" : "Perlu diperiksa";

// Bagian 3: Percabangan if-elseif-else
if ($semester < 3) {
	$keteranganSemester = "Semester awal";
} elseif ($semester <= 6) {
	$keteranganSemester = "Semester menengah";
} else {
	$keteranganSemester = "Semester akhir";
}

$namaProdi = ($programStudi == "SI") ? "Sistem Informasi" : (($programStudi == "TI") ? "Teknik Informatika" : "Lainnya");

// Bagian 4: Percabangan switch-case-default
switch ($programStudi) {
	case "SI":
		$fokusProgramStudi = "Sistem informasi dan proses bisnis";
		break;
	case "TI":
		$fokusProgramStudi = "Komputasi dan pengembangan perangkat lunak";
		break;
	default:
		$fokusProgramStudi = "Belum ditentukan";
}
?>
<!doctype html>
<html lang="id">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Profil Mahasiswa</title>
	<link rel="stylesheet" href="style.css" />
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
				<li><a href="#rencana-kegiatan">Rencana Kegiatan</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<section id="home">
			<h2>Selamat Datang</h2>
			<p>Halo, saya <strong><?php echo $namaMahasiswa; ?></strong>. Saya sedang mempelajari matakuliah <strong><?php print NAMA_MATA_KULIAH; ?></strong> pada tahun akademik <?php echo $tahunAkademik; ?>.</p>

			<main>
    <section id="home">
      <h1>Selamat Datang</h1>
    </section>

    <!-- SECTION BARU SEBAGAI TARGET NAVIGASI -->
    <section id="rencana-kegiatan">
      <h2>Rencana Kegiatan</h2>
      <p>Berikut adalah daftar agenda kegiatan kami:</p>
      <ul>
        <li>Pelatihan Pemrograman Web</li>
        <li>Workshop Versi Git & GitHub</li>
        <li>Evaluasi Proyek Akhir</li>
      </ul>
    </section>
  </main>

</body>
</html>
			<img src="img/foto-profil.jpg" alt="Foto profil Nama Mahasiswa" />
		</section>

		<section id="about">
			<h2>Tentang Saya</h2>

			<article>
				<h3>Profil Singkat</h3>
				<p>Program Studi: <?php echo $namaProdi . " (" . $programStudi . ")"; ?></p>
				<p>Fokus program studi: <?php echo $fokusProgramStudi; ?></p>
				<p>Status mahasiswa: <?php echo $statusAktif ? "Aktif" : "Tidak aktif"; ?></p>
				<p>Semester: <?php echo $semester . " (" . $keteranganSemester . ")"; ?></p>
				<p>Sisa semester hingga batas: <?php echo $sisaSemester; ?></p>
				<p>Pemeriksaan rentang semester: <?php echo $statusSemester; ?></p>
				<p>IPK: <?php echo number_format($ipk, 2, ',', '.'); ?></p>
				<p>Catatan tambahan: <?php echo $catatanTambahan === null ? "Belum ada" : $catatanTambahan; ?></p>

				<h3>Target Belajar (Perulangan for)</h3>
				<ol>
					<?php
					// Perulangan for tanpa array; materi larik dibahas pada P9.
					for ($i = 1; $i <= 5; $i++) {
						echo "<li>Target belajar ke-" . $i . ": ";
						switch ($i) {
							case 1:
								echo "Memahami sintaks dasar PHP.";
								break;
							case 2:
								echo "Menggunakan variabel dan konstanta.";
								break;
							case 3:
								echo "Menerapkan operator dan percabangan.";
								break;
							case 4:
								echo "Menggunakan perulangan for dan while.";
								break;
							default:
								echo "Belum dipetakan";
								break;
						}
						echo "</li>";
					}
					?>
				</ol>

				<h3>Semester (Perulangan while):</h3>
				<ol>
					<?php
					$nomorSemester = 1;
					while ($nomorSemester <= 3) {
						echo "<li>Semester " . $nomorSemester . "</li>";
						$nomorSemester++; // operator penugasan
					}
					?>
				</ol>
			</article>
		</section>

		<section id="rencana-kegiatan" class="contact section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Rencana Kegiatan Mahasiswa</h2>
    <p>Silakan isi formulir di bawah ini untuk mengajukan rencana kegiatan mahasiswa baru.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 justify-content-center">
      <div class="col-lg-8">
        
        <form action="index.php#rencana-kegiatan" method="POST" role="form" class="php-email-form">
          <div class="row gy-4">

            <!-- 1. Input Nama Kegiatan -->
            <div class="col-md-6 form-group">
              <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
              <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" placeholder="Masukkan nama kegiatan" required>
            </div>

            <!-- 2. Input Kategori Kegiatan -->
            <div class="col-md-6 form-group">
              <label for="kategori_kegiatan" class="form-label">Kategori Kegiatan</label>
              <select name="kategori_kegiatan" id="kategori_kegiatan" class="form-select" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option value="Akademik">Akademik</option>
                <option value="Organisasi">Organisasi</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Seni & Budaya">Seni & Budaya</option>
                <option value="Pengabdian Masyarakat">Pengabdian Masyarakat</option>
              </select>
            </div>

            <!-- 3. Input Tanggal Pelaksanaan -->
            <div class="col-md-6 form-group">
              <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
              <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control" required>
            </div>

            <!-- 4. Input Lokasi Kegiatan -->
            <div class="col-md-6 form-group">
              <label for="lokasi_kegiatan" class="form-label">Lokasi Kegiatan</label>
              <input type="text" name="lokasi_kegiatan" id="lokasi_kegiatan" class="form-control" placeholder="Masukkan lokasi kegiatan" required>
            </div>

            <!-- 5. Input Deskripsi Kegiatan -->
            <div class="col-md-12 form-group">
              <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
              <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" rows="5" placeholder="Tuliskan deskripsi ringkas mengenai kegiatan" required></textarea>
            </div>

            <!-- Tombol Kirim & Batal -->
            <div class="col-md-12 text-center mt-4">
              <button type="submit" name="submit_rencana" class="btn btn-primary px-4 me-2">Kirim</button>
              <button type="reset" class="btn btn-secondary px-4">Batal</button>
            </div>

          </div>
        </form>

      </div>
    </div>
  </div>
</section>

		<section id="contact">
			<h2>Kontak</h2>

			<p>
				Kunjungi
				<a target="_blank" href="https://github.com/<?= PROFIL_GITHUB ?>">profil GitHub saya</a>.
			</p>

			<form id="contactForm" class="js-contact-form" data-validation="contact" action="index.php" method="post" novalidate>
				<div class="form-group">
					<label for="nama">Nama Lengkap</label><br />

					<input
						class="input-form"
						type="text"
						id="nama"
						name="nama"
						placeholder="Masukkan nama lengkap"
						minlength="3"
						maxlength="50"
						required />
				</div>

				<div class="form-group">
					<label for="email">Email</label><br />

					<input class="input-form" type="email" id="email" name="email" placeholder="nama@email.com" required />
				</div>

				<div class="form-group">
					<label for="semester">Semester</label><br />

					<input class="input-form" type="number" id="semester" name="semester" min="1" max="14" required />
				</div>

				<div class="form-group">
					<label for="tanggal">Tanggal Kunjungan</label><br />

					<input class="input-form" type="date" id="tanggal" name="tanggal" required />
				</div>

				<div class="form-group">
					<p>Jenis Pesan</p>

					<input type="radio" id="pertanyaan" name="jenis_pesan" value="pertanyaan" required />
					<label for="pertanyaan">Pertanyaan</label>

					<input type="radio" id="saran" name="jenis_pesan" value="saran" />
					<label for="saran">Saran</label>
				</div>

				<div class="form-group">
					<p>Topik yang Diminati</p>

					<input type="checkbox" id="minat-html" name="minat[]" value="HTML" />
					<label for="minat-html">HTML</label>

					<input type="checkbox" id="minat-css" name="minat[]" value="CSS" />
					<label for="minat-css">CSS</label>
				</div>

				<div class="form-group">
					<label for="prodi">Program Studi</label><br />

					<select class="input-form" id="prodi" name="prodi" required>
						<option value="">-- Pilih Program Studi --</option>
						<option value="SI">Sistem Informasi</option>
						<option value="TI">Teknik Informatika</option>
					</select>
				</div>

				<div class="form-group">
					<label for="pesan">Pesan</label><br />

					<textarea
						class="input-form"
						id="pesan"
						name="pesan"
						maxlength="300"
						placeholder="Tulis pesan Anda"
						required></textarea>
				</div>

				<button type="submit">Kirim</button>
				<button type="reset">Batal</button>
				<p class="form-feedback" data-form-feedback aria-live="polite"></p>
			</form>

			<?php if (isset($_SESSION["nama"])): ?>
				<article id="hasilKontak" class="submission-result" aria-live="polite">
					<h3>Data Formulir yang Dikirim</h3>
					<p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($_SESSION["nama"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["email"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Semester:</strong> <?= htmlspecialchars($_SESSION["semester"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Tanggal Kunjungan:</strong> <?= htmlspecialchars($_SESSION["tanggal"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Jenis Pesan:</strong> <?= htmlspecialchars($_SESSION["jenis_pesan"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Topik yang Diminati:</strong>
						<?= htmlspecialchars(implode(", ", $_SESSION["minat"] ?? []), ENT_QUOTES, "UTF-8") ?>
					</p>
					<p><strong>Program Studi:</strong> <?= htmlspecialchars($_SESSION["prodi"] ?? "", ENT_QUOTES, "UTF-8") ?></p>
					<p><strong>Pesan:</strong> <?= nl2br(htmlspecialchars($_SESSION["pesan"] ?? "", ENT_QUOTES, "UTF-8")) ?></p>
				</article>
			<?php endif; ?>
		</section>
	</main>

	<footer>
		<p>&copy; <?= date("Y") ?> <?php echo $namaMahasiswa; ?> [<?= $nim ?>]</p>
	</footer>
	<script src="script.js"></script>
</body>

</html>