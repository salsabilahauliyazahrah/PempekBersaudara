<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
    include '../proses/testimoni.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style-admin/style-beranda.css">
    <link rel="stylesheet" href="../style-admin/style-testimoni.css">
    <link rel="stylesheet" href="chart/css/bootstrap.css">
    <script src="chart/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css'>
    
    <!--=============== FAVICON ===============-->
    <!-- TODO: Replace with actual pempek logo -->
    <link rel="shortcut icon" href="../foto-foto/logo.png" type="image/x-icon" />

    <title>Beranda</title>

</head>
<body>
    <!-- beranda.php -->
    <?php include('sidebar.php'); ?>

    <div class="dashboard">
        <div class="dash-content">
            <div class="overview">
                <div class="tittle">
                    <i class='bx bx-home-alt icon'></i>
                    <span class="text">Beranda</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class='bx bx-group'></i>
                        <div class="box-content">
                          <span class="text">Pelanggan</span>
                          <span class="number">
                            <?php 
                              include '../database/koneksi.php';
                              $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelanggan");
                              $data = mysqli_fetch_assoc($query);
                              echo $data['total'] ?? 0; //menampilkan 0 jika null
                            ?>
                          </span>
                        </div>                        
                    </div>
                    <div class="box box2">
                        <i class='bx bx-group'></i>
                        <div class="box-content">
                          <span class="text">Admin</span>
                          <span class="number">
                              <?php 
                                  include '../database/koneksi.php';
                                  $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM admin");
                                  $data = mysqli_fetch_assoc($query);
                                  echo $data['total'] ?? 0; //menampilkan 0 jika null
                              ?>
                          </span>
                        </div>
                    </div>
                    <div class="box box3">
                        <i class='bx bx-group'></i>
                        <div class="box-content">
                          <span class="text">Total Pesanan</span>
                          <span class="number">
                              <?php 
                                  include '../database/koneksi.php';
                                  $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pesanan");
                                  $data = mysqli_fetch_assoc($query);
                                  echo $data['total'] ?? 0; //menampilkan 0 jika null
                              ?>
                          </span>
                        </div>
                    </div>
                    <div class="box box4">
                        <i class='bx bx-group'></i>
                        <div class="box-content">
                          <span class="text">Pesanan Diproses</span>
                          <span class="number">
                              <?php 
                                  include '../database/koneksi.php';
                                  $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pesanan");
                                  $data = mysqli_fetch_assoc($query);
                                  echo $data['total'] ?? 0; //menampilkan 0 jika null
                              ?>
                          </span>
                        </div>
                    </div>
                    
                  <!-- Content grafik dan testimoni -->
                  <div class="row" >
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

                      <!-- Tabel Testimoni -->
                      <div class="col-6">                        
                          <div class="card-testimoni">
                            <h3 class="section-tittle">Testimoniy</h3>
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="activity">
                                  <table class="testimoni-table">
                                      <thead>
                                          <tr>
                                              <th>Rating</th>
                                              <th>Tanggal</th>
                                              <th>Nama</th>
                                              <th>Email</th>
                                              <th>Pesan</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php if (mysqli_num_rows($result) > 0): ?>
                                              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                                  <tr>
                                                      <td class="center"><?= $row['rating']; ?></td>
                                                      <td class="center"><?= $row['tanggal_testimoni'] ?? '-' ?></td> 
                                                      <td class="center"><?= htmlspecialchars($row['nama']); ?></td>
                                                      <td class="center"><?= htmlspecialchars($row['email']); ?></td>
                                                      <td class="center"><?= htmlspecialchars($row['pesan']); ?></td>
                                                  </tr>
                                              <?php endwhile; ?>
                                          <?php else: ?>
                                              <tr><td colspan="5" class="center">Tidak ada testimoni ditemukan.</td></tr>
                                          <?php endif; ?>
                                      </tbody>
                                  </table>
                                </div>
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
document.addEventListener("DOMContentLoaded", function () {
    var options = {
        series: [{
            name: 'Favorite',
            data: [10, 20, 30, 50, 100]
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
            categories: ["Lenjer", "Kulit", "Kapal Selam", "Addan", "Pistel"],
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