<?php
    session_start();
    include '../database/koneksi.php';

    // Pastikan user login dan keranjang tidak kosong
    if (!isset($_SESSION['id_pelanggan']) || empty($_SESSION['cart'])) {
        header("Location: ../views-pelanggan/menu.php");
        exit;
    }

    // Ambil data dari form
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $nama_penerima = $_POST['nama_penerima'];
    $alamat_penerima = $_POST['alamat_penerima'];
    $jarak = (float) $_POST['jarak'];
    $payment = $_POST['payment'];

    // Hitung total harga makanan
    $total_harga = 0;
    foreach ($_SESSION['cart'] as $id_menu => $jumlah) {
        $query = mysqli_query($koneksi, "SELECT harga_menu FROM menu WHERE id_menu = $id_menu");
        $row = mysqli_fetch_assoc($query);
        $subtotal = $row['harga_menu'] * $jumlah;
        $total_harga += $subtotal;
    }

    // Hitung ongkir (misalnya 2000/km)
    $ongkir_per_km = 2000;
    $biaya_ongkir = $jarak * $ongkir_per_km;

    // Total pembayaran
    $total_bayar = $total_harga + $biaya_ongkir;

    // Cek saldo jika pakai e-wallet
    if ($payment == 'ewallet') {
        $cekSaldo = mysqli_query($koneksi, "SELECT saldo FROM saldo_pelanggan WHERE id_pelanggan = $id_pelanggan");
        $dataSaldo = mysqli_fetch_assoc($cekSaldo);

        if ($dataSaldo['saldo'] < $total_bayar) {
            echo "<script>alert('Saldo tidak cukup'); window.location='../views-pelanggan/menu.php';</script>";
            exit;
        }

        // Kurangi saldo pelanggan (sementara di-hold)
        $saldoBaru = $dataSaldo['saldo'] - $total_bayar;
        
        mysqli_query($koneksi, "UPDATE saldo_pelanggan SET saldo = $saldoBaru WHERE id_pelanggan = $id_pelanggan");
    }

    // Simpan ke tabel pesanan
    $tanggal = date("Y-m-d H:i:s");
    $status = 'pending'; // default
    $queryPesanan = mysqli_query($koneksi, "INSERT INTO pesanan (id_pelanggan, nama_penerima, alamat_penerima, jarak, ongkir, total_harga, total_bayar, metode_pembayaran, status, tanggal_transaksi)
    VALUES ($id_pelanggan, '$nama_penerima', '$alamat_penerima', $jarak, $biaya_ongkir, $total_harga, $total_bayar, '$payment', '$status', '$tanggal')");

    $id_transaksi = mysqli_insert_id($koneksi);

    // Simpan ke tabel detail_pesanan
    foreach ($_SESSION['cart'] as $id_menu => $jumlah) {
        $query = mysqli_query($koneksi, "SELECT harga_menu FROM menu WHERE id_menu = $id_menu");
        $row = mysqli_fetch_assoc($query);
        $harga_satuan = $row['harga_menu'];
        $subtotal = $harga_satuan * $jumlah;

        mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_transaksi, id_menu, jumlah, harga_satuan, subtotal)
        VALUES ($id_transaksi, $id_menu, $jumlah, $harga_satuan, $subtotal)");
    }

    // Bersihkan keranjang
    unset($_SESSION['cart']);

    echo "<script>alert('Checkout berhasil! Menunggu konfirmasi admin.'); window.location='../views-pelanggan/riwayat.php';</script>";
?>