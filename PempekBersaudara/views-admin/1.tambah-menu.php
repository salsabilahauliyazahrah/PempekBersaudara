<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-tambahMenu.css">    
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Tambah Menu</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="halaman-tambahMenu">
        <div class="tambah-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-plus'></i>
                    <span class="text">Tambah Menu</span>                
                </div>

                <div class="top">
                    <div class="kembali">
                        <a href="menu.php" class="btn-kembali">
                            <i class='bx bx-arrow-back'></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="kolom-input">
                    <form action="../proses/1.tambah-menu.php" method="post" enctype="multipart/form-data">
                        <div class="left-section">
                            <label for="nama">Nama Menu</label>
                            <input type="text" id="nama" name="nama" required>

                            <label for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" required>

                            <label for="qty">QTY</label>
                            <input type="number" id="qty" name="qty" required>

                            <div class="buttons">
                                <button type="submit" class="btn-submit">Submit</button>
                                <button type="reset" class="btn-reset">Reset</button>
                            </div>
                        </div>

                        <div class="right-section">
                            <label for="gambar">Gambar Menu</label>
                            <input type="file" id="gambar" name="gambar" required>

                            <label for="deskripsi">Deskripsi Menu</label>
                            <textarea name="deskripsi" id="deskripsi" required></textarea>
                        </div>                        
                    </form>
                </div>

            </div>            
        </div>
    </div>

    <script src="../javascript/script-trigger-add.js"></script>
</body>
</html>