<?php
    session_start();
    if (isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../style-admin/style-regis.css">
</head>
<body>
    <div class="regis-container">

        <form action="../proses/regis.php" method="POST" enctype="multipart/form-data">
            <h2>Halooo !</h2>

                <?php if (!empty($successMessage)) : ?>
                    <div class="success-message"><?= $successMessage ?></div>
                <?php endif; ?>

                <?php if (!empty($errorMessage)) : ?>
                    <div class="warning-message"><?= $errorMessage ?></div>
                <?php endif; ?>

            <div class="input-field">
                <span class="icon-human"></span>
                <input type="text" name="nama" required placeholder="Nama">
            </div>
            <div class="input-field">
                <span class="icon-telephone"></span>
                <input type="number" name="telepon" required placeholder="Telepon">
            </div>  
            <div class="input-field">
                <span class="icon-username"></span>
                <input type="text" name="username" required placeholder="Username">
            </div>
            <div class="input-field">
                <span class="icon-password"></span> 
                <input type="password" id="passwordField" name="password" required placeholder="Password"> 
            </div>
                <button type="submit" class="regis-button" href="login.php">Register</button>
            <div class="login-link">
                <p>have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>