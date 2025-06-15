<?php
   session_start();
   include '../database/koneksi.php';

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $koneksi->real_escape_string($_POST['username']);
      $password = $_POST['password'];

      // Gunakan prepared statement agar lebih aman
      $stmt = $koneksi->prepare("SELECT * FROM admin WHERE username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         $user = $result->fetch_assoc();

         // Verifikasi password
         if (password_verify($password, $user['password'])) {
               $_SESSION['id_admin']    = $user['id_admin'];
               $_SESSION['username']    = $user['username'];
               $_SESSION['nama_admin']  = $user['nama_admin'];
               $_SESSION['foto_admin']  = $user['foto_admin'] ?? 'default.png';

               header("Location: ../views-admin/beranda.php");
               exit();
         }
      }

      // Jika gagal login
      header("Location: ../views-admin/login.php?error=invalid");
      exit();
   }
?>
