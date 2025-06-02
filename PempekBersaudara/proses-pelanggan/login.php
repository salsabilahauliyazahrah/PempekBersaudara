<?php  
    session_start();
    include '../database/koneksi.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM pelanggan WHERE username = '$username'";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password'])) {
         $_SESSION['username'] = $user['username'];
         $_SESSION['nama'] = $user['nama_pelanggan'];

         header("Location: ../views-pelanggan/home.php");
         exit();
      }
   }

   header("Location: ../views-pelanggan/login.php?error=invalid");
   exit();
?>