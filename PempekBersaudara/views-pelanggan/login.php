<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Masuk dan Daftar</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dyD8a5vDv4AnlVwq4PeK4R2zBzU0UKoAr9pNHP+Mj+q+mBaF7kUM4ocPVZxOy4cnULBztA/kNflSyoEy+xUpfQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="../style-pelanggan/style-login.css">
</head>
<body>
	<!--==================== Register ====================-->
	<div class="container" id="container">		
		<div class="form-container sign-up-container">			
            <form action="../proses-pelanggan/process_register.php" method="POST" id="signupForm">
				<h1>Buat Akun</h1>
                <?php if(isset($_SESSION['register_error'])): ?>
                    <div class="error-message"><?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?></div>
                <?php endif; ?>
                <?php if(isset($_SESSION['register_success'])): ?>
                    <div class="success-message"><?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?></div>
                <?php endif; ?>
				<input type="text" name="nama_pelanggan" placeholder="Username" required minlength="3" maxlength="50" />
                <input type="text" name="no_telepon" placeholder="Nomor Telpon" required pattern="[0-9]{10,15}" title="Nomor telepon harus 10-15 digit" />
				<input type="email" name="email" placeholder="Email" required />
				<input type="password" name="password" id="signupPassword" placeholder="Password" required minlength="8" 
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                    title="Minimal 8 karakter, harus mengandung huruf besar, huruf kecil, dan angka" />
                <div class="show-password">
                    <input type="checkbox" id="showSignupPassword">
                    <label for="showSignupPassword">Tampilkan Password</label>
                </div>
				<button type="submit" name="register" style="background-color: black; color: white;">Daftar</button>
			</form>
		</div>		
	
	<!--==================== LOGIN ====================-->
		<div class="form-container sign-in-container">			
            <form action="../proses-pelanggan/process_login.php" method="POST" id="loginForm">
				<h1>Masuk</h1>
                <?php if(isset($_SESSION['login_error'])): ?>
                    <div class="error-message"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
                <?php endif; ?>
				<input type="text" name="username" placeholder="Email" required />
				<input type="password" name="password" id="loginPassword" placeholder="Password" required />
                <div class="show-password">
                    <input type="checkbox" id="showLoginPassword">
                    <label for="showLoginPassword">Tampilkan Password</label>
                </div>
				<button type="submit" style="background-color: black; color: white;">Masuk</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Halo Pengguna Baru!</h1>
					<p>Silahkan isi data diri untuk membuat akun baru, jika sudah punya langsung masuk aja yaa!</p>
					<button class="ghost" id="signIn" >Masuk</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Selamat Datang!</h1>
					<p>Silahkan login menggunakan akun yang terdaftar, jika belum memiliki daftar dulu yaa!</p>
					<button class="ghost" id="signUp">Daftar</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		const signUpButton = document.getElementById('signUp');
		const signInButton = document.getElementById('signIn');
		const container = document.getElementById('container');

		signUpButton.addEventListener('click', () => {
			container.classList.add("right-panel-active");
		});

		signInButton.addEventListener('click', () => {
			container.classList.remove("right-panel-active");
		});

        // Show/Hide Password functionality for Login
        document.getElementById('showLoginPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('loginPassword');
            passwordInput.type = this.checked ? 'text' : 'password';
        });

        // Show/Hide Password functionality for Signup
        document.getElementById('showSignupPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('signupPassword');
            passwordInput.type = this.checked ? 'text' : 'password';
        });
	</script>
</body>
</html>
