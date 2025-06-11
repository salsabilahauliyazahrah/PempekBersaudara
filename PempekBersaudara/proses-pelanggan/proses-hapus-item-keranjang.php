<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_menu'], $_SESSION['cart'])) {
        $id_menu = (int) $_POST['id_menu']; // Gunakan int jika id_menu disimpan sebagai integer

        $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], function ($item) use ($id_menu) {
            return (int) $item['id_menu'] !== $id_menu;
        }));

        header("Location: ../views-pelanggan/keranjang.php");
        exit;
    }

    header("Location: ../views-pelanggan/keranjang.php");
    exit;

