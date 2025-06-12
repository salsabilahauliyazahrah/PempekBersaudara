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
                        <!-- Tambah Gambar Menu -->
                        <div class="card-section">
                            <h3>Upload Gambar Menu</h3>
                            <div class="upload-box" onclick="triggerFileInput()">
                                <input type="file" id="gambar" name="gambar" required hidden>

                                <div class="defaultText">
                                    <div class="icon-upload">
                                        <i class='bx bx-image-add'></i>
                                    </div>
                                    <p><strong>Drop Image Menu Here, or <span class="browse-text">click to browse</span></strong></p>
                                </div>

                                <div id="previewContainer" style="display: none; position: relative;">
                                    <img src="" alt="Preview Gambar" id="previewImage" style="max-width: 70%; border-radius: 10px;">
                                    <div class="overlay" onclick="triggerFileInput()">Ganti Gambar?</div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- BAGIAN INPUT DATA MENU -->
                         <div class="card-section">
                            <div class="form-grid">
                                <div class="left-section">
                                    <label for="nama">Nama Menu</label>
                                    <input type="text" id="nama" name="nama" required>

                                    <label for="harga">Harga</label>
                                    <input type="number" id="harga" name="harga" required>

                                    <label for="qty">QTY</label>
                                    <input type="number" id="qty" name="qty" required>
                                </div>

                                <div class="right-section">
                                    <label for="deskripsi">Deskripsi Menu</label>                                    
                                    <textarea name="deskripsi" id="deskripsi" required></textarea>

                                    <label for="deskripsi">Bahan-bahan</label>
                                    <textarea name="bahanBahan" id="bahanBahan" required></textarea>

                                    <label for="deskripsi">Detail</label>
                                    <textarea name="detail" id="detail" required></textarea>

                                </div>                            
                            </div> 

                            <!-- Tombol Submit -->
                            <div class="buttons">
                                <button type="submit" class="btn-submit">Submit</button>
                                <button type="reset" class="btn-reset">Reset</button>
                            </div>
                         </div>



                    </form>
                </div>

            </div>            
        </div>
    </div>

    <script src="../javascript/script-trigger-add.js"></script>
    <script src="../javascript/upload-priviewMenu.js"></script>
</body>
</html>