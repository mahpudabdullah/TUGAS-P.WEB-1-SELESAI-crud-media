<?php 
require_once "koneksi.php";

$username = "operator";
$password = "operator123";
$nama_lengkap = "Operator Akademik";

// Cek apakah username sudah ada
$cek = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$cek->bind_param("s", $username);
$cek->execute();
$hasil_cek = $cek->get_result();

if ($hasil_cek->num_rows > 0) {
    die("User operator sudah ada di database. Silakan langsung login di <a href='login.php'>login.php</a>");
}

// Enkripsi password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Masukkan ke database
$stmt = $conn->prepare("INSERT INTO users (username, password_hash, nama_lengkap) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashed_password, $nama_lengkap);

if ($stmt->execute()){
    echo "User operator berhasil dibuat! Silakan login di <a href='login.php'>login.php</a>";
} else {
    echo "Gagal: " . $stmt->error;
}

$stmt->close();
$cek->close();
$conn->close();
