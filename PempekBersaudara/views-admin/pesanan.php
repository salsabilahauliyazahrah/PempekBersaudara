<?php
    session_start();
    if (!isset($_SESSION['id_admin'])) {
        header("Location: login-admin.php"); // arahkan ke login kalau belum login
        exit();
    }
    
    include('../database/koneksi.php');
    include('../proses/menampilkan-pesanan.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-notif.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>

        <!--=============== FAVICON ===============-->
    <!-- TODO: Replace with actual pempek logo -->
    <link rel="shortcut icon" href="../foto-foto/chart(2).png" type="image/x-icon" />
    <title>Pesanan</title>
</head>
<body>
    <!-- pesanan.php -->
    <?php include('sidebar.php'); ?>
    <div class="notifikasi">
        <div class="notif-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-cart'></i>
                    <span class="text">Pesanan</span>
                </div>

                <div class="top">
                    <form action="pesanan.php" method="GET" class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" 
                               name="search"
                               placeholder="Search here..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" style="display: none;"></button> 
                    </form>
                    
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
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <audio id="notifSound" src="../foto-foto/mp3/notification.mp3" preload="auto"></audio>
                        <?php while($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="<?= $row['status'] === 'pending' ? 'highlight-row' : '' ?>">
                                <td class="center"><?= $row['id_transaksi']; ?></td>
                                <td class="center"><?= $row['tanggal']; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['daftar_pesanan']; ?></td>
                                <td class="center"><?= $row['alamat_penerima']; ?></td>
                                <td class="center">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td class="center">Rp <?= number_format($row['ongkir'], 0, ',', '.'); ?></td>
                                <td class="status"><?= ucfirst($row['status']); ?></td>
                                <td>
                                    <form action="../proses/pesanan.php" method="POST">
                                        <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">

                                        <?php if ($row['status'] == 'pending') : ?>
                                            <button class="btn-confirm" name="konfirmasi">Konfirmasi</button>
                                            <button class="btn-reject" name="tolak">Tolak</button>
                                        
                                        <?php elseif ($row['status'] == 'diproses') : ?>
                                            <button class="btn-process" name="selesai_diproses">Pesanan Selesai Diproses</button>

                                        <?php elseif ($row['status'] == 'diantar') : ?>
                                            <span>Sedang diantar</span>

                                        <?php elseif ($row['status'] == 'selesai') : ?>
                                            <span>✔ Selesai</span>
                                        
                                        <?php elseif ($row['status'] == 'ditolak') : ?>
                                            <span>❌ Ditolak</span>
                                        
                                        <?php else : ?>
                                            <span>-</span>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr> 
                        <?php endwhile; ?>                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

    <script>
        // Cek pesanan baru secara berkala
        let lastPendingCount = parseInt(localStorage.getItem('lastPendingCount')) || 0;

        function checkNewPendingOrders() {
            fetch("../proses/cek_pesanan_baru.php")
                .then(response => response.json())
                .then(data => {
                    const jumlahPending = data.jumlah_pending || 0;

                    // Update tampilan jika ada elemen notif
                    const notifEl = document.querySelector('.notif-count');
                    if (notifEl) {
                        notifEl.textContent = jumlahPending > 0 ? jumlahPending : '';
                    }

                    // Jika pending bertambah → mainkan suara
                    if (jumlahPending > lastPendingCount) {
                        const audio = document.getElementById('notifSound');
                        if (audio) {
                            audio.play().catch(err => {
                                console.log('Gagal memutar audio:', err);
                            });
                        }
                    }

                    lastPendingCount = jumlahPending;
                })
                .catch(err => console.log("Fetch error:", err));
        }

        // 🟢 Unlock audio di klik pertama
        document.addEventListener('click', () => {
            const audio = document.getElementById('notifSound');
            if (audio) {
                audio.play().catch(() => {});
                audio.pause();
                audio.currentTime = 0;
            }
        }, { once: true });

        // Jalankan pertama kali
        checkNewPendingOrders();

        // Cek berkala setiap 7 detik
        setInterval(checkNewPendingOrders, 7000);
    </script>   

</html>