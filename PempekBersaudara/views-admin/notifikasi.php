<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-notif.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Notifikasi</title>
</head>
<body>
    <!-- notifikasi.php -->
    <?php include('sidebar.php'); ?>
    <div class="notifikasi">
        <div class="notif-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-bell'></i>
                    <span class="text">Notifikasi</span>
                </div>

                <div class="top">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" placeholder="Search here...">
                    </div>
                </div>

                <div class="activity">
                    <table class="notif-table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>Daftar Pesanan</th>
                                <th>Alamat</th>
                                <th>Total Pesanan</th>
                                <th>Ongkir</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="center">2025052403</td>
                            <td class="center">24/05/2025</td>
                            <td>Dita</td>
                            <td>
                                <div class="menu-item">
                                    <span class="menu-name">Pempek Lenjer</span>
                                    <span class="menu-qty">2x</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-name">Pempek Keriting</span>
                                    <span class="menu-qty">1x</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-name">Pempek Lenggang</span>
                                    <span class="menu-qty">1x</span>
                                </div>
                            </td>
                            <td class="center">Jl. Durian</td>
                            <td class="center">Rp 10,000</td>
                            <td class="center">Rp 3,000</td>
                            <td>
                                <button class="btn-confirm">Konfirmasi Pesanan?</button>
                                <button class="btn-reject">Tolak</button>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>