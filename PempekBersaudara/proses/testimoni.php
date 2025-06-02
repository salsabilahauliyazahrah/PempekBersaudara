<?php
    include('../database/koneksi.php');

    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

    $query = "SELECT * FROM testimoni";
    if ($search != '') {
        $query .= " WHERE 
            nama LIKE '%$search%' OR 
            email LIKE '%$search%' OR 
            pesan LIKE '%$search%'";
    }

    $query .= " ORDER BY id_testimoni DESC"; 
    $result = mysqli_query($koneksi, $query);
?>