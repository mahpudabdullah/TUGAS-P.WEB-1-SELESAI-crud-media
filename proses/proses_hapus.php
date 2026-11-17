<?php
require_once "../auth.php";
require_once "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../crud/index.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
if ($id <= 0) {
    die("ID tidak valid.");
}

$stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: ../crud/index.php?status=hapus");
exit;