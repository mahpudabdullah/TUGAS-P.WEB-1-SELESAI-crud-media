<?php
require_once __DIR__ . "/../../auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah CRUD Media</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="style_media.css">
</head>
<body>
    <header>
        <h1>Tambah Data Media</h1>
        <p>PHP File Upload + JavaScript DOM Preview</p>
    </header>
    <?php
        $errorMsg = $_GET["error"] ?? "";
    ?>
    <main>
        <section>
            <?php if (!empty($errorMsg)): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #f5c6cb;">
                     <?= htmlspecialchars($errorMsg); ?>
                </div>
            <?php endif; ?>
            <form 
                class="student-form" 
                data-media-form 
                data-require-foto="true" 
                action="../../proses/crud-media/tambah.php" 
                method="POST" 
                enctype="multipart/form-data" 
                novalidate>

                <label for="nim">NIM</label>
                <input id="nim" name="nim" type="text" required>
                <small class="form-error" id="errorNim" style="color: red;"></small>

                <label for="nama">Nama</label>
                <input id="nama" name="nama" type="text" required>
                <small class="form-error" id="errorNama" style="color: red;"></small>

                <label for="program_studi">Program Studi</label>
                <input id="program_studi" name="program_studi" type="text" required>
                <small class="form-error" id="errorProdi" style="color: red;"></small>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>
                <small class="form-error" id="errorEmail" style="color: red;"></small>

                <label for="foto">Foto (wajib, JPG/PNG/WEBP, maks. 20 MB)</label>
                <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp" required>
                <small class="form-error" id="errorFoto" style="color: red;"></small>
                
                <div class="media-preview-box">
                    <strong>Preview Foto</strong>
                    <img id="previewFoto" class="media-preview-image" alt="Preview foto" hidden>
                </div>

                <label for="audio">Audio (optional, MP3/WAV, maks. 20 MB)</label>
                <input id="audio" name="audio" type="file" accept="audio/mpeg,audio/wav">
                
                <div class="media-preview-box">
                    <strong>Preview Audio</strong>
                    <audio id="previewAudio" class="media-preview-audio" controls hidden></audio>
                </div>

                <label for="dokumen">Dokumen (optional, PDF, maks. 20 MB)</label>
                <input id="dokumen" name="dokumen" type="file" accept="application/pdf">
                <p id="previewDokumen" class="file-hint">Belum ada dokumen dipilih.</p>

                <div class="form-actions" style="margin-top: 20px; display: flex; align-items: center; gap: 12px;">
                    <button type="submit" style="padding: 10px 16px; background-color: #14d969; color: #16213e;
                     border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Simpan Data Media</button>
                     
                    <a href="index.php" style="color: #1a1a2e; text-decoration: none; font-weight: bold;">Batal</a>
                </div>
            </form>
        </section>
    </main>
    <script src="../../asset/js/media.js"></script>
</body>
</html>