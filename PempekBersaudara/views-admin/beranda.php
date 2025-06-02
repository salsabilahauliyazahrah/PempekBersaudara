<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-beranda.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Beranda</title>
</head>
<body>
    <!-- beranda.php -->
    <?php include('sidebar.php'); ?>

    <div class="dashboard">
        <div class="dash-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-home-alt icon'></i>
                    <span class="text">Beranda</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class='bx bx-group'></i>
                        <span class="text">Pelanggan</span>
                        <span class="number">
                            <?php 
                                include '../database/koneksi.php';
                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelanggan");
                                $data = mysqli_fetch_assoc($query);
                                echo $data['total'] ?? 0; //menampilkan 0 jika null
                            ?>
                        </span>
                    </div>
                    <div class="box box2">
                        <i class='bx bx-group'></i>
                        <span class="text">Admin</span>
                        <span class="number">
                            <?php 
                                include '../database/koneksi.php';
                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM admin");
                                $data = mysqli_fetch_assoc($query);
                                echo $data['total'] ?? 0; //menampilkan 0 jika null
                            ?>
                        </span>
                    </div>
                    <div class="box box3">
                        <i class='bx bx-group'></i>
                        <span class="text">Total Pesanan</span>
                        <span class="number">
                            <?php 
                                include '../database/koneksi.php';
                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelanggan");
                                $data = mysqli_fetch_assoc($query);
                                echo $data['total'] ?? 0; //menampilkan 0 jika null
                            ?>
                        </span>
                    </div>
                    <div class="box box4">
                        <i class='bx bx-group'></i>
                        <span class="text">Pesanan Diproses</span>
                        <span class="number">
                            <?php 
                                include '../database/koneksi.php';
                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelanggan");
                                $data = mysqli_fetch_assoc($query);
                                echo $data['total'] ?? 0; //menampilkan 0 jika null
                            ?>
                        </span>
                    </div>                 
                </div>

            </div>
        </div>
    </div>
</body>
</html>