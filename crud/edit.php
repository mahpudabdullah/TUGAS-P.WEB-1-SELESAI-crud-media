<?php
require_once "../auth.php";
require_once "../koneksi.php";

$id = (int) ($_GET["id"] ?? 0);
if ($id <= 0) {
    die("ID tidak valid.");
}

$stmt = $conn->prepare("SELECT id, nim, nama, program_studi, email FROM mahasiswa WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$mahasiswa = $stmt->get_result()->fetch_assoc();

if (!$mahasiswa) {
    die("Data mahasiswa tidak ditemukan.");
}
?>  
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Web Programming 1</h1>
        <!-- TAMPILKAN NAMA USER DI SINI -->
        <span style="color: white; margin-left: 0px;">
            👤 Halo, <strong><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></strong>
        </span>
        <p>Praktikum Pemrograman Web</p>
    </header>
    <nav>
        <a href="../dashboard.php">Dashboard</a>
        <a href="../index.php">Biodata</a>
        <a href="../layout.php">Layout Lab</a>
        <a href="../data_mahasiswa.php">Data Mahasiswa</a>
        <a href="../form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="index.php">CRUD mahasiswa</a>
        <a href="../proses/logout.php" style="color: red; font-weight: bold;">Logout</a>
    </nav>
    <main>
        <section>
            <form class="student-form" data-crud-form action="../proses/proses_update.php" method="POST" novalidate>
                <input type="hidden" name="id" value="<?= $mahasiswa["id"]; ?>">

                <label for="nim">NIM</label>
                <input id="nim" name="nim" type="text" value="<?= htmlspecialchars($mahasiswa["nim"]); ?>">
                <small class="form-error" id="errorNim"></small>

                <label for="nama">Nama</label>
                <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($mahasiswa["nama"]); ?>">
                <small class="form-error" id="errorNama"></small>

                <label for="program_studi">Program Studi</label>
                <input id="program_studi" name="program_studi" type="text" value="<?= htmlspecialchars($mahasiswa["program_studi"]); ?>">
                <small class="form-error" id="errorProdi"></small>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?= htmlspecialchars($mahasiswa["email"]); ?>">
                <small class="form-error" id="errorEmail"></small>

                <div class="form-actions">
                    <button type="submit">Update Data</button>
                    <a href="index.php">Batal</a>
                </div>
            </form>
        </section>
    </main>
    <script src="../asset/js/crud.js"></script>
</body>
<footer></footer>
</html>