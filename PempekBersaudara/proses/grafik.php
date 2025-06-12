<?php
    include('../database/koneksi.php');

    // Ambil nama menu dan total terjual dari database
    $query = "
        SELECT 
            m.nama_menu,
            IFNULL(SUM(dp.jumlah), 0) AS total_terjual
        FROM menu m
        LEFT JOIN detail_pesanan dp ON m.id_menu = dp.id_menu
        LEFT JOIN pesanan p ON dp.id_transaksi = p.id_transaksi AND p.status = 'dikonfirmasi'
        GROUP BY m.id_menu
        ORDER BY total_terjual DESC
    ";

    $result = mysqli_query($koneksi, $query);

    // Simpan ke array PHP
    $menu_names = [];
    $menu_sales = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $menu_names[] = $row['nama_menu'];
        $menu_sales[] = (int)$row['total_terjual'];
    }
?>