<?php
require_once __DIR__ . "/../../auth.php";
require_once __DIR__ . "/../../koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../crud/crud-media/index.php");
    exit;
}

$nim = trim($_POST["nim"] ?? "");
$nama = trim($_POST["nama"] ?? "");
$program_studi = trim($_POST["program_studi"] ?? "");
$email = trim($_POST["email"] ?? "");

// Validasi field teks kosong
if ($nim === "" || $nama === "" || $program_studi === "" || $email === "") {
    header("Location: ../../crud/crud-media/tambah.php?error=SEMUA+DATA+WAJIB+DIISI");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../../crud/crud-media/tambah.php?error=Format+email+tidak+valid");
    exit;
}

$rootUpload = __DIR__ . "/../../uploads";
$imageDir = $rootUpload . "/images";
$audioDir = $rootUpload . "/audio";
$documentDir = $rootUpload . "/documents";

$allowedImage = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
$allowedAudio = ["audio/mpeg" => "mp3", "audio/wav" => "wav"];
$allowedDocument = ["application/pdf" => "pdf"];
$maxSize = 20 * 1024 * 1024; // 20 MB

$namaFoto = null;
$namaAudio = null;
$namaDokumen = null;

try {
    // Foto wajib di-upload
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $namaFoto = uploadMedia($_FILES["foto"], $allowedImage, $maxSize, $imageDir, "img");
    } else {
        throw new RuntimeException("Foto wajib di-upload.");
    }

    // Audio opsional
    if (isset($_FILES["audio"]) && $_FILES["audio"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $namaAudio = uploadMedia($_FILES["audio"], $allowedAudio, $maxSize, $audioDir, "aud");
    }

    // Dokumen opsional
    if (isset($_FILES["dokumen"]) && $_FILES["dokumen"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $namaDokumen = uploadMedia($_FILES["dokumen"], $allowedDocument, $maxSize, $documentDir, "doc");
    }

    $stmt = $conn->prepare(
        "INSERT INTO mahasiswa (nim, nama, program_studi, email, foto, audio, dokumen) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssssss", $nim, $nama, $program_studi, $email, $namaFoto, $namaAudio, $namaDokumen);

    if (!$stmt->execute()) {
        throw new RuntimeException("Gagal menyimpan data ke database.");
    }

    $stmt->close();
    $conn->close();

    header("Location: ../../crud/crud-media/index.php?status=tambah");
    exit;

} catch (RuntimeException $e) {
    hapusMediaJikaAda($namaFoto, $imageDir);
    hapusMediaJikaAda($namaAudio, $audioDir);
    hapusMediaJikaAda($namaDokumen, $documentDir);

    $errMsg = urlencode($e->getMessage());
    header("Location: ../../crud/crud-media/tambah.php?error=$errMsg");
    exit;
}