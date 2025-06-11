<?php
    session_start();
    include '../database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_menu'])) {
        $id_menu = mysqli_real_escape_string($koneksi, $_POST['id_menu']);

        $query = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
        $result = mysqli_query($koneksi, $query);
        $menu = mysqli_fetch_assoc($result);

        if ($menu) {
            $item = [
                'id_menu' => $menu['id_menu'],
                'nama' => $menu['nama_menu'],
                'harga' => $menu['harga_menu'],
                'gambar' => $menu['gambar_menu'],
                'jumlah' => 1
            ];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as $key => $cart_item) {
                if ($cart_item['id_menu'] == $id_menu) {
                    $_SESSION['cart'][$key]['jumlah'] += 1;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $_SESSION['cart'][] = $item;
            }
        }
    }

    header("Location: ../views-pelanggan/keranjang.php");
    exit;
?>