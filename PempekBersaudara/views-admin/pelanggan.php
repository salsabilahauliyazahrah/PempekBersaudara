<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-pelanggan.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Daftar Pelanggan</title>
</head>
<body>
    <!-- menu.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-pelanggan">
        <div class="pelanggan-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-group icon'></i>
                    <span class="text">Pelanggan</span>
                </div>

                <div class="top">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" placeholder="Search here...">
                    </div>
                </div>
                
                <div class="activity">
                    <table class="pelanggan-table">
                        <thead>
                            <tr>
                                <th>ID Pelanggan</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Username</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center">1</td>
                                <td class="center">Mochi</td>
                                <td class="center">0000081</td>
                                <td class="center">mochi@gmail.com</td>
                                <td class="center">
                                    <div class="action-button">
                                        <a href="" class="btn-hapus">
                                            <i class='bx  bx-trash'></i>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>