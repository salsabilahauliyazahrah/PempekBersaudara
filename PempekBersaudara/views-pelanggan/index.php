<?php
  session_start();
  if (!isset($_SESSION['user_name'])) {
      header("Location: ../views-pelanggan/login.php");
      exit();
  }

  include '../database/koneksi.php';

  $query = "SELECT * FROM menu"; 
  $result = mysqli_query($koneksi, $query);

  if (!$result) {
      die("Query error: " . mysqli_error($koneksi));
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS Bundle (Popper + Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--=============== FAVICON ===============-->
    <!-- TODO: Replace with actual pempek logo -->
    <link rel="shortcut icon" href="../foto-foto/Favicon.png" type="image/x-icon" />

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../style-pelanggan/styles-index.css" />



    <title>Pempek Bersaudara</title>
  </head>
  <body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
      <nav class="nav container">
        <a href="#" class="nav__logo">
          <img src="../foto-foto/Favicon.png" alt="logo">
          Pempek Bersaudara
        </a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item">
              <a href="#home" class="nav__link active-link">Beranda</a>
            </li>
            <li class="nav__item">
              <a href="#menu" class="nav__link">Menu</a>
            </li>
            <li class="nav__item">
              <a href="#testimoni" class="nav__link">Testimoni</a>
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
            <!-- Theme toggle aligned with menu -->
            <li class="nav__item">
              <i class="ri-moon-line change-theme" id="theme-button"></i>
            </li>
          </ul>

          <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
          </div>

          <img src="assets/img/leaf-branch-4.png" alt="leaf image" class="nav__img-1" />
          <img src="assets/img/leaf-branch-3.png" alt="leaf image" class="nav__img-2" />
        </div>

        <!-- Toggle button for mobile -->
        <div class="nav__toggle" id="nav-toggle">
          <i class="ri-apps-2-line"></i>
        </div>
      </nav>
    </header>

    <!--==================== MAIN ====================-->
    <main class="main">
      <!--==================== HOME ====================-->
      <section id="pempekCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="container carousel-container">
          <!-- Indicators -->
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#pempekCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#pempekCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#pempekCarousel" data-bs-slide-to="2"></button>
          </div>

          <!-- Carousel Content -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h2 class="carousel-title">Pempek Lenjer</h2>
                  <p class="carousel-description">Jenis pempek yang berbentuk bulat memanjang seperti lenjeran.</p>
                  <a href="menu.php" class="button">Pesan Sekarang <i class="ri-arrow-right-line"></i></a>
                </div>
                <div class="col-md-6 carousel-image">
                  <img src="../foto-foto/img/lenjer.png" alt="Pempek Lenjer">
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h2 class="carousel-title">Pempek Lenggang</h2>
                  <p class="carousel-description">Jenis pempek yang dibuat dengan cara memadukan 
                    potongan pempek dengan telur, lalu dipanggang atau digoreng.</p>
                  <a href="menu.php" class="button">Pesan Sekarang <i class="ri-arrow-right-line"></i></a>
                </div>
                <div class="col-md-6 carousel-image">
                  <img src="../foto-foto/img/lenggang.png" alt="Pempek Lenggang">
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h2 class="carousel-title">Rujak Mie</h2>
                  <p class="carousel-description">Merupakan campuran antara mie kuning, soun, tahu, timun, dan pempek, yang disiram dengan kuah cuko yang gurih dan pedas. </p>
                  <a href="menu.php" class="button">Pesan Sekarang <i class="ri-arrow-right-line"></i></a>
                </div>
                <div class="col-md-6 carousel-image">
                  <img src="../foto-foto/img/rujakmie.png" alt="Rujak Mie">
                </div>
              </div>
            </div>
          </div>

          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#pempekCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Sebelumnya</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#pempekCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Berikutnya</span>
          </button>
        </div>
      </section>

      <!--==================== ABOUT ====================-->
  
      <!--==================== MENU ====================-->
      <section class="popular section" id="menu">
        <span class="section__subtitle">Menu Spesial</span>
        <h2 class="section__title">Pempek Favorit</h2>

        <div class="popular__container container grid">
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <article class="popular__card">
                <img src="../foto-foto/foto-menu/<?= htmlspecialchars($row['gambar_menu']) ?>" alt="<?= htmlspecialchars($row['nama_menu']) ?>" class="popular__img" />
                <h3 class="popular__name"><?= htmlspecialchars($row['nama_menu']) ?></h3>
                <span class="popular__description">Pempek</span>
                <span class="popular__price">Rp<?= number_format($row['harga_menu'], 0, ',', '.') ?></span>
                <div class="popular__buttons">
                    <form action="../proses-pelanggan/proses-tambah-keranjang.php" method="POST">
                      <input type="hidden" name="id_menu" value="<?= $row['id_menu'] ?>">
                      <button type="submit" class="popular__button" title="Tambah ke Keranjang">
                        <i class="ri-shopping-bag-line"></i>
                      </button>
                    </form>
                    <a href="menu_detail.php?id=<?= $row['id_menu'] ?>" class="popular__detail">
                        Detail <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </article>
          <?php endwhile; ?>
            
        <div class="view-all-menu">
            <a href="menu.php" class="button">
                Lihat Semua Menu <i class="ri-arrow-right-line"></i>
            </a>
        </div>
      </section>

     <!--==================== TESTIMONI ====================-->

     <?php
        include('../database/koneksi.php');

        $query = "SELECT 
            testimoni.id_testimoni,
            testimoni.pesan,
            testimoni.rating,
            pelanggan.nama_pelanggan AS nama
            FROM testimoni 
            INNER JOIN pelanggan ON testimoni.id_pelanggan = pelanggan.id_pelanggan
            ORDER BY testimoni.id_testimoni DESC";

        $result = mysqli_query($koneksi, $query);
     ?>

     <section class="testi section" id="testimoni">
        <div class="container">
            <span class="section__subtitle">Testimonial</span>
            <h2 class="section__title">Apa yang mereka katakan</h2>
            
            <div class="testi__container container grid">
              <?php while($row = mysqli_fetch_assoc($result)): ?>

                <div class="testi__card">
                    <div class="card__body">
                        <p class="testi__name"><?= htmlspecialchars($row['nama']) ?></p>
                        <div class="testi__stars">
                            <?php
                                $rating = (int)$row['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="ri-star-fill"></i>';
                                    } else {
                                        echo '<i class="ri-star-line"></i>';
                                    }
                                }
                            ?>
                        </div>
                        <p class="testi__comment">
                            <i class="ri-double-quotes-l"></i>
                            <?= htmlspecialchars($row['pesan']) ?>
                            <i class="ri-double-quotes-r"></i>
                        </p>
                    </div>
                </div>              
                
              <?php endwhile; ?>
            </div>
            <div class="view-all-menu">
              <button class="button" data-bs-toggle="modal" data-bs-target="#testimoniModal">
                <i class="ri-message-3-line"></i> Kirim Masukan
              </button>
            </div>
        </div>
    </section>

    <!--==================== MODAL TESTIMONI ====================-->
    <div class="modal fade" id="testimoniModal" tabindex="-1" aria-labelledby="testimoniModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="testimoniModalLabel">Kirim Masukan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="testimoniForm" action="../proses-pelanggan/submit-testimoni.php" method="POST">            
              <div class="mb-3">
                <label for="masukan" class="form-label">Masukan</label>
                <textarea class="form-control" id="masukan" rows="3" name="masukan" required></textarea>
              </div>
              <div class="testi__rating mb-3">
                <label class="form-label">Rating</label>
                <div class="rating">
                  <i class="ri-star-line" data-rating="1" role="button"></i>
                  <i class="ri-star-line" data-rating="2" role="button"></i>
                  <i class="ri-star-line" data-rating="3" role="button"></i>
                  <i class="ri-star-line" data-rating="4" role="button"></i>
                  <i class="ri-star-line" data-rating="5" role="button"></i>
                </div>
                <input type="hidden" name="rating" id="ratingInput" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="button button--ghost" data-bs-dismiss="modal">Tutup</button>
            <button type="button" class="button button--ghost" id="submitTestimoni">Kirim</button>
          </div>
        </div>
      </div>
    </div>

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
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!--========== Testimoni Script ==========-->
    <script src="../javascript/submit-testimoni.js"></script>
    
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script> -->
  </body>
</html>
