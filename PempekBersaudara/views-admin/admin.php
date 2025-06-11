<?php
    include '../database/koneksi.php';
    include '../proses/admin.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!--=============== FAVICON ===============-->
    <!-- TODO: Replace with actual pempek logo -->
    <link rel="shortcut icon" href="../foto-foto/logo.png" type="image/x-icon"> 

    <title>Daftar Admin</title>
</head>
<body>
    <!-- admin.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-daftarAdmin">
        <div class="admin-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-user'></i>
                    <span class="text">Admin</span>
                </div>

                <div class="top">
                    <form class="search-box" method="get" action="admin.php">
                            <i class='bx bx-search'></i>
                            <input type="text" 
                                name="search"
                                placeholder="Search here..."
                                value="<?= htmlspecialchars($search) ?>">
                            <button type="submit" style="display: none;"></button>
                    </form>

                    <a href="4.tambah-admin.php" class="btn-tambah">
                        <i class='bx bx-plus'></i> 
                        Tambah Admin
                    </a>
                </div>

                <div class="activity">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Admin</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Username</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="center"><?= $row['id_admin'] ?></td>
                                <td class="center"><?= $row['nama_admin'] ?></td>
                                <td class="center"><?= $row['no_telepon'] ?></td>
                                <td class="center"><?= $row['username'] ?></td>
                                <td class="center">
                                    <div class="action-button">
                                        <a href="5.edit-admin.php?id=<?= $row['id_admin'] ?>" class="btn-edit">
                                            <i class='bx bx-edit'></i> 
                                            Edit
                                        </a> 
                                        <a href="../proses/7.hapus-admin.php?id=<?= $row['id_admin'] ?>" onclick="return confirm('Yakin ingin menghapus admin ini?')" class="btn-hapus">
                                            <i class='bx  bx-trash'></i>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>