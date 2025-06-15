<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $nama_admin = $_SESSION['nama_admin'] ?? 'Admin';
    $foto_admin = $_SESSION['foto_admin'] ?? 'default.png';
?>

<nav class="top-navbar">
    <div class="left-section"></div>
    <div class="right-section">
        <div class="profile-foto">
            <img src="../foto-foto/admin/<?php echo $foto_admin; ?>" alt="profile" class="profile-pic">
            <span class="profile-name"><?php echo $nama_admin; ?></span>
        </div>
    </div>
</nav>