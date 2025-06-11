<?php
    session_start();

    if (isset($_POST['id_menu']) && isset($_POST['aksi']) && isset($_SESSION['cart'])) {
        $id_menu = $_POST['id_menu'];
        $aksi = $_POST['aksi'];

        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id_menu'] == $id_menu) {
                if ($aksi == 'tambah') {
                    $_SESSION['cart'][$key]['jumlah'] += 1;
                } elseif ($aksi == 'kurang' && $_SESSION['cart'][$key]['jumlah'] > 1) {
                    $_SESSION['cart'][$key]['jumlah'] -= 1;
                }
                break;
            }
        }
    }

    header("Location: ../views-pelanggan/keranjang.php");
    exit;
?>