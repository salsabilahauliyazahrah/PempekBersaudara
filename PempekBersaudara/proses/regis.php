<?php 
    session_start();
    include '../database/koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama     = $koneksi->real_escape_string($_POST["nama"]);
        $telepon  = $koneksi->real_escape_string($_POST["telepon"]);
        $username = $koneksi->real_escape_string($_POST["username"]);
        $passwordInput = $_POST["password"];

        // 🔒 VALIDASI PASSWORD
        if (strlen($passwordInput) > 8) {
            $_SESSION['errorMessage'] = "Password maksimal 8 karakter.";
            header("Location: ../views-admin/tambah-admin.php");
            exit();
        }

        if (!preg_match('/[\W_]/', $passwordInput)) {
            $_SESSION['errorMessage'] = "Password harus mengandung minimal satu simbol atau karakter khusus.";
            header("Location: ../views-admin/tambah-admin.php");
            exit();
        }

        // 🔍 CEK DUPLIKAT USERNAME
        $cekUsername = $koneksi->prepare("SELECT id_admin FROM admin WHERE username = ?");
        $cekUsername->bind_param("s", $username);
        $cekUsername->execute();
        $cekUsername->store_result();

        if ($cekUsername->num_rows > 0) {
            $_SESSION['errorMessage'] = "Username sudah digunakan. Silakan pilih username lain.";
            $cekUsername->close();
            header("Location: ../views-admin/tambah-admin.php");
            exit();
        }
        $cekUsername->close();

        // ✅ HASH DAN SIMPAN
        $passwordHashed = password_hash($passwordInput, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin (nama_admin, no_telepon, username, password) VALUES (?, ?, ?, ?)";
        $stmt  = $koneksi->prepare($query);
        $stmt->bind_param("ssss", $nama, $telepon, $username, $passwordHashed);

        if ($stmt->execute()) {
            $_SESSION['successMessage'] = "Registrasi berhasil!";
        } else {
            $_SESSION['errorMessage'] = "Terjadi kesalahan: " . $stmt->error;
        }

        $stmt->close();
        header("Location: ../views-admin/admin.php");
        exit();
    }
?>
