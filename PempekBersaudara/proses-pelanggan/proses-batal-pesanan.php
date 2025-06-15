<?php
    require_once('../database/koneksi.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_transaksi = $_POST['id_transaksi'];

        //Melakukan pengecekan status
        $cek = $koneksi->prepare("SELECT status, id_pelanggan, total_bayar, metode_pembayaran FROM pesanan WHERE id_transaksi = ?");
        $cek->bind_param("i", $id_transaksi);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
            if ($data['status'] === 'pending') {
                $koneksi->begin_transaction();

                try {
                    // Ubah status transaksi menjadi 'dibatalkan'
                    $update = $koneksi->prepare("UPDATE pesanan SET status = 'dibatalkan' WHERE id_transaksi = ?");
                    $update->bind_param("i", $id_transaksi);
                    $update->execute();        
                    
                    // jika pakai e-wallet, kembalikan saldo
                    if ($data['metode_pembayaran'] === 'ewallet') {
                        $refund = $koneksi->prepare("UPDATE saldo_pelanggan SET saldo = saldo + ? WHERE id_pelanggan = ?");
                        $refund->bind_param("ii", $data['total_bayar'], $data['id_pelanggan']);
                        $refund->execute();                        
                    }

                    $koneksi->commit();
                    header("Location: ../views-pelanggan/riwayat.php");
                    exit;

                } catch (Exception $e) {
                    $koneksi->rollback();
                    echo "Terjadi kesalahan: " . $e->getMessage();
                }
                
            } else {
                echo "Pesanan tidak bisa dibatalkan karena statusnya bukan 'pending'.";
            }
        } else {
            echo "Transaksi tidak ditemukan";
        }
    } else {
        echo "Transaksi tidak ditemukan";
    }
?>