<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-laporan.css">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    <title>Laporan</title>
</head>
<body>
    <!-- laporan.php -->
    <?php include('sidebar.php'); ?>
    <div class="laporan">
        <div class="laporan-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-file'></i>
                    <span class="text">Laporan</span>
                </div>

                <div class="activity">
                    <div class="summary-boxes">
                        <div class="box">
                            <H4>Total Pendapatan Bersih Hari ini</H4>
                            <h2>Rp <?= number_format($data_pendapatan['total_pendapatan'] ?? 0, 0, ',', '.'); ?></h2>
                        </div>

                        <div class="box">
                            <h4>Total pendapatan ongkir hari ini</h4>
                            <h2>Rp <?= number_format($data_ongkir['total_ongkir'] ?? 0, 0, ',', '.'); ?></h2>
                        </div>
                    </div>

                    <div class="summary-boxes">
                        <div class="report-forms">
                            <form action="laporan-cetak-perbulan.php" method="GET" target="_blank" class="report-box">
                                <h4>Laporan Transaksi<br><span>Perbulan</span></h4>
                                <select name="bulan" id="" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php 
                                        for ($i = 1; $i <= 12; $i++) {
                                            $bulanNama = date("F", mktime(0, 0, 0, $i, 10)); // Nama bulan
                                            echo "<option value='" . str_pad($i, 2, '0', STR_PAD_LEFT) . "'>$bulanNama</option>";
                                        }
                                    ?>
                                </select>

                                <select name="tahun" id="" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php 
                                        $tahunSekarang = date("Y");
                                        for ($t = $tahunSekarang; $t >= 2024; $t--) { //dimisalkan dibuat dithaun 2024
                                            echo "<option value='$t'>$t</option>";
                                        }
                                    ?>
                                </select>
                                <button type="submit" class="print-btn"><i class='bx bx-printer'></i> Print</button>
                            </form>

                            <form action="laporan-cetak-perhari.php" method="GET" target="_blank" class="report-box">
                                <h4>Laporan Transaksi<br><span>Harian</span></h4>
                                <input type="date" name="tanggal" required>
                                <button type="submit" class="print-btn"><i class='bx bx-printer'></i> Print</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>