<?php

    include '../database/koneksi.php';
    include '../proses/grafik.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-laporan.css">
    <link rel="stylesheet" href="../style-admin/style-beranda.css">
    <link rel="stylesheet" href="chart/css/bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="chart/js/bootstrap.js"></script>
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

                    <div class="row">
                        <!-- Grafik Penjualan -->
                        <div class="col-6">                        
                            <div class="card-chart">
                            <h3 class="section-tittle">Grafik Penjualan</h3>
                                <div class="card-header"></div>
                                <div class="card-body">                              
                                    <div id="chart1"></div>                                
                                </div>
                            </div>
                        </div>                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>



<script>
    const menuNames = <?php echo json_encode($menu_names); ?>;
    const menuSales = <?php echo json_encode($menu_sales); ?>;
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var options = {
        series: [{
            name: 'Favorite',
            data: menuSales
        }],
        chart: {
            height: 350,
            type: 'bar',
            width: '100%',
        },
        
        colors: ['#00809D'], // <<< Warna batang bar chart
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top',
                },
            }
        },

        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + "x";
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: menuNames,
            position: 'bottom',
            axisBorder: { show: false },
            axisTicks: { show: false },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: { enabled: true }
        },
        yaxis: {
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + "%";
                }
            }
        },

        grid: {
            show: true,
            yaxis: {
                lines: {
                    show: false
                }
            }
        }

    };

    var chart = new ApexCharts(document.querySelector("#chart1"), options);
    chart.render();
});
</script>