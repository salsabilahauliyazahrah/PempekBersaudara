<?php
  require_once('../database/koneksi.php');
  session_start();
  if (!isset($_SESSION['user_name'])) {
      header("Location: login.php");
      exit();
  }

  $username = $_SESSION['user_name'];

  $query = "SELECT ps.*, dp.*, m.nama_menu, m.gambar_menu, dp.harga_satuan, p.nama as pembeli 
            FROM pesanan ps
            JOIN pelanggan p ON ps.id_pelanggan = p.id_pelanggan
            JOIN detail_pesanan dp ON ps.id_transaksi = dp.id_transaksi
            JOIN menu m ON dp.id_menu = m.id_menu
            WHERE p.nama = ?
            ORDER BY ps.tanggal_transaksi DESC";

  $stmt = $koneksi->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  $current_order_id = null;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="../foto-foto/Favicon.png" type="image/x-icon" />

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../style-pelanggan/style.css" />
    <link rel="stylesheet" href="../style-pelanggan/style_riwayat.css" />

    <title>Riwayat Pesanan - Pempek Bersaudara</title>
  </head>
  <body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
      <nav class="nav container">
        <a href="index.php" class="nav__logo">
          <img src="../foto-foto/Favicon.png" alt="logo">
          Pempek Bersaudara
        </a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item">
              <a href="index.php#home" class="nav__link">Beranda</a>
            </li>
            <li class="nav__item">
              <a href="menu.php" class="nav__link">Menu</a>
            </li>
            <li class="nav__item">
              <a href="index.php#testimoni" class="nav__link">Testimoni</a>
            </li>
            <li class="nav__item">
              <a href="keranjang.php" class="nav__link">Keranjang</a>
            </li>
            <!-- User dropdown menu -->
            <li class="nav__item nav__user dropdown">
              <div class="nav__user-menu" id="userMenu">
                <span class="nav__user-greeting">Hi, <?php echo $_SESSION['user_name']; ?></span>
                <i class="ri-arrow-down-s-line dropdown-icon"></i>
              </div>
              <div class="dropdown-content">
                <a href="saldo.php" class="dropdown-item">
                  <i class="ri-wallet-3-line"></i> Saldo
                </a>
                <a href="riwayat.php" class="dropdown-item active">
                  <i class="ri-history-line"></i> Riwayat Pesanan
                </a>
                <a href="../proses-pelanggan/logout.php" class="dropdown-item">
                  <i class="ri-logout-box-line"></i> Logout
                </a>
              </div>
            </li>
            <li class="nav__item">
              <i class="ri-moon-line change-theme" id="theme-button"></i>
            </li>
          </ul>

          <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
          </div>
        </div>

        <div class="nav__toggle" id="nav-toggle">
          <i class="ri-apps-2-line"></i>
        </div>
      </nav>
    </header>

    <!--==================== MAIN ====================-->
    <main class="main">
      <section class="section">
        <div class="container">
          <h2 class="section__title text-center mb-4">Riwayat Pesanan</h2>
          
          <div class="order__history">

            <?php 
              if ($result->num_rows > 0) {
                $status_badge = [
                  'pending' => 'warning', 
                  'diproses' => 'info',
                  'diantar' => 'primary',
                  'selesai' => 'success',
                  'ditolak' => 'danger',
                  'dibatalkan' => 'secondary',   
                  'kosong' => 'dark'
                ];
                while ($row = $result->fetch_assoc()) {
                  if ($current_order_id != $row['id_transaksi']) {
                    if ($current_order_id !== null) {
                      echo '</div>';
                      echo '</div>';
                    }

                    //mulai pesanan baru 
                    echo '<div class="order__card">';
                    echo '<div class="order__header">';
                    echo '<div class="order__info">';
                    echo '<p><strong>Tanggal:</strong> ' . date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])) . '</p>';
                    echo '<p><strong>Penerima:</strong> ' . htmlspecialchars($row['nama_penerima']) . '</p>';
                    echo '<p><strong>Alamat:</strong> ' . htmlspecialchars($row['alamat_penerima']) . '</p>';
                    echo '</div>';
                    echo '<div class="order__payment">';
                    echo '<p><strong>Metode Pembayaran:</strong> ' . ($row['metode_pembayaran'] === 'cash' ? 'Tunai' : 'E-Wallet') . '</p>';
                    echo '<p><strong>Total Pembayaran:</strong> ' . 'Rp' . number_format($row['total_bayar'], 0, ',', '.') . '</p>';

                    $status = $row['status'];
                    $badge_class = isset($status_badge[$status]) ? $status_badge[$status] : 'secondary';
                    echo '<p><strong>Status:</strong> <span class="badge bg-' . $status_badge[$row['status']] . ' text-white">' . ucfirst($row['status']) . '</span></p>';

                    // Jika status masih pending, maka akan menampilkan tombol batalkan dari pihak pelanggan
                    if ($row['status'] == 'pending') {
                      echo '<form method="POST" action="../proses-pelanggan/proses-batal-pesanan.php" onsubmit="return confirm(\'Apakah kamu yakin ingin membatalkan pesanan ini?\')">';
                      echo '<input type="hidden" name="id_transaksi" value="' . $row['id_transaksi'] . '">';
                      echo '<button type="submit" class="button btn btn-danger btn-sm mt-2">Batalkan Pesanan</button>';
                      echo '</form>';
                    }                    

                    //notifikasi jika ditolak
                    if ($row['status'] === 'ditolak') {
                      echo '<p class="text-danger"><em>Maaf, pesanan ini telah ditolak oleh admin.</em></p>';
                    }

                    //notifikasi stok tidak tersedia
                    if ($row['status'] === 'kosong') {
                        echo '<p class="text-warning"><em>Maaf, pesanan dibatalkan karena produk sudah tidak tersedia.</em></p>';
                    }

                    //Tombol konfirmasi jika pesanan dikonfirmasi oleh admin
                    if ($row['status'] == 'diantar') {
                      echo '<form method="POST" action="../proses-pelanggan/proses-pesanan-diterima.php">';
                      echo '<input type="hidden" name="id_transaksi" value="' . $row['id_transaksi'] . '">';
                      echo '<button type="submit" class="button btn btn-success btn-sm mt-2">Pesanan Diterima</button>';
                      echo '</form>';
                    }

                    echo '</div>'; // tutup order__payment
                    echo '</div>'; // tutup order__header
                    echo '<div class="order__items">';
                    $current_order_id = $row['id_transaksi'];
                  }

                  // Menampilkan item dalam order
                  echo '<div class="order__item d-flex align-items-center mb-2 p-2 rounded bg-light">';
                  echo '<img src="../foto-foto/img/' . htmlspecialchars($row['gambar_menu']) . '" alt="' . htmlspecialchars($row['nama_menu']) . '" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">';
                  echo '<div>';
                  echo '<strong>' . htmlspecialchars($row['nama_menu']) . '</strong><br>';
                  echo 'Jumlah: ' . $row['jumlah'] . '<br>';
                  echo 'Harga: Rp' . number_format($row['harga_satuan'] * $row['jumlah'], 0, ',', '.');
                  echo '</div>';
                  echo '</div>';
                }

                // Menutup div terakhir setelah loop
                echo '</div>'; // order__items
                echo '</div>'; // order__card
              } else {
                echo '<p class="text-center">Belum ada riwayat pesanan.</p>';
              }
            ?>
            
          </div>
        </div>
      </section>
    </main>

    <!--==================== FOOTER ====================-->
    <footer class="footer">
      <div class="footer__container container grid">
        <div>
          <a href="#" class="footer__logo">
            <img src="../foto-foto/Favicon.png" alt="footer image" />
            Pempek Bersaudara
          </a>
          <p class="footer__description">
            Berbagai jenis pempek <br />
            Terbuat dari olahan ikan <br />
            Mantap Poll!
          </p>
        </div>

        <div class="footer__content">
          <div>
            <h3 class="footer__title">Menu Utama</h3>
            <ul class="footer__links">
              <li><a href="menu.php" class="footer__link">Menu</a></li>
              <li><a href="index.php#testimoni" class="footer__link">Testimoni</a></li>
            </ul>
          </div>

          <div>
            <h3 class="footer__title">Alamat</h3>
            <ul class="footer__links">
              <li class="footer__information">
                Jl. Jakarta No. 118 <br />
                Bandung
              </li>
              <li class="footer__information">08:00 - 21:00</li>
            </ul>
          </div>
        </div>

        <img src="../foto-foto/img/leaf-branch-4.png" alt="footer image" class="footer__leaf" />
        <span class="footer__copy">&#169; 2025 Copyright. All rights reserved</span>
      </div>
    </footer>

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup" id="scroll-up">
      <i class="ri-arrow-up-line"></i>
    </a>

    <!--=============== MAIN JS ===============-->
    <script src="../javascript/main.js"></script>
  </body>
</html>
