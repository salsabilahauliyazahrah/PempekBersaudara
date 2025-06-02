<?php 
    include '../database/koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $qty = $_POST['qty'];
        $deskripsi = $_POST['deskripsi'];

        //upload gambar
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $uploadDir = "../foto-foto/foto-menu/";

        if (!empty($gambar_name)) {
            move_uploaded_file($gambar_tmp, $uploadDir . $gambar_name);
        } else {
            $gambar_name = null;
        }
        //insert ke database
        $query = "INSERT INTO menu(nama_menu, jumlah_tersedia, harga_menu, gambar_menu, deskripsi_menu)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sidss", $nama, $qty, $harga, $gambar_name, $deskripsi);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../views-admin/menu.php?success=1");
        } else {
            echo "Gagal menambahkan menu: " . mysqli_error($koneksi);
        }
    }
?>
