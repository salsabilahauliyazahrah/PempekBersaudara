<?php

    session_start();
    if (!isset($_SESSION['id_admin'])) {
        header("Location: login-admin.php"); // arahkan ke login kalau belum login
        exit();
    }

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
                    <!--<i class='bx bx-edit'></i>-->
                    <span class="text">Admin - Edit Admin</span>
                </div>

                <div class="top">
                    <div class="kembali">
                        <a href="admin.php" class="btn-kembali" id="btnKembali">
                            <!--<i class='bx bx-arrow-back'></i>-->
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="kolom-input">
                    <form id="form" action="../proses/5.edit-admin.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_admin" value="<?= $data['id_admin'] ?>">

                        <!-- Upload Foto Profil -->
                        <div class="card-section insert-image">
                            <h3>Upload Foto Profil</h3>
                            <div class="upload-box" onclick="triggerFileInput()">
                                <input type="file" id="gambar" name="foto" accept=".jpg,.jpeg,.png" hidden>

                                <div class="defaultText" style="<?= !empty($data['foto_admin']) ? 'display:none;' : '' ?>">
                                    <div class="icon-upload">
                                        <i class='bx bx-image-add'></i>
                                    </div>
                                    <p><strong>Drop Image Profile Here, or <span class="browse-text">click to browse</span></strong></p>
                                </div>

                                <div id="previewContainer" style="<?= !empty($data['foto_admin']) ? 'display:block;' : 'display:none;' ?> position: relative;">
                                    <img src="<?= !empty($data['foto_admin']) ? '../foto-foto/admin/' . $data['foto_admin'] : '' ?>" alt="Preview Gambar" id="previewImage" style="max-width: 70%; border-radius: 10px;">
                                    <div class="overlay" onclick="triggerFileInput()">Ganti Gambar?</div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Admin -->
                        <div class="card-section">
                            <div class="form-grid">
                                <div class="left-section">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" value="<?= $data['nama_admin'] ?>" required>

                                    <label for="no-telp">No Telepon</label>
                                    <input type="number" id="no-telp" name="telepon" value="<?= $data['no_telepon'] ?>" required>

                                    <label for="email">Username</label>
                                    <input type="text" id="email" name="username" value="<?= $data['username'] ?>" required>

                                    <label for="password">Password (kosongkan jika tidak diganti)</label>
                                    <input type="password" id="password" name="password"
                                        maxlength="8"
                                        pattern="^(?=.*[\W_]).{1,8}$"
                                        title="Password maksimal 8 karakter dan harus mengandung simbol atau karakter khusus">
                                </div>
                            </div>

                            <div class="buttons">
                                <button type="submit" class="btn-submit">Update</button>
                                <button type="reset" class="btn-reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="../javascript/btn-kembali(edit).js"></script>
    <script src="../javascript/upload-priviewMenu.js"></script>
</body>
</html>