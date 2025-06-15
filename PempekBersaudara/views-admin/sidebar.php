<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include('../database/koneksi.php');
    $result_pending = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM pesanan WHERE status = 'pending'");
    $data_pending = mysqli_fetch_assoc($result_pending);
    $jumlah_pending = $data_pending['jumlah'];

    // ✅ Ambil dari session (yang sudah di-set saat login)
    $nama_admin = $_SESSION['nama_admin'] ?? 'Admin';
    $foto_admin = $_SESSION['foto_admin'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-sidebar.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>sidebar</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../foto-foto/logo.png" alt="logo">
                </span>

                <div class="text header-text">
                    <span class="name">Pempek</span>
                    <span class="profession">Bersaudara</span>
                </div>
            </div>

            <i class='bx bxs-chevron-right toggle' ></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-link">
                    <li class="nav-link">
                        <a href="beranda.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="menu.php">
                            <i class='bx bx-food-menu icon'></i>
                            <span class="text nav-text">Menu</span>                           
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="pesanan.php">
                            <i class='bx bx-cart icon'></i>
                            <span class="text nav-text">Pesanan</span>
                            <?php if ($jumlah_pending > 0): ?>
                                <span class="notif-count"><?= $jumlah_pending ?></span>                                
                            <?php endif; ?>

                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="admin.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Admin</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="pelanggan.php">
                            <i class='bx bx-group icon'></i>
                            <span class="text nav-text">Pelanggan</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="laporan.php">
                            <i class='bx bx-file icon'></i>
                            <span class="text nav-text">Laporan</span>
                        </a>
                    </li>
                     <!-- dipending dulu 
                    <li class="nav-link">
                        <a href="testimoni.php">
                            <i class='bx bx-comment icon'></i>
                            <span class="text nav-text">Testimoni</span>
                        </a>
                    </li>
                     -->
                </ul>
            </div>

            <div class="botton-content">
                <ul>
                    <li class="">
                        <a href="../proses/logout.php">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
                    
            </div>
        </div>
    </nav>

</body>


    <script src="../javascript/script.js"></script>

</html>