<?php 
    include '../database/koneksi.php';

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $query = "DELETE FROM admin WHERE id_admin = $id";

        if ($koneksi->query($query) == TRUE) {
            header("Location: ../views-admin/admin.php?status=hapus-sukses");
        } else {
            echo "Gagal menghapus data admin: " . $koneksi->error;
        }
    } else {
        echo "ID admin tidak ditemukan.";
    }
?>