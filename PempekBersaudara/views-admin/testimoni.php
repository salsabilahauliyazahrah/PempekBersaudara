<?php
    include '../database/koneksi.php';
    include '../proses/testimoni.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-testimoni.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Testimoni</title>
</head>
<body>
    <!-- testimoni.php -->
    <?php include('sidebar.php'); ?>
    <div class="halaman-testimoni">
        <div class="testimoni-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-comment'></i>
                    <span class="text">Testimoni</span>
                </div>
                
                <div class="top">
                    <form action="" method="GET" class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" 
                               name="search"
                               placeholder="Search here..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" style="display: none;"></button>
                    </form>  
                </div>

                <div class="activity">
                    <table class="testimoni-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td class="center"><?= $row['id_testimoni']; ?></td>
                                        <td class="center">-</td> <!-- Kosongkan atau ganti jika tidak ada tanggal -->
                                        <td class="center"><?= htmlspecialchars($row['nama']); ?></td>
                                        <td class="center"><?= htmlspecialchars($row['email']); ?></td>
                                        <td class="center"><?= htmlspecialchars($row['pesan']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="center">Tidak ada testimoni ditemukan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>