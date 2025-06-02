<?php
    include('../database/koneksi.php');

    // Set timezone
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_hari_ini = date('Y-m-d');

    //menampilkan total pendapatan bersih dari pendapatan yang sudah selesai
    $query_pendapatan = "SELECT SUM(total_harga) AS total_pendapatan FROM pesanan
                         WHERE DATE(tanggal_transaksi) = '$tanggal_hari_ini' AND status = 'selesai'";
    $result_pendapatan = mysqli_query($koneksi, $query_pendapatan);
    $data_pendapatan = mysqli_fetch_assoc($result_pendapatan);
    
    //Menampilkan total pendapatan ongkir
    $query_ongkir = "SELECT SUM(ongkir) AS total_ongkir FROM pesanan
                     WHERE DATE(tanggal_transaksi) = '$tanggal_hari_ini' AND status = 'selesai'";
    $result_ongkir = mysqli_query($koneksi, $query_ongkir);
    $data_ongkir = mysqli_fetch_assoc($result_ongkir);                     
?>    