<?php
require_once __DIR__ . "/../../auth.php";
require_once __DIR__ . "/../../koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

$id = isset($_POST["id"]) ? (int) $_POST["id"] : 0;
if ($id <= 0) {
    header("Location: ../../crud/crud-media/index.php?status=error");
    exit;
}

// Ambil data file media yang terkait sebelum record dihapus
$stmt = $conn->prepare("SELECT foto, audio, dokumen FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($data) {
    // Tentukan direktori upload fisik
    $rootUpload = __DIR__ . "/../../uploads";
    $imageDir = $rootUpload . "/images";
    $audioDir = $rootUpload . "/audio";
    $documentDir = $rootUpload . "/documents";

    // Hapus file fisik jika ada
    if (!empty($data["foto"])) {
        hapusMediaJikaAda($data["foto"], $imageDir);
    }
    if (!empty($data["audio"])) {
        hapusMediaJikaAda($data["audio"], $audioDir);
    }
    if (!empty($data["dokumen"])) {
        hapusMediaJikaAda($data["dokumen"], $documentDir);
    }

    // Hapus record dari database
    $stmtDel = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmtDel->bind_param("i", $id);
    $stmtDel->execute();
    $stmtDel->close();
}

$conn->close();
header("Location: ../../crud/crud-media/index.php?status=hapus");
exit;