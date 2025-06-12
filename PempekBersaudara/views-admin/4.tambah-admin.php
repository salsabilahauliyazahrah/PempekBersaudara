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
                    <i class='bx bx-plus'></i>
                    <span class="text">Tambah Admin</span>   
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
                    <form action="../proses/regis.php" method="post" enctype="multipart/form-data">
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
</html>