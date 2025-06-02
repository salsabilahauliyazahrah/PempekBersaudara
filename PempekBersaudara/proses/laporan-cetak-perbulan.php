<?php 
    require_once '../vendor/autoload.php';
    include('../database/koneksi.php'); 

    $bulan = $_GET['bulan'] ?? date('m');
    $tahun = $_GET['tahun'] ?? date('Y');

    //mengambil data transaksi berdasarkan bulan dan tahun 
    $query = "SELECT * FROM pesanan
              WHERE MONTH(tanggal_transaksi) = '$bulan'
              AND status = 'selesai'";
    $result = mysqli_query($koneksi, $query);

    //Judul laporannnya
    $nama_bulan = date('F', mktime(0,0,0, $bulan, 10));

    //Membuat HTML laporan
    $html = '
        <h1 style="text-align: center;">Laporan Transaksi Bulanan - ' . $nama_bulan . ' ' . $tahun . '</h1>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Ongkir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    ';

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '
            <tr>
                <td>' . $row['id_transaksi'] . '</td>
                <td>' . $row['id_pelanggan'] . '</td>
                <td>Rp ' . number_format($row['total_harga'], 0, ',', '.') . '</td>
                <td>Rp ' . number_format($row['ongkir'], 0, ',', '.') . '</td>
                <td>' . ucfirst($row['status']) . '</td>
            </tr>';
    }

    $html .= '</tbody></table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output("Laporan-$nama_bulan-$tahun.pdf", 'I');
?>