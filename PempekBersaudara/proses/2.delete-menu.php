<?php 
include('../database/koneksi.php');

    if (isset($_GET['id'])) {
        $id_menu = (int) $_GET['id'];

        // Cek apakah id_menu masih digunakan di detail_pesanan
        $cekQuery = "SELECT COUNT(*) FROM detail_pesanan WHERE id_menu = ?";
        $stmtCek = mysqli_prepare($koneksi, $cekQuery);
        mysqli_stmt_bind_param($stmtCek, "i", $id_menu);
        mysqli_stmt_execute($stmtCek);
        mysqli_stmt_bind_result($stmtCek, $jumlah);
        mysqli_stmt_fetch($stmtCek);
        mysqli_stmt_close($stmtCek);

        if ($jumlah > 0) {
            echo "<script>
                alert('Menu tidak bisa dihapus karena masih digunakan dalam pesanan yang terhubung ke tabel detail_pesanan');
                window.location.href='../views-admin/menu.php';
            </script>";
            exit();
        }

        // Ambil data gambar menu
        $queryGet = "SELECT gambar_menu FROM menu WHERE id_menu = ?";
        $stmtGet = mysqli_prepare($koneksi, $queryGet);
        mysqli_stmt_bind_param($stmtGet, "i", $id_menu);
        mysqli_stmt_execute($stmtGet);
        $result = mysqli_stmt_get_result($stmtGet);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $namaFile = $row['gambar_menu'];

            // Hapus file gambar dari folder
            $filePath = "../foto-foto/img/" . $namaFile;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus data dari database
            $stmtDelete = mysqli_prepare($koneksi, "DELETE FROM menu WHERE id_menu = ?");
            mysqli_stmt_bind_param($stmtDelete, "i", $id_menu);
            $resultDelete = mysqli_stmt_execute($stmtDelete);

            if ($resultDelete) {
                header("Location: ../views-admin/menu.php?hapus=berhasil");
                exit();
            } else {
                echo "<script>alert('Gagal menghapus data dari database.'); window.location.href='../views-admin/menu.php';</script>";
            }
        } else {
            echo "<script>alert('Menu tidak ditemukan.'); window.location.href='../views-admin/menu.php';</script>";
        }
    } else {
        echo "<script>alert('ID menu tidak ditemukan di URL.'); window.location.href='../views-admin/menu.php';</script>";
    }
?>
