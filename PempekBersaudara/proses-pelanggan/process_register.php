<?php
session_start();
include '../database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nama = trim($_POST['nama_pelanggan']);
    $no_tlp = trim($_POST['no_telepon']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($nama) || empty($no_tlp) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "Semua field harus diisi!";
        header("Location: ../views-pelanggan/login.php");
        exit();
    }

    if (!preg_match('/^[0-9]{10,15}$/', $no_tlp)) {
        $_SESSION['register_error'] = "Format nomor telepon tidak valid!";
        header("Location: ../views-pelanggan/login.php");
        exit();
    }

    $check_query = "SELECT * FROM pelanggan WHERE email = ?";
    $check_stmt = $koneksi->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = "Email sudah terdaftar!";
    } else {
        $check_nama_query = "SELECT * FROM pelanggan WHERE nama_pelanggan = ?";
        $check_nama_stmt = $koneksi->prepare($check_nama_query);
        $check_nama_stmt->bind_param("s", $nama);
        $check_nama_stmt->execute();
        $nama_result = $check_nama_stmt->get_result();

        if ($nama_result->num_rows > 0) {
            $_SESSION['register_error'] = "Username sudah digunakan!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_query = "INSERT INTO pelanggan (nama_pelanggan, no_telepon, email, password) VALUES (?, ?, ?, ?)";
            $insert_stmt = $koneksi->prepare($insert_query);
            $insert_stmt->bind_param("ssss", $nama, $no_tlp, $email, $hashed_password);
            
            if ($insert_stmt->execute()) {
                $_SESSION['register_success'] = "Registrasi berhasil! Silakan login.";
            } else {
                $_SESSION['register_error'] = "Gagal mendaftar! Silakan coba lagi.";
            }
        }
    }
    
    header("Location: ../views-pelanggan/login.php");
    exit();
}
?>