<?php
    include '../database/koneksi.php';

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "ID admin tidak ditemukan di URL.";
        exit();
    }

    $id = intval($_GET['id']); // Konversi ke integer untuk keamanan

    $query = "SELECT * FROM admin WHERE id_admin = $id";
    $result = $koneksi->query($query);

    // Cek apakah data ditemukan
    if ($result->num_rows === 0) {
        echo "Data admin tidak ditemukan.";
        exit();
    }

    $data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-tambahAdmin.css"> 
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Edit Admin</title>
</head>
<body>
    <!-- Edit Admin.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-tambahAdmin">
        <div class="tambah-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-edit'></i> 
                    <span class="text">Edit Admin</span>   
                </div>

                <div class="top">
                    <div class="kembali">
                        <a href="admin.php" class="btn-kembali">
                            <i class='bx bx-arrow-back'></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="kolom-input">
                    <form action="../proses/5.edit-admin.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_admin" value="<?= $data['id_admin'] ?>">

                        <div class="left-section">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" value="<?= $data['nama_admin'] ?>" required>

                            <label for="no-telp">No Telepon</label>
                            <input type="number" id="no-telp" name="telepon" value="<?= $data['no_telepon'] ?>" required>

                            <label for="email">Username</label>
                            <input type="text" id="email" name="username" value="<?= $data['username'] ?>" required>

                            <!-- Password bisa opsional -->
                            <label for="password">Password (kosongkan jika tidak diganti)</label>
                            <input type="password" id="password" name="password">

                            <div class="buttons">
                                <button type="submit" class="btn-submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>