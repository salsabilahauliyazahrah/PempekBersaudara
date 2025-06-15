<?php 
    include '../database/koneksi.php';

    $id = $_POST['id_admin'];
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $telepon = $koneksi->real_escape_string($_POST['telepon']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $updateFoto = '';
    $fotoBaru = null;

    // 💾 Upload foto jika ada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $fotoName = $_FILES['foto']['name'];
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($fotoName, PATHINFO_EXTENSION);
        $ext = strtolower($ext);

        $allowed = ['jpg', 'jpeg', 'png'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        // Validasi ekstensi dan ukuran
        if (!in_array($ext, $allowed)) {
            die("Format foto tidak didukung. Hanya jpg/jpeg/png.");
        }

        if ($_FILES['foto']['size'] > $maxSize) {
            die("Ukuran foto terlalu besar. Maksimal 2MB.");
        }

        // 🔁 Hapus foto lama
        $fotoLamaQuery = "SELECT foto_admin FROM admin WHERE id_admin = $id";
        $fotoLamaResult = $koneksi->query($fotoLamaQuery);
        $fotoLama = ($fotoLamaResult->num_rows > 0) ? $fotoLamaResult->fetch_assoc()['foto_admin'] : null;

        if ($fotoLama && file_exists("../foto-foto/admin/" . $fotoLama)) {
            unlink("../foto-foto/admin/" . $fotoLama);
        }

        // Simpan foto baru
        $fotoBaru = uniqid('admin_') . '.' . $ext;
        $tujuan = '../foto-foto/admin/' . $fotoBaru;

        if (move_uploaded_file($fotoTmp, $tujuan)) {
            $updateFoto = ", foto_admin = '$fotoBaru'";
        }
    }

    // 🔐 Password optional
    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin 
                SET nama_admin='$nama', no_telepon='$telepon', username='$username', password='$hashed' $updateFoto 
                WHERE id_admin = $id";
    } else {
        $query = "UPDATE admin 
                SET nama_admin='$nama', no_telepon='$telepon', username='$username' $updateFoto 
                WHERE id_admin = $id";
    }

    if ($koneksi->query($query) === TRUE) {
        header("Location: ../views-admin/admin.php?status=edit-sukses");
    } else {
        echo "Gagal update: " . $koneksi->error;
    }
?>
