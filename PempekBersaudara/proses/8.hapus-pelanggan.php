<?php
    session_start();
    include '../database/koneksi.php';

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $query = "DELETE FROM pelanggan WHERE id_pelanggan = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Data pelanggan berhasil dihapus.";
        } else {
            $_SESSION['error_message'] = "Gagal menghapus data pelanggan.";
        }
    }

    header("Location: daftar-pelanggan.php");
    exit();
?>