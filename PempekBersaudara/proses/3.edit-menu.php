<?php
    include('../database/koneksi.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_menu    = $_POST['id_menu'];
        $nama       = $_POST['nama'];
        $harga      = $_POST['harga'];
        $qty        = $_POST['qty'];
        $deskripsi  = $_POST['deskripsi'];

        //memeriksa apakah admin melakukan upload foto baru 
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
            $gambar     = $_FILES['gambar']['name'];
            $tmp_name   = $_FILES['gambar']['tmp_name'];
            $folder     = '../foto-foto/foto-menu/';
            
            move_uploaded_file($tmp_name, $folder . $gambar);

            //terus upload
            $query = "
                UPDATE menu SET
                    nama_menu = '$nama', 
                    harga_menu = '$harga', 
                    jumlah_tersedia = '$qty', 
                    deskripsi_menu = '$deskripsi', 
                    gambar_menu = '$gambar'
                where id_menu = '$id_menu';   
            ";
        } else {
            //jika gaada gambar yang diupadte, update data yang lainnya aja
            $query = "
                UPDATE menu SET 
                    nama_menu = '$nama', 
                    harga_menu = '$harga', 
                    jumlah_tersedia = '$qty', 
                    deskripsi_menu = '$deskripsi'
                WHERE id_menu = '$id_menu'
            ";
        }
        //eksekusi kueri 
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Menu berhasil diperbarui'); window.location.href='../views-admin/menu.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui menu'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Permintaan tidak valid'); window.history.back();</script>";
    }


?>