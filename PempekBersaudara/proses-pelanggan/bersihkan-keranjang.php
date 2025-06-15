<?php
    session_start();
    $id_menu = $_GET['id_menu'];

    if (isset($_SESSION['cart'][$id_menu])) {
        unset($_SESSION['cart'][$id_menu]);
    }

    header('Location: ../views-pelanggan/menu.php');
    exit;
?>