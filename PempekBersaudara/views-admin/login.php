<?php
    session_start();
    if (isset($_SESSION['username'])) {
        header("Location: beranda.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coba Login</title>
    <link rel="stylesheet" href="../style-admin/style-coba-login.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons" rel="stylesheet" />
</head>
<body>
    <div class="container" id="container">

        <div class="form-container login-container">
            <form action="../proses/login.php" method="POST">
                <h1 class="admin-tittle">Admin</h1>
                <input type="text" name="username" placeholder="username" required>
                <input type="password" name="password" placeholder="password" required>
                <div class="content">
                    <button>Login</button>
                </div>
            </form>
        </div>    

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="tittle">Hallow!</h1>
                    <p>Start your day with enthusiasm <br>login and enjoy your work!</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../javascript/script-login.js"></script>

</body>
</html>