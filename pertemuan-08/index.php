<?php
session_start()

function escape($value)
{
	return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

function postString($key)
{
	return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : "";
}

function validDate($value)
{
	$date = DateTime::createFromFormat("!Y-m-d", $value);
	return $date !== false && $date->format("Y-m-d") === $value;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$formType = postString("form_type");

	if ($formType === "rencana") {
		$activity = [
			"nama_kegiatan" => postString("nama_kegiatan"),
			"kategori_kegiatan" => postString("kategori_kegiatan"),
			"tanggal_pelaksanaan" => postString("tanggal_pelaksanaan"),
			"lokasi_kegiatan" => postString("lokasi_kegiatan"),
			"deskripsi_kegiatan" => postString("deskripsi_kegiatan"),
		];
		$errors = [];
		$categories = ["Akademik", "Organisasi", "Olahraga", "Seni & Budaya", "Pengabdian Masyarakat"];

		if (mb_strlen($activity["nama_kegiatan"]) < 3) {
			$errors[] = "Nama kegiatan minimal 3 karakter.";
		}
		if (!in_array($activity["kategori_kegiatan"], $categories, true)) {
			$errors[] = "Pilih kategori kegiatan yang valid.";
		}
		if (!validDate($activity["tanggal_pelaksanaan"])) {
			$errors[] = "Tanggal pelaksanaan tidak valid.";
		}
		if ($activity["lokasi_kegiatan"] === "") {
			$errors[] = "Lokasi kegiatan wajib diisi.";
		}
		if (mb_strlen($activity["deskripsi_kegiatan"]) < 10) {
			$errors[] = "Deskripsi kegiatan minimal 10 karakter.";
		}

		if ($errors) {
			$_SESSION["rkm_errors"] = $errors;
			$_SESSION["rkm_old_input"] = $activity;
		} else {
			$_SESSION["rkm_list"] ??= [];
			$_SESSION["rkm_list"][] = $activity;
			unset($_SESSION["rkm_errors"], $_SESSION["rkm_old_input"]);
		}

		header("Location: index.php#rencana-kegiatan");
		exit;
	}

	if ($formType === "contact") {
		$interests = $_POST["minat"] ?? [];
		if (!is_array($interests)) {
			$interests = [];
		}
		$contact = [
			"nama" => postString("nama"),
			"email" => postString("email"),
			"semester" => postString("semester"),
			"tanggal" => postString("tanggal"),
			"jenis_pesan" => postString("jenis_pesan"),
			"minat" => array_values(array_filter($interests, "is_string")),
			"prodi" => postString("prodi"),
			"pesan" => postString("pesan"),
		];
		$errors = [];

		if (mb_strlen($contact["nama"]) < 3 || mb_strlen($contact["nama"]) > 50) {
			$errors[] = "Nama lengkap harus diisi 3 sampai 50 karakter.";
		}
		if (!filter_var($contact["email"], FILTER_VALIDATE_EMAIL)) {
			$errors[] = "Masukkan alamat email yang valid.";
		}
		if (filter_var($contact["semester"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 14]]) === false) {
			$errors[] = "Semester harus diisi dengan angka 1 sampai 14.";
		}
		if (!validDate($contact["tanggal"])) {
			$errors[] = "Tanggal kunjungan tidak valid.";
		}
		if (!in_array($contact["jenis_pesan"], ["pertanyaan", "saran"], true)) {
			$errors[] = "Pilih jenis pesan yang valid.";
		}
		$contact["minat"] = array_values(array_intersect($contact["minat"], ["HTML", "CSS"]));
		if (!$contact["minat"]) {
			$errors[] = "Pilih minimal satu topik yang diminati.";
		}
		if (!in_array($contact["prodi"], ["SI", "TI"], true)) {
			$errors[] = "Pilih program studi yang valid.";
		}
		if (mb_strlen($contact["pesan"]) < 1 || mb_strlen($contact["pesan"]) > 300) {
			$errors[] = "Pesan harus diisi dan maksimal 300 karakter.";
		}

		if ($errors) {
			$_SESSION["contact_errors"] = $errors;
			$_SESSION["contact_old_input"] = $contact;
		} else {
			$_SESSION["contact_data"] = $contact;
			$_SESSION["nama"] = $contact["nama"];
			$_SESSION["email"] = $contact["email"];
			$_SESSION["semester"] = $contact["semester"];
			$_SESSION["tanggal"] = $contact["tanggal"];
			$_SESSION["jenis_pesan"] = $contact["jenis_pesan"];
			$_SESSION["minat"] = $contact["minat"];
			$_SESSION["prodi"] = $contact["prodi"];
			$_SESSION["pesan"] = $contact["pesan"];
			unset($_SESSION["contact_errors"], $_SESSION["contact_old_input"]);
		}

		header("Location: index.php#contact");
		exit;
	}

	$_SESSION["form_errors"] = ["Formulir tidak dikenal."];
	header("Location: index.php");
	exit;
}

