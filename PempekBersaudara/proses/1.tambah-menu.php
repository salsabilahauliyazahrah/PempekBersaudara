<?php 
    include '../database/koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $qty = $_POST['qty'];
        $deskripsi = $_POST['deskripsi'];
        $bahanBahan = $_POST['bahanBahan'];
        $detail = $_POST['detail'];

        // Upload gambar
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $uploadDir = "../foto-foto/foto-menu/";

        if (!empty($gambar_name)) {
            move_uploaded_file($gambar_tmp, $uploadDir . $gambar_name);
        } else {
            $gambar_name = null;
        }

        // Insert ke database (tambahkan bahan_menu dan detail_menu)
        $query = "INSERT INTO menu(nama_menu, jumlah_tersedia, harga_menu, gambar_menu, deskripsi_menu, bahan_menu, detail_menu)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "sidssss", $nama, $qty, $harga, $gambar_name, $deskripsi, $bahanBahan, $detail);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../views-admin/menu.php?success=1");
        } else {
            echo "Gagal menambahkan menu: " . mysqli_error($koneksi);
        }
    }
?>
