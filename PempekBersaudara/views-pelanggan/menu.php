<?php
  session_start();
  // Check if user is logged in
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
    <link rel="stylesheet" href="../style-pelanggan/styles-index.css" />

    <title>Menu - Pempek Bersaudara</title>
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
              <a href="index.php#menu" class="nav__link active-link">Menu</a>
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
      <!--==================== ALL MENU ====================-->
      <section class="popular section" id="menu">
        <span class="section__subtitle">Menu Lengkap</span>
        <h2 class="section__title">Semua Jenis Pempek</h2>

        <div class="popular__container container grid">

        <?php
          include '../database/koneksi.php';

          $query = "SELECT * FROM menu";
          $result = mysqli_query($koneksi, $query);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id_menu'];
                $nama = $row['nama_menu'];
                $harga = $row['harga_menu'];
                $gambar = $row['gambar_menu'];
        ?>
            <article class="popular__card">
              <img src="../foto-foto/foto-menu/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo htmlspecialchars($nama); ?>" class="popular__img" />
              <h3 class="popular__name"><?php echo htmlspecialchars($nama); ?></h3>
              <span class="popular__price">Rp<?php echo number_format($harga, 0, ',', '.'); ?></span>
              <div class="popular__buttons">
                  <button class="popular__button">
                    <i class="ri-shopping-bag-line"></i>
                  </button>
                  <a href="menu_detail.php?id=<?php echo $id; ?>" class="popular__detail">
                      Detail <i class="ri-arrow-right-line"></i>
                  </a>
              </div>
            </article>
        <?php
            }
          } else {
            echo "<p class='text-center'>Belum ada menu tersedia.</p>";
          }
        ?>
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

    <!--=============== SCROLLREVEAL ===============-->
    <script src="../javascript/scrollreveal.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="../javascript/main.js"></script>
  </body>
</html>
