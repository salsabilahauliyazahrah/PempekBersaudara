<?php 
    include('../database/koneksi.php');

    if (isset($_GET['id'])) {
        $query = "
            SELECT 
                m.id_menu,
                m.nama_menu,
                m.jumlah_tersedia,
                m.harga_menu,
                m.gambar_menu,
                m.deskripsi_menu,
                IFNULL(SUM(dp.jumlah), 0) AS total_terjual
            FROM menu m
            LEFT JOIN detail_pesanan dp ON m.id_menu = dp.id_menu
            LEFT JOIN pesanan p ON dp.id_transaksi = p.id_transaksi AND p.status = 'dikonfirmasi'
            GROUP BY m.id_menu
        ";

        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $menu = mysqli_fetch_assoc($result);
        } else {
            echo "<script>alert('Menu tidak ditemukan'); window.location.href='menu.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('ID tidak ditemukan'); window.location.href='menu.php';</script>";
        exit;
    }
?>