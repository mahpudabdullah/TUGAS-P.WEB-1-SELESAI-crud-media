<?php
require_once __DIR__ . "/../../auth.php";
require_once __DIR__ . "/../../koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../crud/crud-media/index.php");
    exit;
}

$id = isset($_POST["id"]) ? (int) $_POST["id"] : 0;
if ($id <= 0) {
    die("ID tidak valid.");
}

$nim = trim($_POST["nim"] ?? "");
$nama = trim($_POST["nama"] ?? "");
$program_studi = trim($_POST["program_studi"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($nim === "" || $nama === "" || $program_studi === "" || $email === "") {
    die("Semua field teks wajib diisi.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid.");
}

// Ambil data lama untuk pengecekan file eksisting
$stmtOld = $conn->prepare("SELECT foto, audio, dokumen FROM mahasiswa WHERE id = ?");
$stmtOld->bind_param("i", $id);
$stmtOld->execute();
$oldData = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$oldData) {
    die("Data tidak ditemukan.");
}

$rootUpload = __DIR__ . "/../../uploads";
$imageDir = $rootUpload . "/images";
$audioDir = $rootUpload . "/audio";
$documentDir = $rootUpload . "/documents";

$allowedImage = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
$allowedAudio = ["audio/mpeg" => "mp3", "audio/wav" => "wav"];
$allowedDocument = ["application/pdf" => "pdf"];
$maxSize = 20 * 1024 * 1024; // 20 MB

$newFoto = null;
$newAudio = null;
$newDokumen = null;

try {
    // Upload foto baru jika ada
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $newFoto = uploadMedia($_FILES["foto"], $allowedImage, $maxSize, $imageDir, "img");
    }

    // Upload audio baru jika ada
    if (isset($_FILES["audio"]) && $_FILES["audio"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $newAudio = uploadMedia($_FILES["audio"], $allowedAudio, $maxSize, $audioDir, "aud");
    }

    // Upload dokumen baru jika ada
    if (isset($_FILES["dokumen"]) && $_FILES["dokumen"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $newDokumen = uploadMedia($_FILES["dokumen"], $allowedDocument, $maxSize, $documentDir, "doc");
    }

    // Tentukan nilai kolom file (jika ada file baru pakai file baru, jika tidak tetap pakai yang lama)
    $fotoFinal = $newFoto ?? $oldData["foto"];
    $audioFinal = $newAudio ?? $oldData["audio"];
    $dokumenFinal = $newDokumen ?? $oldData["dokumen"];

    $stmt = $conn->prepare(
        "UPDATE mahasiswa SET nim = ?, nama = ?, program_studi = ?, email = ?, foto = ?, audio = ?, dokumen = ? WHERE id = ?"
    );
    $stmt->bind_param("sssssssi", $nim, $nama, $program_studi, $email, $fotoFinal, $audioFinal, $dokumenFinal, $id);

    if (!$stmt->execute()) {
        throw new RuntimeException("Gagal memperbarui data ke database.");
    }
    $stmt->close();

    // Hapus file lama fisik jika diganti dengan file baru yang sukses ter-upload
    if ($newFoto && $oldData["foto"]) {
        hapusMediaJikaAda($oldData["foto"], $imageDir);
    }
    if ($newAudio && $oldData["audio"]) {
        hapusMediaJikaAda($oldData["audio"], $audioDir);
    }
    if ($newDokumen && $oldData["dokumen"]) {
        hapusMediaJikaAda($oldData["dokumen"], $documentDir);
    }

    $conn->close();
    header("Location: ../../crud/crud-media/index.php?status=update");
    exit;

} catch (RuntimeException $e) {
    // Cleanup file baru jika transaksi gagal
    hapusMediaJikaAda($newFoto, $imageDir);
    hapusMediaJikaAda($newAudio, $audioDir);
    hapusMediaJikaAda($newDokumen, $documentDir);

    die("Pembaruan gagal: " . htmlspecialchars($e->getMessage()));
}