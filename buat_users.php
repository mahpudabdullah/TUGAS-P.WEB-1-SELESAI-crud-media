<?php 
require_once "koneksi.php";

$username = "admin";
$password = "admin123";
$nama_lengkap = "administrator";

$username = "operator";
$password = "operator123";
$nama_lengkap = "Operator Akademik";

$cek = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$cek->bind_param("s", $username);
$cek->execute();
$hasil_cek = $cek->get_result();

if ($hasil_cek->num_rows > 0) {
    die("User admin sudah ada. Silakan lanjut ke halaman <a href='login.php'>login.php</a>");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (username, password_hash, nama_lengkap) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $username, $hashed_password, $nama_lengkap);

if ($stmt->execute()){
    echo "User berhasil dibuat. Silakan lanjut ke halaman <a href='login.php'>login.php</a>";
} else {
    echo "Gagal membuat user: " . $stmt->error;
}

$stmt->close();
$cek->close();
$conn->close();
?>