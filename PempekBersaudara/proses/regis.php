<?php 
    include '../database/koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $koneksi->real_escape_string($_POST["nama"]);
        $telepon = $koneksi->real_escape_string($_POST["telepon"]);
        $username = $koneksi->real_escape_string($_POST["username"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $query = "INSERT INTO admin (nama_admin, no_telepon, username, password) 
                  VALUES ('$nama', '$telepon', '$username', '$password')";

        if ($koneksi->query($query) === TRUE) {
            $_SESSION['successMessage'] = "Registrasi berhasil! Silakan login.";
        } else {
            $_SESSION['errorMessage'] = "Terjadi kesalahan pada database: " . $koneksi->error;
        }

        header("Location: ../views-admin/login.php");
        exit();
    }
?>