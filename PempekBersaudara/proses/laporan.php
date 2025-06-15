<?php
    include('../database/koneksi.php');

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_hari_ini = date('Y-m-d');

    // Pendapatan bersih berdasarkan metode pembayaran
    $query = "
        SELECT
            SUM(CASE WHEN metode_pembayaran = 'ewallet' THEN total_harga ELSE 0 END) AS total_ewallet,
            SUM(CASE WHEN metode_pembayaran = 'cash' THEN total_harga ELSE 0 END) AS total_cash
        FROM pesanan
        WHERE status = 'selesai'
    ";

    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    // Inisialisasi jika null
    $total_ewallet = (float)($data['total_ewallet'] ?? 0);
    $total_cash    = (float)($data['total_cash'] ?? 0);

    //Total Penggabungan dari kedua metode pembayaran
    $data_pendapatan['total_pendapatan'] = $total_ewallet + $total_cash;

    //Pendapatan ongkir
    $query_ongkir = "SELECT SUM(ongkir) AS total_ongkir FROM pesanan 
                    WHERE status = 'selesai'";
    $result_ongkir = mysqli_query($koneksi, $query_ongkir);
    $row_ongkir = mysqli_fetch_assoc($result_ongkir);
    $data_ongkir['total_ongkir'] = (float)($row_ongkir['total_ongkir'] ?? 0);

    // Simpan ulang
    $data['total_ewallet'] = $total_ewallet;
    $data['total_cash'] = $total_cash;
?>    