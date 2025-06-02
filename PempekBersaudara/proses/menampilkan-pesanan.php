<?php
    include('../database/koneksi.php');

    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

    $where = "";
    if (!empty($search)) {
        $where = "WHERE pl.nama_pelanggan LIKE '%$search%'
        OR m.nama_menu LIKE '%$search%' 
        OR p.id_transaksi LIKE '%$search%'";
    }

    $query = "SELECT 
                p.id_transaksi,
                DATE_FORMAT(p.tanggal_transaksi, '%d/%m/%Y') AS tanggal,
                pl.nama_pelanggan,
                p.alamat_pengiriman,
                p.total_harga,
                p.ongkir,
                p.status,
                GROUP_CONCAT(CONCAT(m.nama_menu, ' (', dp.jumlah, 'x)') SEPARATOR '<br>') AS daftar_pesanan
            FROM 
                pesanan p
            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
            JOIN detail_pesanan dp ON p.id_transaksi = dp.id_transaksi
            JOIN menu m ON dp.id_menu = m.id_menu
            $where
            GROUP BY p.id_transaksi
            ORDER BY p.tanggal_transaksi DESC";

    $result = mysqli_query($koneksi, $query);
?>