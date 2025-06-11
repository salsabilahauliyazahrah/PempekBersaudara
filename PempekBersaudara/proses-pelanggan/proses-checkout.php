<?php
    session_start();
    include '../database/koneksi.php';
    
    if (!isset($_SESSION['id_pelanggan'])) {
        header("Location: ../views-pelanggan/login.php");
        exit;
    }

    if (empty($_POST['nama_penerima']) || empty($_POST['alamat'])) {
        echo "Nama penerima dan alamat wajib diisi.";
        exit;
    }

    if (empty($_SESSION['cart'])) {
        echo "Keranjang kosong!";
        exit;
    }

    $id_pelanggan = $_SESSION['id_pelanggan'];
    $nama_penerima = $_POST['nama_penerima'];
    $alamat = $_POST['alamat'];
    $jarak = intval($_POST['jarak']);

    // Contoh hitung ongkir: Rp5000 per km
    $ongkir = 5000 * $jarak;

    $total_harga = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_harga += $item['harga'] * $item['jumlah'];
    }

    $total_pembayaran = $total_harga + $ongkir;

    // Simpan ke tabel pesanan
    $query1 = "INSERT INTO pesanan (id_pelanggan, nama_penerima, alamat_pengiriman, total_harga, ongkir)
            VALUES (?, ?, ?, ?, ?)";
    $stmt1 = $koneksi->prepare($query1);
    $stmt1->bind_param("issdd", $id_pelanggan, $nama_penerima, $alamat, $total_harga, $ongkir);

    if (!$stmt1->execute()) {
        die("Gagal menyimpan pesanan: " . $stmt1->error);
    }
    $id_transaksi = $stmt1->insert_id;

    //menyimpan data ke tabel detail_pesanan
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['harga'] * $item['jumlah'];
        $query2 = "INSERT INTO detail_pesanan (id_transaksi, id_menu, jumlah, harga_satuan, subtotal)
               VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $koneksi->prepare($query2);
        $stmt2->bind_param("iiidd", $id_transaksi, $item['id_menu'], $item['jumlah'], $item['harga'], $subtotal);
        $stmt2->execute();
    }

    // Setelah selesai
    unset($_SESSION['cart']); // kosongkan keranjang
    header("Location: konfirmasi_pesanan.php?id=$id_transaksi");
    exit();
?>