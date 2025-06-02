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
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../style-admin/style-login.css">
</head>
<body>
    <div class="login-container">
        <form action="../proses/login.php" method="POST" class="login-box">
            <h2>Halooo !</h2>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                    <div class="warning-message">
                        ⚠️ Username atau password salah!
                    </div>
                <?php endif; ?>

            <div class="input-group">
                <span class="icon-username"></span>
                <input type="text" name="username" required placeholder="Username">
            </div>
            <div class="input-group">
                <span class="icon-password"></span> 
                <input type="password" id="passwordField" name="password" required placeholder="Password"> 
            </div>
            <button type="submit" class="login-button">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

</body>
</html>

