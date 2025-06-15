<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: ../login.php");
    exit();
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
    <link rel="stylesheet" href="../style-pelanggan/styles-index.css" />
    <link rel="stylesheet" href="../style-pelanggan/style.css" />
    <link rel="stylesheet" href="../style-pelanggan/style_keranjang.css" />
    <link rel="stylesheet" href="../style-pelanggan/notification.css" />

    <title>Keranjang - Pempek Bersaudara</title>
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
              <a href="menu.php" class="nav__link active-link">Menu</a>
            </li>
            <li class="nav__item">
              <a href="index.php#testimoni" class="nav__link">Testimoni</a>
            </li>
            <li class="nav__item">
              <a href="keranjang.php" class="nav__link">Keranjang</a>
            </li>
            <!-- User dropdown menu -->
            <li class="nav_item nav_user dropdown">              
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
                <a href="logout.php" class="dropdown-item">
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
      <section class="cart section">
        <div class="cart__container container">
            <a href="menu.php" class="button button--ghost">
              <i class="ri-arrow-left-line"></i> Kembali ke Menu
            </a>
          <div class="cart__header">
            <h2 class="section__title">Keranjang Belanja</h2> 
          </div>
          
          <div class="cart__content">
            <!-- Left Side - Cart Items & Delivery Info -->
            <div class="cart__main">
              <!-- Cart Items -->              
              <div class="cart__items">
                <?php
                include '../database/koneksi.php';

                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $id_menu => $jumlah_menu) {
                        $query = "SELECT * FROM menu WHERE id_menu = $id_menu";
                        $result = mysqli_query($koneksi, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $item = mysqli_fetch_assoc($result);
                ?>
                        <div class="cart__item">
                          <img src="../foto-foto/img/<?php echo htmlspecialchars($item['gambar_menu']); ?>" alt="<?php echo htmlspecialchars($item['nama_menu']); ?>" class="cart__item-img">
                          <div class="cart__item-content">
                            <h3 class="cart__item-title"><?php echo htmlspecialchars($item['nama_menu']); ?></h3>
                            <p class="cart__item-price">Rp<?php echo number_format($item['harga_menu'], 0, ',', '.'); ?></p>
                            <div class="cart__item-quantity">
                              <button class="quantity-btn">-</button>
                              <input type="text" class="quantity-input" value="<?php echo $jumlah_menu; ?>">
                              <input type="hidden" name="jumlah[<?= $id_menu ?>]" value="<?= $jumlah_menu ?>">
                              <button class="quantity-btn">+</button>
                            </div>
                          </div>
                          <button class="cart__item-remove"><i class="ri-delete-bin-line"></i></button>
                        </div>
                <?php
                        }
                    }
                } else {
                    echo "<p>Keranjang masih kosong.</p>";
                }
                ?>
              </div>
      
              <!-- Delivery Address -->        
              <div class="delivery__info">
                <h3 class="delivery__title">Informasi Pengiriman</h3>
                
                <div class="delivery__form">                 
                  <div class="form__group">
                    <label>Nama Penerima</label>
                    <input type="text" class="form__input" id="nama_penerima" placeholder="Masukkan nama penerima" required>
                  </div>

                  <div class="form__group">
                    <label>Alamat Lengkap</label>
                    <textarea class="form__input" rows="3" placeholder="Masukkan alamat lengkap" id="alamat_penerima" required></textarea>
                  </div>

                  <div class="form__group">
                    <label>Jarak Pengiriman (km)</label>
                    <div class="distance__input">
                      <button class="quantity-btn minus"><i class="ri-subtract-line"></i></button>
                      <input type="number" value="1" min="1" class="quantity-input" id="distance">
                      <button class="quantity-btn plus"><i class="ri-add-line"></i></button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Payment Method -->
              <div class="payment__method">
                <h3 class="payment__title">Metode Pembayaran</h3>
                
                <div class="payment__options">
                  <label class="payment__option">
                    <input type="radio" name="payment" value="cash" checked>
                    <span class="payment__check"></span>
                    <i class="ri-money-dollar-box-line"></i>
                    Tunai
                  </label> 

                  <label class="payment__option">
                    <input type="radio" name="payment" value="ewallet">
                    <span class="payment__check"></span>
                    <i class="ri-wallet-3-line"></i>
                    E-Wallet
                  </label>
                </div>
              </div>
            </div>

            <!-- Right Side - Cart Summary -->
            <div class="cart__summary">
              <h3 class="summary__title">Ringkasan Belanja</h3>
              <div class="summary__details">
                <div class="summary__item">
                  <span>Total Harga</span>
                  <span>Rp.0</span>
                </div>
                <div class="summary__item">
                  <span>Biaya Pengiriman</span>
                  <span>Rp.0</span>
                </div>
                <div class="summary__total">
                  <span>Total Pembayaran</span>
                  <span>Rp.0</span>
                </div>
              </div>

              <button type="button" class="button checkout__button" onclick="submitCheckout()">
                Checkout <i class="ri-arrow-right-line"></i>
              </button>
            </div>
          </div>

          <!--==================== HIDDEN INPUT====================-->
          <form action="../proses-pelanggan/proses-checkout.php" method="POST" id="checkoutForm" style="display: none;">
                <?php foreach ($_SESSION['cart'] as $id_menu => $jumlah): ?>
                  <input type="hidden" name="jumlah[<?= $id_menu ?>]" value="<?= $jumlah ?>">
                <?php endforeach; ?>                        
                <input type="hidden" name="nama_penerima" id="input_nama_penerima">
                <input type="hidden" name="alamat_penerima" id="input_alamat">
                <input type="hidden" name="jarak" id="input_jarak">
                <input type="hidden" name="payment" id="input_payment">
          </form>

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
              <li><a href="#menu" class="footer__link">Menu</a></li>
              <li><a href="#testimoni" class="footer__link">testimoni</a></li>
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

          <div>
            <h3 class="footer__title">Social Media</h3>
            <ul class="footer__social">
              <a href="#" target="blank" class="footer_social-link">
                <i class="ri-facebook-circle-fill"></i>
              </a>
              <a href="#" target="blank" class="footer_social-link">
                <i class="ri-instagram-fill"></i>
              </a>
              <a href="#" target="blank" class="footer_social-link">
                <i class="ri-twitter-fill"></i>
              </a>
            </ul>
          </div>
        </div>

        <img src="assets/img/leaf-branch-4.png" alt="footer image" class="footer__leaf" />
        <span class="footer__copy">&#169; 2025 Copyright. All rights reserved</span>
      </div>
    </footer>

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup" id="scroll-up">
      <i class="ri-arrow-up-line"></i>
    </a>

    <!--=============== MAIN JS ===============-->
    <script src="../javascript/main.js"></script>
    <script src="../javascript/cart.js"></script>
    <script>
      // Load cart items when page loads
      document.addEventListener('DOMContentLoaded', function() {
        loadCartItems();
        
        // Update cart when distance changes
        const distanceInput = document.getElementById('distance');
        if (distanceInput) {
          distanceInput.addEventListener('change', updateCartTotal);
        }
        
        // Initialize quantity buttons
        document.querySelectorAll('.quantity-btn').forEach(button => {
          button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            if (this.classList.contains('minus')) {
              input.value = Math.max(1, parseInt(input.value) - 1);
            } else {
              input.value = parseInt(input.value) + 1;
            }
            updateCartTotal();
          });
        });

        // Add checkout button event listener
        const checkoutButton = document.querySelector('.checkout__button');
        if (checkoutButton) {
          checkoutButton.addEventListener('click', checkout);
        }
      });
    </script>

    <!--=============== INPUT FORM ===============-->
    <script>
      function submitCheckout() {
          // Ambil nilai dari input yang terlihat
          const nama = document.getElementById('nama_penerima').value;
          const alamat = document.getElementById('alamat_penerima').value;
          const jarak = document.getElementById('distance').value;
          const metode = document.querySelector('input[name="payment"]:checked').value;

          if (!nama || !alamat || !jarak || !metode) {
            alert("Harap lengkapi semua data sebelum checkout!");
            return;
          }

          // Isi hidden input
          document.getElementById('input_nama_penerima').value = nama;
          document.getElementById('input_alamat').value = alamat;
          document.getElementById('input_jarak').value = jarak;
          document.getElementById('input_payment').value = metode;

          // Submit form
          document.getElementById('checkoutForm').submit();
      }
    </script>
  </body>
</html>