<?php
session_start();
require_once('../database/koneksi.php');

if (!isset($_SESSION['user_name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Silahkan login terlebih dahulu']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];
    $nama_penerima = $_POST['nama_penerima'];
    $alamat = $_POST['alamat'];
    $distance = $_POST['distance'];
    $items = json_decode($_POST['items'], true);
    
    // Validasi total ulang
    $expected_total = 0;
    foreach ($items as $item) {
        $item_price = intval(str_replace(['Rp', '.', ','], '', $item['price']));
        $expected_total += $item_price * $item['quantity'];
    }
    $expected_total += $distance * 2000;

    if ($expected_total != $total_amount) {
        echo json_encode(['status' => 'error', 'message' => 'Total pembayaran tidak valid']);
        exit();
    }

    $username = $_SESSION['user_name'];
    
    // Get user's ID and current balance
    $query = "SELECT p.id_pelanggan, s.saldo 
            FROM pelanggan p 
            JOIN saldo_pelanggan s ON p.id_pelanggan = s.id_pelanggan 
            WHERE p.nama = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($payment_method === 'ewallet') {
        // Check if user has enough balance
        if ($user['saldo'] < $total_amount) {
            echo json_encode(['status' => 'error', 'message' => 'Saldo tidak mencukupi']);
            exit();
        }
        
        // Update user's balance
        $new_balance = $user['saldo'] - $total_amount;
        $update_query = "UPDATE saldo_pelanggan SET saldo = ? WHERE id_pelanggan = ?";
        $update_stmt = $koneksi->prepare($update_query);
        $update_stmt->bind_param("ii", $new_balance, $user['id_pelanggan']);
        
        if (!$update_stmt->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memproses pembayaran']);
            exit();
        }
        
        $_SESSION['saldo'] = $new_balance;
    }
    
    // Create orders table if it doesn't exist
    $create_table_query = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_pelanggan INT,
        nama_penerima VARCHAR(255),
        alamat TEXT,
        total_amount DECIMAL(10,2),
        payment_method VARCHAR(50),
        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
    )";
    $koneksi->query($create_table_query);
    
    // Create order_items table if it doesn't exist
    $create_items_table_query = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        item_name VARCHAR(255),
        quantity INT,
        price DECIMAL(10,2),
        FOREIGN KEY (order_id) REFERENCES orders(id)
    )";
    $koneksi->query($create_items_table_query);
    
    // Start transaction
    $koneksi->begin_transaction();
    
    try {
        // Insert order into database
        $insert_query = "INSERT INTO orders (id_pelanggan, nama_penerima, alamat, total_amount, payment_method) 
                        VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $koneksi->prepare($insert_query);
        $insert_stmt->bind_param("issds", $user['id_pelanggan'], $nama_penerima, $alamat, $total_amount, $payment_method);
        
        if (!$insert_stmt->execute()) {
            throw new Exception('Failed to save order');
        }
        
        $order_id = $koneksi->insert_id;
        
        // Insert order items
        $insert_items_query = "INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)";
        $insert_items_stmt = $koneksi->prepare($insert_items_query);
        
        foreach ($items as $item) {
            $price = intval(str_replace(['Rp', '.', ','], '', $item['price']));
            $insert_items_stmt->bind_param("isid", $order_id, $item['name'], $item['quantity'], $price);
            
            if (!$insert_items_stmt->execute()) {
                throw new Exception('Failed to save order items');
            }
        }
        
        // If everything is successful, commit the transaction
        $koneksi->commit();
        echo json_encode(['status' => 'success', 'message' => 'Pembayaran berhasil']);
        exit();
        
    } catch (Exception $e) {
        // If there's an error, rollback everything
        $koneksi->rollback();
        
        if ($payment_method === 'ewallet') {
            // Rollback the balance update if order insertion fails
            $rollback_query = "UPDATE saldo_pelanggan SET saldo = ? WHERE id_pelanggan = ?";
            $rollback_stmt = $koneksi->prepare($rollback_query);
            $original_balance = $user['saldo'];
            $rollback_stmt->bind_param("ii", $original_balance, $user['id_pelanggan']);
            $rollback_stmt->execute();
            $_SESSION['saldo'] = $original_balance;
        }
        
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesanan']);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit();
}
?>