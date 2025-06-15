<?php 
    session_start();
    if (isset($_SESSION['errorMessage'])) {
        echo "<div class='error'>" . $_SESSION['errorMessage'] . "</div>";
        unset($_SESSION['errorMessage']);
    }
    if (isset($_SESSION['successMessage'])) {
        echo "<div class='success'>" . $_SESSION['successMessage'] . "</div>";
        unset($_SESSION['successMessage']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-tambahAdmin.css">   
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Tambah Admin</title>
</head>
<body>
    <!-- Tambah Admin.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-tambahAdmin">
        <div class="tambah-content">
            <div class="overview">
                <div class="tittle">
                    <!-- <i class='bx bx-plus'></i> -->
                    <span class="text">Tambah Admin</span>   
                </div>

                <div class="top">
                    <div class="kembali">
                        <a href="admin.php" class="btn-kembali" id="btnKembali">
                            <!-- <i class='bx bx-arrow-back'></i> -->
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="kolom-input">
                    <form id="form" action="../proses/regis.php" method="post" enctype="multipart/form-data">
                        <!-- Tambah Gambar Profil -->
                        <div class="card-section insert-image">
                            <h3>Upload Foto Profil</h3>
                            <div class="upload-box" onclick="gantiGambar">
                                <input type="file" id="gambar" name="gambar" required hidden>

                                <div class="defaultText">
                                    <div class="icon-upload">
                                        <i class='bx bx-image-add'></i>
                                    </div>
                                    <p><strong>Drop Image Profile Here, or <span class="browse-text">click to browse</span></strong></p>
                                </div>

                                <div id="previewContainer" style="display: none; position: relative;">
                                    <img src="" alt="Preview Gambar" id="previewImage" style="max-width: 70%; border-radius: 10px;">
                                    <div class="overlay" onclick="gantiGambar">Ganti Gambar?</div>
                                </div>

                            </div>
                        </div>

                        <!-- input Data Admin -->
                         <div class="card-section">
                            <div class="form-grid">
                                <div class="left-section">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" required>

                                    <label for="no-telp">No Telepon</label>
                                    <input type="number" id="no-telp" name="telepon" required>

                                    <label for="email">Username</label>
                                    <input type="text" id="email" name="username" required>

                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" required
                                    maxlength="8"
                                    pattern="^(?=.*[\W_]).{1,8}$"
                                    title="Password maksimal 8 karakter dan harus mengandung simbol atau karakter khusus">
                                </div>
                            </div>

                            <!-- Tombol -->                            
                            <div class="buttons">
                                <button type="submit" class="btn-submit">Submit</button>
                                <button type="reset" class="btn-reset">Reset</button>
                            </div>
                         </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
    
</body>

    <script src="../javascript/btn-kembali.js"></script>
    <script src="../javascript/upload-priviewMenu.js"></script>

</html>