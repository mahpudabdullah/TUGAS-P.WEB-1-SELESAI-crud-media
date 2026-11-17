<?php
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Biodata mahasiswa - Web Programming 1">
  <title>Biodata | Web Programming 1</title>
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
    <a href="index.php" class="active">Biodata</a>
    <a href="layout.php">Layout Lab</a>
    <a href="data_mahasiswa.php">Data Mahasiswa</a>
    <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
    <a href="crud/index.php">CRUD mahasiswa</a>
    <a href="crud/crud-media/index.php">CRUD Media</a>
    <a href="logout.php" style="color: red; font-weight: bold;">Logout</a>
  </nav>
  <main>
    <section>
      <h2>Biodata Mahasiswa</h2>
      <table class="data-table">
        <tbody>
          <tr>
            <th scope="row">Nama</th>
            <td>MAHPUD</td>
          </tr>
          <tr>
            <th scope="row">NIM</th>
            <td>4112755201250145</td>
          </tr>
          <tr>
            <th scope="row">Program Studi</th>
            <td>Informatika</td>
          </tr>
          <tr>
            <th scope="row">Email</th>
            <td>MD@gmail.com</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
  <footer>
    <p> &copy Copyright mahpud</p>

  </footer>
</body>

</html>