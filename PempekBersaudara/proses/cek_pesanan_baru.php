<?php
    session_start();
    require '../database/koneksi.php'; // Ganti sesuai path koneksi database kamu

    // Query untuk hitung jumlah pesanan dengan status 'pending'
    $result = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_pending FROM pesanan WHERE status = 'pending'");

    // Ambil hasil query
    $data = mysqli_fetch_assoc($result);

    // Ubah ke format JSON agar bisa dibaca JavaScript
    echo json_encode(['jumlah_pending' => $data['jumlah_pending']]);
?>