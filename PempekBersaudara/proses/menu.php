<?php
    include('../database/koneksi.php');

    function ambilMenu($koneksi, $search = '') { 
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

        // Jika ada pencarian, tambahkan HAVING
        if (!empty($search)) {
            $query .= "
                HAVING 
                    m.id_menu LIKE '%$search%' OR
                    m.nama_menu LIKE '%$search%' OR
                    m.harga_menu LIKE '%$search%' OR
                    m.jumlah_tersedia LIKE '%$search%' OR
                    m.gambar_menu LIKE '%$search%' OR
                    total_terjual LIKE '%$search%'
            ";
        }   
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
                die('Query Error: ' . mysqli_error($koneksi));
        }
        
        $menus = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $menus[] = $row;
        }
        return $menus;
    }        
?>