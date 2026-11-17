<?php
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Form tambah data mahasiswa - Web Programming 1">
  <title>Tambah Mahasiswa | Web Programming 1</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Web Programming 1</h1>
    <span style="color: white; margin-left: 0px;">
        👤 Halo, <strong><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></strong>
    </span>
    <p>Praktikum Pemrograman Web</p>
  </header>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="index.php">Biodata</a>
    <a href="layout.php">Layout Lab</a>
    <a href="data_mahasiswa.php">Data Mahasiswa</a>
    <a href="form_mahasiswa.php" class="active">Tambah Mahasiswa</a>
    <a href="crud/index.php">CRUD mahasiswa</a>
    <a href="crud/crud-media/index.php">CRUD Media</a>
    <a href="logout.php" style="color: red; font-weight: bold;">Logout</a>
  </nav>
  <main>
    <section>
      <h2>Form Data Mahasiswa</h2>
      <form action="proses_tambah.php" method="POST" class="student-form">
        <label for="nim">NIM</label>
        <input id="nim" name="nim" type="text" pattern="[0-9]*" placeholder="Contoh: 230001" required>

        <label for="nama">Nama</label>
        <input id="nama" name="nama" type="text" pattern="[A-Za-z\s]+" placeholder="Nama lengkap mahasiswa" required>

        <label for="program_studi">Program Studi</label>
        <select name="jurusan" required>
            <option value="">-- Pilih Program Studi --</option>
            <option value="Informatika">Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Sistem Informasi">Teknologi Informasi</option>
        </select>

        <label for="email">Email</label>
        <input type="email" id="email" name="email"  placeholder="contoh@email.com" required>

        <div class="simpan-data">
        <button type="submit" name="submit">Simpan Data</button>
        </div>
      </form>
    </section>
  </main>
  <footer>
    <p>Web Programming 1</p>
  </footer>
</body>
</html>
