<?php

    session_start();
    if (!isset($_SESSION['id_admin'])) {
        header("Location: login-admin.php"); // arahkan ke login kalau belum login
    exit();
    }

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
                    <!-- <i class='bx bx-edit'></i>  -->
                    <span class="text">Menu - Edit Menu</span>  
                </div>

                <div class="top">
                    <div class="kembali">
                        <a href="menu.php" class="btn-kembali" id="btnKembali">
                           <!-- <i class='bx bx-arrow-back'></i> -->
                            kembali
                        </a>
                    </div>
                </div>

                <div class="kolom-input">
                    <form id="form" action="../proses/3.edit-menu.php" method="post" enctype="multipart/form-data" onsubmit="return konfirmasiUpdate();">
                        <input type="hidden" name="id_menu" value="<?= $menu['id_menu'] ?>">

                        <!-- Upload Gambar -->
                        <div class="card-section insert-image">
                            <h3>Gambar Menu</h3>
                            <div class="upload-box" onclick="triggerFileInput()">
                                <input type="file" id="gambar" name="gambar" hidden>
                                
                                <div class="defaultText" style="<?= !empty($menu['gambar_menu']) ? 'display:none;' : '' ?>">
                                    <div class="icon-upload">
                                        <i class='bx bx-image-add'></i>
                                    </div>
                                    <p><strong>Drop Image Menu Here, or <span class="browse-text">click to browse</span></strong></p>
                                </div>

                                <div id="previewContainer" style="<?= empty($menu['gambar_menu']) ? 'display:none;' : '' ?> position: relative;">
                                    <img src="../foto-foto/img/<?= $menu['gambar_menu'] ?>" alt="Preview Gambar" id="previewImage" style="max-width: 70%; border-radius: 10px;">
                                    <div class="overlay" onclick="triggerFileInput()">Ganti Gambar?</div>
                                </div>
                            </div>
                        </div>

                        <!-- Input Data -->
                        <div class="card-section">
                            <div class="form-grid">
                                <div class="left-section">
                                    <label for="nama">Nama Menu</label>
                                    <input type="text" id="nama" name="nama" value="<?= $menu['nama_menu'] ?>" required>

                                    <label for="harga">Harga</label>
                                    <input type="number" id="harga" name="harga" value="<?= $menu['harga_menu'] ?>" required>

                                    <label for="qty">QTY</label>
                                    <input type="number" id="qty" name="qty" value="<?= $menu['jumlah_tersedia'] ?>" required>

                                    <label for="deskripsi">Deskripsi Menu</label>
                                    <textarea name="deskripsi" id="deskripsi"><?= $menu['deskripsi_menu'] ?></textarea>

                                    <label for="bahanBahan">Bahan-bahan</label>
                                    <textarea name="bahanBahan" id="bahanBahan"><?= $menu['bahan_bahan'] ?? '' ?></textarea>

                                    <label for="detail">Detail</label>
                                    <textarea name="detail" id="detail"><?= $menu['detail'] ?? '' ?></textarea>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="buttons">
                                <button type="submit" class="btn-submit">Update</button>
                                <a href="menu.php" class="btn-reset">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>

<script src="../javascript/btn-kembali(edit).js"></script>

<script>
    function konfirmasiUpdate() {
        return confirm("Apakah Anda yakin ingin memperbarui menu ini?");
    }
</script>

</html>