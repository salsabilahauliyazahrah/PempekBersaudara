<?php
    include('../database/koneksi.php');

    $id_transaksi = $_POST['id_transaksi'];

    $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_transaksi = '$id_transaksi'"));
    $id_pelanggan = $pesanan['id_pelanggan'];
    $id_admin = $pesanan['id_admin'];
    $total = $pesanan['total_harga'] + $pesanan['ongkir'];

    // === Jika Konfirmasi Pesanan ===
    if (isset($_POST['konfirmasi'])) {
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'diproses' WHERE id_transaksi = '$id_transaksi'");
        mysqli_query($koneksi, "UPDATE saldo_admin set saldo = saldo = saldo + $total WHERE id_admin = '$id_admin'");

        //Notifikasi ke pelanggan
        mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Pesanan anda dikonfirmasi dan sedang dibuat')");

        //Log aktivitas admin
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'konfirmasi', 'Pesanan dikonfirmasi dan saldo ditransfer ke admin')");
    } elseif (isset($_POST['tolak'])) {
        
        //jika pesanan ditolak
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'ditolak' WHERE id_transaksi = '$id_transaksi'");
        mysqli_query($koneksi, "UPDATE saldo_customer SET saldo = saldo + $total WHERE id_pelanggan = '$id_pelanggan'");

        //notifikasi
        mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Maaf pesanan anda ditolak')");
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'tolak', 'Pesanan ditolak dan saldo dikembalikan ke customer')");
    } elseif (isset($_POST['selesai_diproses'])) {

        //admin mengklik 'Pesanan selesai diproses'
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'diantar' WHERE id_transaksi = '$id_transaksi'");

        mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Pesanan sedang diantar')");
        mysqli_query($Koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'antar', 'Pesanan diantar oleh kurir')");
    } elseif (isset($_POST['pesanan_diterima'])) {

        //pelanggan mengklik 'Pesanan diterima'
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'selesai' WHERE id_transaksi = '$id_transaksi'");

        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'selesai', 'Pelanggan menerima pesanan')");
    }

    header('Location: ../views-admin/pesanan.php');
?>    