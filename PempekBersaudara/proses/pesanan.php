<?php
    session_start();
    include('../database/koneksi.php');

    $id_transaksi = $_POST['id_transaksi'];
    $id_admin = $_SESSION['id_admin'];

    $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_transaksi = '$id_transaksi'"));
    $id_pelanggan = $pesanan['id_pelanggan'];
    $total = $pesanan['total_harga'] + $pesanan['ongkir'];

    // Cek jika status pesanan sudah dibatalkan
    if ($pesanan['status'] === 'dibatalkan') {
        echo "<script>alert('Pesanan ini sudah dibatalkan oleh pelanggan. Tidak dapat diproses.'); window.location='../views-admin/pesanan.php';</script>";
        exit;
    }


    // === Jika Konfirmasi Pesanan ===
    if (isset($_POST['konfirmasi'])) {      
        $stok_kurang = false;
        $detail = mysqli_query($koneksi, "SELECT id_menu, jumlah FROM detail_pesanan WHERE id_transaksi = '$id_transaksi'");

        while ($item = mysqli_fetch_assoc($detail)) {
            $id_menu = $item['id_menu'];
            $jumlah = $item['jumlah'];

            //Melakukan pengecekan jumlah yang tersedia
            $menu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT jumlah_tersedia FROM menu WHERE id_menu = '$id_menu'"));
            if ($menu['jumlah_tersedia'] < $jumlah) {
                $stok_kurang = true;
                break;
            }
        }

        if ($stok_kurang) {
            //Update status menjadi ditolak
            mysqli_query($koneksi, "UPDATE pesanan SET status = 'kosong' WHERE id_transaksi = '$id_transaksi'");
            mysqli_query($koneksi, "UPDATE saldo_pelanggan SET saldo = saldo + $total WHERE id_pelanggan = '$id_pelanggan'");
            mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Maaf pesanan anda ditolak karena stok tidak mencukupi')");
            mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'tolak (otomatis)', 'Pesanan ditolak karena stok tidak mencukupi')");

            echo "<script>alert('Pesanan ditolak karena stok tidak mencukupi'); window.location='../views-admin/pesanan.php';</script>";
            exit;
        }
        
        //Kondisi apabila stok cukup, maka proses dilanjutkan 
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'diproses', id_admin = '$id_admin' WHERE id_transaksi = '$id_transaksi'");
        mysqli_query($koneksi, "UPDATE saldo_admin set saldo = saldo + $total WHERE id_admin = '$id_admin'");

        $detail = mysqli_query($koneksi, "SELECT id_menu, jumlah FROM detail_pesanan WHERE id_transaksi = '$id_transaksi'");
        while ($item = mysqli_fetch_assoc($detail)) {
            $id_menu = $item['id_menu'];
            $jumlah = $item['jumlah'];
            mysqli_query($koneksi, "UPDATE menu SET jumlah_tersedia = jumlah_tersedia - $jumlah WHERE id_menu = '$id_menu'");
        }

        //Notifikasi ke pelanggan
        mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Pesanan anda dikonfirmasi dan sedang dibuat')");

        //Log aktivitas admin
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'konfirmasi', 'Pesanan dikonfirmasi dan saldo ditransfer ke admin')");
    } elseif (isset($_POST['tolak'])) {
        
        //jika pesanan ditolak
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'ditolak' WHERE id_transaksi = '$id_transaksi'");
        mysqli_query($koneksi, "UPDATE saldo_pelanggan SET saldo = saldo + $total WHERE id_pelanggan = '$id_pelanggan'");

        //notifikasi
        mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Maaf pesanan anda ditolak')");
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'tolak', 'Pesanan ditolak dan saldo dikembalikan ke customer')");
    } elseif (isset($_POST['selesai_diproses'])) {

        //admin mengklik 'Pesanan selesai diproses'
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'diantar' WHERE id_transaksi = '$id_transaksi'");

        mysqli_query($koneksi, "INSERT INTO notifikasi (id_pelanggan, pesan) VALUES ('$id_pelanggan', 'Pesanan sedang diantar')");
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'antar', 'Pesanan diantar oleh kurir')");
    } elseif (isset($_POST['pesanan_diterima'])) {

        //pelanggan mengklik 'Pesanan diterima'
        $tanggal_selesai = date('Y-m-d H:i:s');
        mysqli_query($koneksi, "UPDATE pesanan SET status = 'selesai', tanggal_transaksi = '$tanggal_selesai' WHERE id_transaksi = '$id_transaksi'");

        mysqli_query($koneksi, "INSERT INTO log_aktivitas (id_transaksi, aksi, keterangan) VALUES ('$id_transaksi', 'selesai', 'Pelanggan menerima pesanan')");
    }

    header('Location: ../views-admin/pesanan.php');
?>    