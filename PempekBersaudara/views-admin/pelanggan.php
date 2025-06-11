<?php
    session_start();
    include '../database/koneksi.php';

    $query = "SELECT * FROM pelanggan ORDER BY id_pelanggan ASC";
    $result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-pelanggan.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Daftar Pelanggan</title>
</head>
<body>
    <!-- menu.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-pelanggan">
        <div class="pelanggan-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-group icon'></i>
                    <span class="text">Pelanggan</span>
                </div>

                <div class="top">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" placeholder="Search here...">
                    </div>
                </div>
                
                <div class="activity">
                    <table class="pelanggan-table">
                        <thead>
                            <tr>
                                <th>ID Pelanggan</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Username</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td class="center"><?= htmlspecialchars($row['id_pelanggan']) ?></td>
                                <td class="center"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                <td class="center"><?= htmlspecialchars($row['no_telepon']) ?></td>
                                <td class="center"><?= htmlspecialchars($row['email']) ?></td>
                                
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>