<?php
    include('../database/koneksi.php');

    $query = "
        SELECT 
            m.id_menu,
            m.nama_menu,
            m.harga_menu,
            m.gambar_menu,
            IFNULL(SUM(dp.jumlah), 0) AS total_terjual
        FROM menu m
        LEFT JOIN detail_pesanan dp ON m.id_menu = dp.id_menu
        LEFT JOIN pesanan p ON dp.id_transaksi = p.id_transaksi AND p.status = 'dikonfirmasi'
        GROUP BY m.id_menu
        ORDER BY total_terjual DESC
        LIMIT 3
    ";

    $result_favorit = mysqli_query($koneksi, $query);

    if (!$result_favorit) {
        die("Query gagal: " . mysqli_error($koneksi));  // Tambahan penting untuk debug
    }
?>
