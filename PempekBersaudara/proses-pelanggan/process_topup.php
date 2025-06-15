<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: ../views-pelanggan/login.php");
    exit();
}

require_once('../database/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = intval($_POST['amount']);
    
    // Validate amount
    if ($amount < 5000) {
        $_SESSION['error'] = "Minimal top up Rp5.000";
        header("Location: ../views-pelanggan/saldo.php");
        exit();
    }
    
    if ($amount > 100000) {
        $_SESSION['error'] = "Maksimal top up Rp100.000";
        header("Location: ../views-pelanggan/saldo.php");
        exit();
    }
    
    // Get user ID
    $username = $_SESSION['user_name'];
    $queryUserId = "SELECT id_pelanggan FROM pelanggan WHERE nama = ?";
    $stmtUserId = $koneksi->prepare($queryUserId);
    $stmtUserId->bind_param("s", $username);
    $stmtUserId->execute();
    $resultUserId = $stmtUserId->get_result();
    
    if ($resultUserId->num_rows > 0) {
        $userId = $resultUserId->fetch_assoc()['id_pelanggan'];
        
        // Update balance in database
        $queryUpdate = "UPDATE saldo_pelanggan SET saldo = saldo + ? WHERE id_pelanggan = ?";
        $stmtUpdate = $koneksi->prepare($queryUpdate);
        $stmtUpdate->bind_param("ii", $amount, $userId);
        
        if ($stmtUpdate->execute()) {
            // Update session balance
            $_SESSION['saldo'] += $amount;
            
            // Set success message
            $_SESSION['success'] = "Berhasil menambahkan saldo Rp" . number_format($amount, 0, ',', '.');
        } else {
            $_SESSION['error'] = "Gagal menambahkan saldo. Silahkan coba lagi.";
        }
    } else {
        $_SESSION['error'] = "User tidak ditemukan.";
    }
    
    header("Location: ../views-pelanggan/saldo.php");
    exit();
} else {
    header("Location: ../views-pelanggan/saldo.php");
    exit();
}
?>