$rkmErrors = $_SESSION["rkm_errors"] ?? [];
$rkmOldInput = $_SESSION["rkm_old_input"] ?? [];
$contactErrors = $_SESSION["contact_errors"] ?? [];
$contactOldInput = $_SESSION["contact_old_input"] ?? [];
$formErrors = $_SESSION["form_errors"] ?? [];
unset(
	$_SESSION["rkm_errors"],
	$_SESSION["rkm_old_input"],
	$_SESSION["contact_errors"],
	$_SESSION["contact_old_input"],
	$_SESSION["form_errors"]
);
$rkmList = $_SESSION["rkm_list"] ?? [];
$contactData = $_SESSION["contact_data"] ?? null;
if (!$contactData && isset($_SESSION["nama"])) {
	$contactData = [
		"nama" => $_SESSION["nama"],
		"email" => $_SESSION["email"] ?? "",
		"semester" => $_SESSION["semester"] ?? "",
		"tanggal" => $_SESSION["tanggal"] ?? "",
		"jenis_pesan" => $_SESSION["jenis_pesan"] ?? "",
		"minat" => $_SESSION["minat"] ?? [],
		"prodi" => $_SESSION["prodi"] ?? "",
		"pesan" => $_SESSION["pesan"] ?? "",
	];
	$contactData["minat"] = is_array($contactData["minat"]) ? $contactData["minat"] : [];
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

		<section id="rencana-kegiatan" class="section-box">
			<h2>Rencana Kegiatan Mahasiswa</h2>
			<p>Isi formulir berikut untuk mengajukan rencana kegiatan mahasiswa.</p>

			<?php if ($rkmErrors): ?>
				<div class="form-feedback-error" role="alert">
					<ul>
						<?php foreach ($rkmErrors as $error): ?>
							<li><?= escape($error) ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<form id="form-rencana-kegiatan" action="index.php#rencana-kegiatan" method="post" data-validation="rencana" novalidate>
				<input type="hidden" name="form_type" value="rencana">
				<div class="form-group">
					<label for="nama_kegiatan">Nama Kegiatan</label>
					<input class="input-form" type="text" name="nama_kegiatan" id="nama_kegiatan" minlength="3" required value="<?= escape($rkmOldInput["nama_kegiatan"] ?? "") ?>">
				</div>
				<div class="form-group">
					<label for="kategori_kegiatan">Kategori Kegiatan</label>
					<select class="input-form" name="kategori_kegiatan" id="kategori_kegiatan" required>
						<option value="">-- Pilih Kategori --</option>
						<?php foreach (["Akademik", "Organisasi", "Olahraga", "Seni & Budaya", "Pengabdian Masyarakat"] as $category): ?>
							<option value="<?= escape($category) ?>" <?= ($rkmOldInput["kategori_kegiatan"] ?? "") === $category ? "selected" : "" ?>><?= escape($category) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="tanggal_pelaksanaan">Tanggal Pelaksanaan</label>
					<input class="input-form" type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" required value="<?= escape($rkmOldInput["tanggal_pelaksanaan"] ?? "") ?>">
				</div>
				<div class="form-group">
					<label for="lokasi_kegiatan">Lokasi Kegiatan</label>
					<input class="input-form" type="text" name="lokasi_kegiatan" id="lokasi_kegiatan" required value="<?= escape($rkmOldInput["lokasi_kegiatan"] ?? "") ?>">
				</div>
				<div class="form-group">
					<label for="deskripsi_kegiatan">Deskripsi Kegiatan</label>
					<textarea class="input-form" name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="5" minlength="10" required><?= escape($rkmOldInput["deskripsi_kegiatan"] ?? "") ?></textarea>
				</div>
				<p id="js-error-message" class="form-feedback" aria-live="polite"></p>
				<button type="submit">Kirim Rencana</button>
				<button type="reset">Batal</button>
			</form>

			<h3>Daftar Rencana Kegiatan</h3>
			<?php if (!$rkmList): ?>
				<p>Belum ada rencana kegiatan yang dikirim.</p>
			<?php else: ?>
				<div class="submission-result">
					<?php foreach ($rkmList as $index => $activity): ?>
						<article>
							<h4><?= escape($activity["nama_kegiatan"]) ?></h4>
							<p><strong>Kategori:</strong> <?= escape($activity["kategori_kegiatan"]) ?></p>
							<p><strong>Tanggal:</strong> <?= escape($activity["tanggal_pelaksanaan"]) ?></p>
							<p><strong>Lokasi:</strong> <?= escape($activity["lokasi_kegiatan"]) ?></p>
							<p><strong>Deskripsi:</strong> <?= nl2br(escape($activity["deskripsi_kegiatan"])) ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>

		<section id="contact">
			<h2>Kontak</h2>
			<?php if ($formErrors): ?>
				<div class="form-feedback-error" role="alert">
					<?php foreach ($formErrors as $error): ?>
						<p><?= escape($error) ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<p>
				Kunjungi
				<a target="_blank" href="https://github.com/<?= PROFIL_GITHUB ?>">profil GitHub saya</a>.
			</p>

			<?php if ($contactErrors): ?>
				<div class="form-feedback-error" role="alert">
					<ul>
						<?php foreach ($contactErrors as $error): ?>
							<li><?= escape($error) ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<form id="contactForm" class="js-contact-form" data-validation="contact" action="index.php#contact" method="post" novalidate>
				<input type="hidden" name="form_type" value="contact">
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
						required
						value="<?= escape($contactOldInput["nama"] ?? "") ?>" />
				</div>

				<div class="form-group">
					<label for="email">Email</label><br />

					<input class="input-form" type="email" id="email" name="email" placeholder="nama@email.com" required value="<?= escape($contactOldInput["email"] ?? "") ?>" />
				</div>

				<div class="form-group">
					<label for="semester">Semester</label><br />

					<input class="input-form" type="number" id="semester" name="semester" min="1" max="14" required value="<?= escape($contactOldInput["semester"] ?? "") ?>" />
				</div>

				<div class="form-group">
					<label for="tanggal">Tanggal Kunjungan</label><br />

					<input class="input-form" type="date" id="tanggal" name="tanggal" required value="<?= escape($contactOldInput["tanggal"] ?? "") ?>" />
				</div>

				<div class="form-group">
					<p>Jenis Pesan</p>

					<input type="radio" id="pertanyaan" name="jenis_pesan" value="pertanyaan" required <?= ($contactOldInput["jenis_pesan"] ?? "") === "pertanyaan" ? "checked" : "" ?> />
					<label for="pertanyaan">Pertanyaan</label>

					<input type="radio" id="saran" name="jenis_pesan" value="saran" <?= ($contactOldInput["jenis_pesan"] ?? "") === "saran" ? "checked" : "" ?> />
					<label for="saran">Saran</label>
				</div>

				<div class="form-group">
					<p>Topik yang Diminati</p>

					<input type="checkbox" id="minat-html" name="minat[]" value="HTML" <?= in_array("HTML", $contactOldInput["minat"] ?? [], true) ? "checked" : "" ?> />
					<label for="minat-html">HTML</label>

					<input type="checkbox" id="minat-css" name="minat[]" value="CSS" <?= in_array("CSS", $contactOldInput["minat"] ?? [], true) ? "checked" : "" ?> />
					<label for="minat-css">CSS</label>
				</div>

				<div class="form-group">
					<label for="prodi">Program Studi</label><br />

					<select class="input-form" id="prodi" name="prodi" required>
						<option value="">-- Pilih Program Studi --</option>
						<option value="SI" <?= ($contactOldInput["prodi"] ?? "") === "SI" ? "selected" : "" ?>>Sistem Informasi</option>
						<option value="TI" <?= ($contactOldInput["prodi"] ?? "") === "TI" ? "selected" : "" ?>>Teknik Informatika</option>
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
						required><?= escape($contactOldInput["pesan"] ?? "") ?></textarea>
				</div>

				<button type="submit">Kirim</button>
				<button type="reset">Batal</button>
				<p class="form-feedback" data-form-feedback aria-live="polite"></p>
			</form>

			<?php if ($contactData): ?>
				<article id="hasilKontak" class="submission-result" aria-live="polite">
					<h3>Data Formulir yang Dikirim</h3>
					<p><strong>Nama Lengkap:</strong> <?= escape($contactData["nama"]) ?></p>
					<p><strong>Email:</strong> <?= escape($contactData["email"]) ?></p>
					<p><strong>Semester:</strong> <?= escape($contactData["semester"]) ?></p>
					<p><strong>Tanggal Kunjungan:</strong> <?= escape($contactData["tanggal"]) ?></p>
					<p><strong>Jenis Pesan:</strong> <?= escape($contactData["jenis_pesan"]) ?></p>
					<p><strong>Topik yang Diminati:</strong> <?= escape(implode(", ", $contactData["minat"])) ?></p>
					<p><strong>Program Studi:</strong> <?= escape($contactData["prodi"]) ?></p>
					<p><strong>Pesan:</strong> <?= nl2br(escape($contactData["pesan"])) ?></p>
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