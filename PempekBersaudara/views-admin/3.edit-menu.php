<?php
    include '../database/koneksi.php';
    
    if (isset($_GET['id'])) {
        $id_menu = $_GET['id'];

        $query = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $menu = mysqli_fetch_assoc($result);
        } else {
            echo "<script>alert('Menu tidak ditemukan'); window.location.href='menu.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Permintaan tidak valid'); window.location.href='menu.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-editMenu.css">    
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Edit Menu</title>
</head>
<body>
    <!-- Edit menu.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-editMenu">
        <div class="edit-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-edit'></i> 
                    <span class="text">Edit Menu</span>  
                </div>

                <div class="top">
                    <div class="kembali">
                        <a href="menu.php" class="btn-kembali">
                            <i class='bx bx-arrow-back'></i>
                            kembali
                        </a>
                    </div>
                </div>

                <div class="kolom-input">
                    <form action="../proses/3.edit-menu.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_menu" value="<?= $menu['id_menu'] ?>">
                        <div class="left-section">
                            <label for="nama">Nama Menu</label>
                            <input type="text" id="nama" name="nama" value="<?= $menu['nama_menu'] ?>">

                            <label for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" value="<?= $menu['harga_menu'] ?>">

                            <label for="qty">QTY</label>
                            <input type="number" id="qty" name="qty" value="<?= $menu['jumlah_tersedia'] ?>">

                            <div class="buttons">
                                <button type="submit" class="btn-submit">Update</button>
                                
                            </div>
                        </div>

                        <div class="right-section">                        

                            <label for="gambar">Gambar Menu</label>
                            <div class="gambar-input-wrapper">
                                <div class="tampilin-gambar">
                                    <?php if (!empty($menu['gambar_menu'])): ?>
                                        <img src="../foto-foto/foto-menu/<?=$menu['gambar_menu'] ?>" alt="Gambar Menu" width="150">
                                    <?php endif; ?>
                                </div>
                                <input type="file" id="gambar" name="gambar"> 
                            </div>                                                   

                            <label for="deskripsi">Deskripsi Menu</label>
                            <textarea name="deskripsi" id="deskripsi"><?= $menu['deskripsi_menu'] ?></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>