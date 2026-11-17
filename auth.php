<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah memiliki session login atau belum
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>