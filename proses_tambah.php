<?php
// Hubungkan ke file koneksi
include 'koneksi.php';

// Cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Ambil dan bersihkan data dari form
    $nim     = trim($_POST['nim']);
    $nama    = trim($_POST['nama']);
    $jurusan = trim($_POST['jurusan']);
    $email   = trim($_POST['email']);

    // 1. Validasi: Memastikan tidak ada field yang kosong
    if (empty($nim) || empty($nama) || empty($jurusan) || empty($email)) {
        $pesan = "Semua field data mahasiswa wajib diisi!";
        header("Location: form_mahasiswa.php?error=" . urlencode($pesan));
        exit();
    }

    // 2. Validasi BARU: Memastikan NIM harus berupa angka (numerik)
    if (!is_numeric($nim)) {
        $pesan = "NIM harus berupa angka!";
        header("Location: form_mahasiswa.php?error=" . urlencode($pesan));
        exit();
    }

    // 3. Validasi: Memastikan format email valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pesan = "Format email tidak valid! Harap masukkan email yang benar.";
        header("Location: form_mahasiswa.php?error=" . urlencode($pesan));
        exit();
    }

    // 4. Validasi: Mencegah Program Studi diisi angka/selain teks
    if (is_numeric($jurusan)) {
        $pesan = "Program Studi harus berupa nama jurusan, bukan angka!";
        header("Location: form_mahasiswa.php?error=" . urlencode($pesan));
        exit();
    }

    // Jika semua validasi lolos, masukkan data ke database menggunakan variabel $conn dan kolom program_studi
    $query = "INSERT INTO mahasiswa (nim, nama, program_studi, email) VALUES ('$nim', '$nama', '$jurusan', '$email')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika berhasil, arahkan ke halaman data mahasiswa
        header("Location: data_mahasiswa.php?status=sukses");
        exit();
    } else {
        // Tampilkan pesan error jika query gagal
        echo "Gagal menyimpan ke database: " . mysqli_error($conn);
        exit();
    }
} else {
    // Jika file diakses langsung tanpa lewat form
    header("Location: form_mahasiswa.php");
    exit();
}
?>