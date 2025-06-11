<?php 
    //Mulai sesi 
    session_start();

    //koneksi ke database
    require_once '../database/koneksi.php';

    //AMbild ata dari form
    $masukan = $_POST['masukan'];
    $rating = $_POST['rating'];

    if (!isset($_SESSION['id_pelanggan'])) {
        echo "<script>alert('Anda harus login untuk mengirim testimoni.'); window.location.href='../views-pelanggan/index.php';</script>";
        exit();
    }

    //mengambil id pelanggan dari session 
    $id_pelanggan = $_SESSION['id_pelanggan'];

    //validasi sederhana
    if (!empty($masukan) && !empty($rating) && !empty($id_pelanggan)) {
        $stmt = $koneksi->prepare("INSERT INTO testimoni (id_pelanggan, pesan, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $id_pelanggan, $masukan, $rating);

        if ($stmt->execute()) {
            echo "<script>alert('Testimoni berhasil dikirim!'); window.location.href='../views-pelanggan/index.php';</script>";
        } else {
            echo "Terjadi kesalahan saat menyimpan testimoni: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Mohon lengkapi semua data!";
    }

    $koneksi->close();

?>