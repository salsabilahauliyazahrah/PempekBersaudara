<?php
    session_start();           
    session_unset();           
    session_destroy();          

    header("Location: ../views-admin/login.php"); // Arahkan ke halaman login
    exit();
?>