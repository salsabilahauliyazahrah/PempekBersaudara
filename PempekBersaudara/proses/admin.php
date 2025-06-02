<?php 
    include('../database/koneksi.php');

    $search = $_GET['search'] ?? '';
    $search = $koneksi->real_escape_string($search);

    if (!empty($search)) {
        $query = "SELECT * FROM admin
                  WHERE nama_admin LIKE '%$search%' OR
                        no_telepon LIKE '%$search%' OR
                        username LIKE '%$search%'";
    } else {
        $query = "SELECT * FROM admin";
    }

    $result = $koneksi->query($query);
?>