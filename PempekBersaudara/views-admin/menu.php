<?php
    include '../database/koneksi.php';
    include '../proses/menu.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Jalankan fungsi ambilMenu dari proses/menu.php
    $menus = ambilMenu($koneksi, $search);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-menu.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!--=============== FAVICON ===============-->
    <!-- TODO: Replace with actual pempek logo -->
    <link rel="shortcut icon" href="../foto-foto/logo.png" type="image/x-icon" />

    <title>Menu</title>

</head>
<body>
    <!-- menu.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-menu">
        <div class="menu-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx  bx-food-menu'></i> 
                    <span class="text">Menu</span>
                </div>

                <div class="top">           
                    <form action="" method="GET" class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" 
                               name="search"
                               placeholder="Search here..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" style="display: none;"></button>
                    </form>    

                    <a href="1.tambah-menu.php" class="btn-tambah">
                        <i class='bx bx-plus'></i> 
                        Tambah Menu
                    </a>
                </div>

                <div class="activity">
                    <table class="menu-table">
                        <thead>
                            <tr>
                                <th>ID Menu</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>QTY</th>
                                <th>Gambar</th>
                                <th>Terjual</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td class="center"><?= $menu['id_menu'] ?></td>
                                <td class="center"><?= $menu['nama_menu'] ?></td>
                                <td class="center">Rp <?= number_format($menu['harga_menu'], 0, ',', '.') ?></td>
                                <td class="center"><?= $menu['jumlah_tersedia'] ?></td>
                                <td class="center"><img src="../foto-foto/foto-menu/<?= $menu['gambar_menu'] ?>" width="80"></td>
                                <td class="center"><?= $menu['total_terjual'] ?></td>
                                <td class="center">
                                    <div class="action-button">  
                                        
                                        <a href="3.edit-menu.php?id=<?= $menu['id_menu'] ?>" class="btn-edit">
                                            <i class='bx bx-edit'></i> 
                                            Edit
                                        </a>          
                                        <a href="../proses/2.delete-menu.php?id=<?= $menu['id_menu'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus menu ini?')" class="btn-hapus">
                                            <i class='bx  bx-trash'></i>
                                            Hapus
                                        </a>                                                                    
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>