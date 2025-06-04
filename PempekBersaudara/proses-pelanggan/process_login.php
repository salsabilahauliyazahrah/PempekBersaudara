<?php
session_start();
include '../database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Username dan password harus diisi!";
        header("Location: login.php");
        exit();
    }

    // Query to check user credentials using nama as username
    $query = "SELECT * FROM pelanggan WHERE nama = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify password using password_verify() to compare with hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            header("Location: ../views-pelanggan/index.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Username tidak ditemukan!";
        header("Location: login.php");
        exit();
    }
}