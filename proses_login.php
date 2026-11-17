<?php
session_start();
require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    header("Location: login.php?error=1");
    exit;
}

// Ambil data user berdasarkan username
$stmt = $conn->prepare("SELECT id, username, password_hash, nama_lengkap FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verifikasi password yang diinput dengan hash di database
    if (password_verify($password, $user["password_hash"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["nama_lengkap"] = $user["nama_lengkap"];
        
        // Berhasil login, arahkan ke data mahasiswa
        header("Location: dashboard.php");
        exit;
    }
}

// Jika username tidak ketemu atau password salah
header("Location: login.php?error=1");
exit;
?>