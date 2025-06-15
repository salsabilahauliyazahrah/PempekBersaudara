<?php
    require_once('../database/koneksi.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_transaksi = $_POST['id_transaksi'];

        $query = "UPDATE pesanan SET status = 'selesai' WHERE id_transaksi = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id_transaksi);

        if ($stmt->execute()) {
            header("Location: ../views-pelanggan/riwayat.php");
            exit;
        } else {
            echo "Gagal mengubah status.";
        }
    }
?>