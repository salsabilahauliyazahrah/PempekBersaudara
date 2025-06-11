<?php
session_start();
session_destroy();
header("Location: ../views-pelanggan/login.php");
exit();
?>