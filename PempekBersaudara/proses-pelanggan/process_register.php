<?php
session_start();
require_once '../database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nama = trim($_POST['nama']);
    $no_telepon = trim($_POST['no_telepon']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Basic validation
    if (empty($nama) || empty($no_telepon) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "Semua field harus diisi!";
        header("Location: ../views-pelanggan/login.php");
        exit();
    }

    // Validate phone number format
    if (!preg_match('/^[0-9]{10,15}$/', $no_telepon)) {
        $_SESSION['register_error'] = "Format nomor telepon tidak valid!";
        header("Location: ../views-pelanggan/login.php");
        exit();
    }

    // Check if email already exists
    $check_query = "SELECT * FROM pelanggan WHERE email = ?";
    $check_stmt = $koneksi->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = "Email sudah terdaftar!";
    } else {
        // Check if username (nama) already exists
        $check_nama_query = "SELECT * FROM pelanggan WHERE nama = ?";
        $check_nama_stmt = $koneksi->prepare($check_nama_query);
        $check_nama_stmt->bind_param("s", $nama);
        $check_nama_stmt->execute();
        $nama_result = $check_nama_stmt->get_result();

        if ($nama_result->num_rows > 0) {
            $_SESSION['register_error'] = "Username sudah digunakan!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user with no_tlp as VARCHAR
            $insert_query = "INSERT INTO pelanggan (nama, no_telepon, email, password) VALUES (?, ?, ?, ?)";
            $insert_stmt = $koneksi->prepare($insert_query);
            $insert_stmt->bind_param("ssss", $nama, $no_telepon, $email, $hashed_password);
            
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