<?php
    include '../database/koneksi.php';
    include '../proses/4.detail-menu.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-detailMenu.css">    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Detail Menu</title>
</head>
<body>
    <!-- Detail menu.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-detailMenu">
        <div class="detail-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-info-circle'></i>
                    <span class="text">Detail Menu</span>
                </div>

                <div class="top">
                    <div class="kembal">
                        <a href="menu.php" class="btn-kembali">
                            <i class='bx bx-arrow-back'></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="detail-box">
                    <div class="info-box">
                        <table>
                            <tr>
                                <td><strong>Nama Menu</strong></td>
                                <td>:</td>
                                <td><?= $menu['nama_menu'] ?></td>
                            </tr>

                            <tr>
                                <td><strong>Harga Menu</strong></td>
                                <td>:</td>
                                <td>Rp <?= number_format($menu['harga_menu'], 0, ',', '.') ?></td>
                            </tr>

                            <tr>
                                <td><strong>QTY</strong></td>
                                <td>:</td>
                                <td><?= $menu['jumlah_tersedia'] ?></td>
                            </tr>                            

                            <tr>
                                <td><strong>Total Terjual</strong></td>
                                <td>:</td>
                                <td><?= $menu['total_terjual'] ?> terjual</td>
                            </tr>

                            <tr>
                                <td><strong>Deskripsi Menu</strong></td>
                                <td>:</td>
                                <td><?= $menu['deskripsi_menu'] ?></td>
                            </tr>

                        </table>
                    </div>

                    <div class="image-box">
                        <img src="../foto-foto/foto-menu/<?= $menu['gambar_menu'] ?>" alt="<?= $menu['nama_menu'] ?>">
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>