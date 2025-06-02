<?php 
    include('../database/koneksi.php');

    if (isset($_GET['id'])) {
        $id_menu = $_GET['id'];

        //mengambil data menu berdasarkan id
        $queryGet = "SELECT gambar_menu FROM menu WHERE id_menu = '$id_menu'";
        $resultGet = mysqli_query($koneksi, $queryGet);

        if ($resultGet && mysqli_num_rows($resultGet) > 0) {
            $row = mysqli_fetch_assoc($resultGet);
            $namaFile= $row['gambar_menu'];
            
            //bagian menghapus file gambar dari folder
            $filePath = "../foto-foto/foto-menu/" . $nama_file;
            if (file_exists($filePath)) {
                unlink ($filePath);
            }

            //bagian menghaous data dari database
            $stmtDelete = mysqli_prepare($koneksi, "DELETE FROM menu WHERE id_menu = ?");
            mysqli_stmt_bind_param($stmtDelete, "i", $id_menu);
            $resultDelete = mysqli_stmt_execute($stmtDelete);

            if ($resultDelete) {
                header("Location: ../views-admin/menu.php?hapus=berhasil");
                exit();
            } else {
                echo "Gagal menghapus data dari database.";
            }
        } else {
            echo "Menu tidak ditemukan.";
        }
    } else {
        echo "ID menu tidak ditemukan di URL.";
    }
?>