<?php
    session_start();

    if (isset($_POST['id_menu'])) {
        $id_menu = (int) $_POST['id_menu'];

        $redirect = $_SERVER['HTTP_REFERER'] ?? '../views-pelanggan/menu.php';

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id_menu])) {
            $_SESSION['cart'][$id_menu]++;
        } else {
            $_SESSION['cart'][$id_menu] = 1;
        }
        
        // Set notifikasi
        $_SESSION['notif'] = [
            'title' => 'Item Ditambahkan',
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'type' => 'success'
        ];

        header("Location: $redirect");
        exit();
    } else {
        echo "ID menu tidak ditemukan.";
    }
?>