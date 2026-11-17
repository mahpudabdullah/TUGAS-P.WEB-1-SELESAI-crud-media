<?php
require_once __DIR__ . "/../../auth.php";
require_once __DIR__ . "/../../koneksi.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, nim, nama, program_studi, email, foto, audio, dokumen FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    die("Data mahasiswa tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit CRUD Media</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="style_media.css">
</head>
<body>
    <header>
        <h1>Edit Data Media</h1>
        <p>PHP File Update + Old File Management</p>
    </header>
    <nav>
        <a href="../../dashboard.php">Dashboard</a>
        <a href="../../index.php">Biodata</a>
        <a href="../../layout.php">Layout Lab</a>
        <a href="../../data_mahasiswa.php">Data Mahasiswa</a>
        <a href="../index.php">CRUD Mahasiswa</a>
        <a href="index.php">CRUD Media</a>
        <a href="../../logout.php" style="color: red; font-weight: bold;">Logout</a>
    </nav>
    <main>
        <section>
            <form 
                class="student-form" 
                data-media-form 
                data-require-foto="false" 
                action="../../proses/crud-media/update.php" 
                method="POST" 
                enctype="multipart/form-data" 
                novalidate
            >
                <input type="hidden" name="id" value="<?= (int) $row["id"]; ?>">

                <label for="nim">NIM</label>
                <input id="nim" name="nim" type="text" value="<?= htmlspecialchars($row["nim"]); ?>" required>
                <small class="form-error" id="errorNim" style="color: red;"></small>

                <label for="nama">Nama</label>
                <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($row["nama"]); ?>" required>
                <small class="form-error" id="errorNama" style="color: red;"></small>

                <label for="program_studi">Program Studi</label>
                <input id="program_studi" name="program_studi" type="text" value="<?= htmlspecialchars($row["program_studi"]); ?>" required>
                <small class="form-error" id="errorProdi" style="color: red;"></small>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?= htmlspecialchars($row["email"]); ?>" required>
                <small class="form-error" id="errorEmail" style="color: red;"></small>

                <label for="foto">Foto Baru (opsional, biarkan kosong jika tidak diganti)</label>
                <?php if (!empty($row["foto"])): ?>
                    <div class="current-media">
                        <span>Foto saat ini:</span><br>
                        <img class="table-photo" src="../../uploads/images/<?= htmlspecialchars($row["foto"]); ?>" alt="Foto">
                    </div>
                <?php endif; ?>
                <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp">
                <small class="form-error" id="errorFoto" style="color: red;"></small>
                
                <div class="media-preview-box">
                    <strong>Preview Foto Baru</strong>
                    <img id="previewFoto" class="media-preview-image" alt="Preview foto" hidden>
                </div>

                <label for="audio">Audio Baru (opsional)</label>
                <?php if (!empty($row["audio"])): ?>
                    <div class="current-media">
                        <span>Audio saat ini:</span><br>
                        <audio controls class="table-audio">
                            <source src="../../uploads/audio/<?= htmlspecialchars($row["audio"]); ?>">
                        </audio>
                    </div>
                <?php endif; ?>
                <input id="audio" name="audio" type="file" accept="audio/mpeg,audio/wav">
                
                <div class="media-preview-box">
                    <strong>Preview Audio Baru</strong>
                    <audio id="previewAudio" class="media-preview-audio" controls hidden></audio>
                </div>

                <label for="dokumen">Dokumen PDF Baru (opsional)</label>
                <?php if (!empty($row["dokumen"])): ?>
                    <div class="current-media">
                        <span>Dokumen saat ini: <a href="../../uploads/documents/<?= htmlspecialchars($row["dokumen"]); ?>" target="_blank">Buka PDF</a></span>
                    </div>
                <?php endif; ?>
                <input id="dokumen" name="dokumen" type="file" accept="application/pdf">
                <p id="previewDokumen" class="file-hint">Belum ada dokumen baru dipilih.</p>

                <div class="form-actions" style="margin-top: 20px; display: flex; align-items: center; gap: 12px;">
                    <button type="submit" style="padding: 10px 16px; background-color: #007bff; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Perbarui Data Media</button>
                    <a href="index.php" style="color: #1a1a2e; text-decoration: none; font-weight: bold;">Batal</a>
                </div>
            </form>
        </section>
    </main>
    <script src="../../asset/js/media.js"></script>
</body>
</html>