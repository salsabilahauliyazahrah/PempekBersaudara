<?php
  session_start();
  if (!isset($_SESSION['user_name'])) {
      header("Location: ../views-pelanggan/login.php");
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
    <link rel="stylesheet" href="../style-pelanggan/style.css" />
    <link rel="stylesheet" href="../style-pelanggan/style_keranjang.css" />

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
              <a href="menu.php" class="nav__link">Menu</a>
            </li>
            <li class="nav__item">
              <a href="index.php#testimoni" class="nav__link">Testimoni</a>
            </li>
            <li class="nav__item">
              <a href="keranjang.php" class="nav__link active-link">Keranjang</a>
            </li>
            <!-- User dropdown menu -->
            <li class="nav__item nav__user dropdown">
              <div class="nav__user-menu" id="userMenu">
                <span class="nav__user-greeting">Hi, <?php echo $_SESSION['user_name']; ?></span>
                <i class="ri-arrow-down-s-line dropdown-icon"></i>
              </div>
              <div class="dropdown-content">
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
                <!-- Cart  -->
              <?php 
                $total_harga = 0;

                if (!empty($_SESSION['cart'])) {
                  foreach ($_SESSION['cart'] as $item) {
                    $subtotal = $item['harga'] * $item['jumlah'];
                    $total_harga += $subtotal;
              ?>
                <div class="cart__item">
                  <!-- bersihkan item keranjang  -->
                  <form action="../proses-pelanggan/bersihkan-keranjang.php" method="post">
                    <button type="submit" class="btn btn-danger">Kosongkan Keranjang</button>
                  </form>

                  <img src="../foto-foto/foto-menu/<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="cart__item-img">
                  <div class="cart__item-content">
                    <h3 class="cart__item-title"><?php echo htmlspecialchars($item['nama']); ?></h3>
                    <p class="cart__item-price">Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></p>

                    <!-- ubah jumlah item keranjang -->
                    <div class="cart__item-quantity">
                      <form action="../proses-pelanggan/proses-ubah-jumlah-keranjang.php" method="post" class="quantity-form">
                        <input type="hidden" name="id_menu" value="<?php echo $item['id_menu']; ?>">
                        <button type="submit" name="aksi" value="kurang" class="quantity-btn minus">
                          <i class="ri-subtract-line"></i>
                        </button>
                        <input type="number" name="jumlah" value="<?php echo $item['jumlah']; ?>" min="1" class="quantity-input" readonly>
                        <button type="submit" name="aksi" value="tambah" class="quantity-btn plus">
                          <i class="ri-add-line"></i>
                        </button>
                      </form>                      
                    </div>
                  </div>

                  <!-- hapuss item keranjang  -->
                  <form action="../proses-pelanggan/proses-hapus-item-keranjang.php" method="post">
                    <input type="hidden" name="id_menu" value="<?php echo $item['id_menu']; ?>">
                    <button type="submit" class="cart__item-remove">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </form>                             

                </div>
                
              <?php 
                  }
                } else {
                  echo "<p>Keranjang masih kosong.</p>";
                }
              ?>
              </div>

              <!-- go to checkout -->
              <form action="../proses-pelanggan/proses-checkout.php" method="post">
              <!-- Delivery Info -->
                <div class="delivery__info">
                  <h3 class="delivery__title">Informasi Pengiriman</h3>
                  
                  <div class="delivery__form">
                    <div class="form__group">
                      <label>Nama Penerima</label>
                      <input type="text" class="form__input" name="nama_penerima" placeholder="Masukkan nama penerima">
                    </div>

                    <div class="form__group">
                      <label>Alamat Lengkap</label>
                      <textarea class="form__input" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                    </div>

                    <div class="form__group">
                      <label>Jarak Pengiriman (km)</label>
                      <div class="distance__input">
                        <button class="quantity-btn minus"><i class="ri-subtract-line"></i></button>
                        <input type="number" name="jarak" value="1" min="1" class="quantity-input" id="distance">
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
                      paypal
                    </label>
                  </div>
                </div>                        

              </form>  
              
            </div>    
            <!-- Right Side - Cart Summary -->          
            <div class="cart__summary">              
              <h3 class="summary__title">Ringkasan Belanja</h3>
                <div class="summary__details">
                  <?php $jumlah_menu = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0; 
                    $ongkir = 5000; // default ongkir, nanti bisa dinamis
                  ?>
                  <div class="summary__item">
                    <span>Total Harga (<?php echo $jumlah_menu; ?> Menu)</span>
                    <span>Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></span>
                   </div>
                   <div class="summary__item">                          <span>Biaya Pengiriman</span>
                        <span id="ongkir-display">Rp<?php echo number_format($ongkir, 0, ',', '.'); ?></span>
                    </div>
                  <div class="summary__total">
                    <span>Total Pembayaran</span>
                    <span id="total-bayar-display">Rp<?php echo number_format($total_harga + $ongkir, 0, ',', '.'); ?></span>
                  </div>
                </div>
          
                 <button type="submit" class="button checkout__button">
                    Checkout <i class="ri-arrow-right-line"></i>
                 </button>                 
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
      // Handle quantity buttons
      document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
          const input = this.parentElement.querySelector('.quantity-input');
          const currentValue = parseInt(input.value);
          
          if (this.classList.contains('minus')) {
            if (currentValue > 1) input.value = currentValue - 1;
          } else {
            input.value = currentValue + 1;
          }
          
          // Here you would typically update the total price
          updateTotalPrice();
        });
      });

      // Handle remove item buttons
      document.querySelectorAll('.cart__item-remove').forEach(button => {
        button.addEventListener('click', function() {
          this.closest('.cart__item').remove();
          // Here you would typically update the cart total
          updateTotalPrice();
        });
      });

      // Function to update total price (to be implemented)
      function updateTotalPrice() {
        // Implementation would go here
        console.log('Updating total price...');
      }
    </script>
  </body>
</html>