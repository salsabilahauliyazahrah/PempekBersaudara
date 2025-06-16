<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once('../database/koneksi.php');

// Get balance from database
$username = $_SESSION['user_name'];
$query = "SELECT s.saldo 
          FROM saldo_pelanggan s 
          JOIN pelanggan p ON s.id_pelanggan = p.id_pelanggan 
          WHERE p.nama = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['saldo'] = $row['saldo'];
} else {
    // If no balance record exists, create one with 0 balance
    $queryGetId = "SELECT id_pelanggan FROM pelanggan WHERE nama = ?";
    $stmtGetId = $koneksi->prepare($queryGetId);
    $stmtGetId->bind_param("s", $username);
    $stmtGetId->execute();
    $resultId = $stmtGetId->get_result();
    $userId = $resultId->fetch_assoc()['id_pelanggan'];
    
    $queryInsert = "INSERT INTO saldo_pelanggan (id_pelanggan, saldo) VALUES (?, 0)";
    $stmtInsert = $koneksi->prepare($queryInsert);
    $stmtInsert->bind_param("i", $userId);
    $stmtInsert->execute();
    $_SESSION['saldo'] = 0;
}
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
    <link rel="stylesheet" href="../style-pelanggan/notification.css" />
    <link rel="stylesheet" href="../style-pelanggan/style_saldo.css" />

    <title>Saldo - Pempek Bersaudara</title>
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
                <a href="saldo.php" class="dropdown-item active">
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
          <div class="row justify-content-center">
            <div class="col-md-6">
              <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success" role="alert">
                  <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                  ?>
                </div>
              <?php endif; ?>
              
              <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                  <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                  ?>
                </div>
              <?php endif; ?>

              <div class="text-center mb-4">
                <h2 class="section__title">Saldo Anda</h2>
                <div class="balance-amount">
                  <span class="amount">Rp<?php echo number_format($_SESSION['saldo'], 0, ',', '.'); ?></span>
                </div>
              </div>
              
              <div class="card">
                <div class="card-body">
                  <form id="topupForm" action="../proses-pelanggan/process_topup.php" method="POST">
                    <div class="mb-4">
                      <label for="amount" class="form-label">Jumlah Top Up</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               min="5000" max="100000" step="1000" required
                               placeholder="Minimal Rp5.000">
                      </div>
                      <small class="text-muted">Minimal Rp5.000, Maksimal Rp100.000</small>
                    </div>

                    <div class="quick-amounts mb-4">
                      <label class="form-label">Pilihan Cepat</label>
                      <div class="d-grid gap-2">
                        <div class="row g-2">
                          <div class="col-6">
                            <button type="button" class="quick-amount-btn w-100" data-amount="10000">Rp10.000</button>
                          </div>
                          <div class="col-6">
                            <button type="button" class="quick-amount-btn w-100" data-amount="20000">Rp20.000</button>
                          </div>
                          <div class="col-6">
                            <button type="button" class="quick-amount-btn w-100" data-amount="50000">Rp50.000</button>
                          </div>
                          <div class="col-6">
                            <button type="button" class="quick-amount-btn w-100" data-amount="100000">Rp100.000</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="button w-100">
                      Top Up Saldo
                    </button>
                  </form>
                </div>
              </div>
            </div>
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
              <li><a href="index.php#testimoni" class="footer__link">testimoni</a></li>
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
    <script>
      document.querySelectorAll('.quick-amount-btn').forEach(button => {
        button.addEventListener('click', function() {
          const amount = this.dataset.amount;
          document.getElementById('amount').value = amount;
        });
      });

      document.getElementById('topupForm').addEventListener('submit', function(e) {
        const amount = parseInt(document.getElementById('amount').value);
        if (amount < 5000) {
          e.preventDefault();
          alert('Minimal top up Rp5.000');
        } else if (amount > 100000) {
          e.preventDefault();
          alert('Maksimal topup Rp100.000');
        }
      });
    </script>
  </body>
</html>
