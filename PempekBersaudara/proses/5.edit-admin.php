<?php 
    include '../database/koneksi.php';

    $id = $_POST['id_admin'];
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $telepon = $koneksi->real_escape_string($_POST['telepon']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin 
                SET nama_admin='$nama', no_telepon='$telepon', username='$username', password='$hashed' 
                WHERE id_admin = $id";
    } else {
        $query = "UPDATE admin 
                SET nama_admin='$nama', no_telepon='$telepon', username='$username' 
                WHERE id_admin = $id";
    }

    if ($koneksi->query($query) === TRUE) {
        header("Location: ../views-admin/admin.php?status=edit-sukses");
    } else {
        echo "Gagal update: " . $koneksi->error;
    }
?>