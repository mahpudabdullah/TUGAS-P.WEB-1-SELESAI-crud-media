<?php
require_once __DIR__ . "/../../auth.php";
require_once __DIR__ . "/../../koneksi.php";

$sql = "SELECT id, nim, nama, program_studi, email, foto, audio, dokumen 
        FROM mahasiswa 
        ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Media</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="style_media.css">
</head>
<body>
    <header>
        <h1>Web Programming 1</h1>
        <!-- TAMPILKAN NAMA USER DI SINI -->
    <span style="color: white; margin-left: 0px;">
        👤 Halo, <strong><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></strong>
    </span>
      <p>Praktikum Pemrograman Web</p>
    </header>
    <nav>
        <a href="../../dashboard.php">Dashboard</a>
        <a href="../../index.php">Biodata</a>
        <a href="../../layout.php">Layout Lab</a>
        <a href="../../data_mahasiswa.php">Data Mahasiswa</a>
        <a href="../../form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../../index.php">CRUD Mahasiswa</a>
        <a href="index.php">CRUD Media</a>
        <a href="../proses/logout.php" style="color: red; font-weight: bold;">Logout</a>
    </nav>
    <main>
        <section>
            <div class="crud-toolbar" style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <a class="btn" href="tambah.php" style="padding: 10px 16px; background-color: #14d969; color: #16213e; text-decoration: none; border-radius: 8px; font-weight: bold;">+ Tambah Data Media</a>
                <input 
                    type="search" 
                    id="searchMedia" 
                    placeholder="Cari NIM, nama, prodi, email..."
                    style="padding: 10px 12px; width: 300px; border: 1px solid #332222; border-radius: 6px;"
                >
            </div>
            
            <div class="table-scroll">
                <table class="data-table" id="mediaTable" style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: #1a1a2e; color: #000000; text-align: left;">
                            <th style="padding: 12px;">No</th>
                            <th style="padding: 12px;">Foto</th>
                            <th style="padding: 12px;">NIM</th>
                            <th style="padding: 12px;">Nama</th>
                            <th style="padding: 12px;">Program Studi</th>
                            <th style="padding: 12px;">Email</th>
                            <th style="padding: 12px;">Audio</th>
                            <th style="padding: 12px;">Dokumen</th>
                            <th style="padding: 12px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;"><?= $no++; ?></td>
                            <td style="padding: 12px;">
                                <?php if (!empty($row["foto"])): ?>
                                    <img src="/WEB_PROGRAMMING_MISAYU/pertemuan1-selesai/uploads/images/<?php echo $row['foto']; ?>
                                    " alt="Foto" width="60" style="object-fit: cover;"> 
                                
                                    <!-- <img 
                                        class="table-photo"  src="../../uploads/images/
                                        alt="Foto" width="60" 
                                    > -->
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px;"><?= htmlspecialchars($row["nim"]); ?></td>
                            <td style="padding: 12px;"><?= htmlspecialchars($row["nama"]); ?></td>
                            <td style="padding: 12px;"><?= htmlspecialchars($row["program_studi"]); ?></td>
                            <td style="padding: 12px;"><?= htmlspecialchars($row["email"]); ?></td>
                            <td style="padding: 12px;">
                                <?php if (!empty($row["audio"])): ?>
                                    <audio controls preload="none" class="table-audio">
                                        <source src="../../uploads/audio/<?= htmlspecialchars($row["audio"]); ?>">
                                    </audio>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px;">
                                <?php if (!empty($row["dokumen"])): ?>
                                    <a href="../../uploads/documents/<?= htmlspecialchars($row["dokumen"]); ?>" target="_blank" rel="noopener">Buka PDF</a>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px;" class="actions">
                                <a href="edit.php?id=<?= (int) $row["id"]; ?>" style="margin-right: 8px; color: #007bff; text-decoration: none; font-weight: bold;">Edit</a>
                                <form action="../../proses/crud-media/hapus.php" method="POST" class="media-delete-form" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= (int) $row["id"]; ?>">
                                    <button type="submit" class="btn-delete" style="background: #ff4d4d; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script src="../asset/js/media.js"></script>
</body>
</html>