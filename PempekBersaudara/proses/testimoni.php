<?php
    include('../database/koneksi.php');

    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

    $query = "SELECT 
        testimoni.rating,
        testimoni.tanggal_kirim AS tanggal_testimoni, 
        testimoni.pesan,
        pelanggan.nama_pelanggan AS nama,
        pelanggan.email 
        FROM testimoni 
        INNER JOIN pelanggan ON testimoni.id_pelanggan = pelanggan.id_pelanggan";

    if ($search != '') {
        $query .= " WHERE 
            pelanggan.nama_pelanggan LIKE '%$search%' OR 
            pelanggan.email LIKE '%$search%' ";
    }

    $query .= " ORDER BY testimoni.id_testimoni DESC"; 
    $result = mysqli_query($koneksi, $query);
?>