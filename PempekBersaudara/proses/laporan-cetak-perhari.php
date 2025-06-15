<?php 
    session_start();
    require_once __DIR__ . '/../../vendor/autoload.php';
    include('../database/koneksi.php'); 

    $tanggal = $_GET['tanggal'] ?? date('Y-m-d'); // default hari ini

    $query = "SELECT p.*, a.nama_admin as nama_admin, pl.nama as nama_pelanggan
        FROM pesanan p
        LEFT JOIN admin a ON p.id_admin = a.id_admin
        LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
        WHERE DATE(p.tanggal_transaksi) = '$tanggal'
        AND p.status = 'selesai'";
    $result = mysqli_query($koneksi, $query);

    $nama_tanggal = date('d F Y', strtotime($tanggal));

    $html = '
        <h1 style="text-align: center;">Laporan Transaksi Harian - ' . $nama_tanggal . '</h1>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Admin</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Penerima</th>
                    <th>Daftar Pesanan</th>
                    <th>Alamat</th>
                    <th>Total Pesanan</th>
                    <th>Total Ongkir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    ';

    $total_semua = 0;
    $total_ongkir = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $id_transaksi = $row['id_transaksi'];

        $query_menu = "SELECT m.nama_menu, dp.jumlah 
                    FROM detail_pesanan dp
                    JOIN menu m ON dp.id_menu = m.id_menu
                    WHERE dp.id_transaksi = '$id_transaksi'";
        $menu_result = mysqli_query($koneksi, $query_menu);
        
        $daftar_menu = '';
        while ($menu = mysqli_fetch_assoc($menu_result)) {
            $daftar_menu .= $menu['nama_menu'] . ' (' . $menu['jumlah'] . '), ';
        }
        $daftar_menu = rtrim($daftar_menu, ', ');

        $total_semua += $row['total_harga'];
        $total_ongkir += $row['ongkir'];

        $html .= '
            <tr>
                <td>' . $row['id_transaksi'] . '</td>
                <td>' . date('d-m-Y', strtotime($row['tanggal_transaksi'])) . '</td>
                <td>' . $row['nama_admin'] . '</td>
                <td>' . $row['nama_pelanggan'] . '</td>
                <td>' . $row['nama_penerima'] . '</td>
                <td>' . $daftar_menu . '</td>
                <td>' . $row['alamat_penerima'] . '</td>
                <td>Rp ' . number_format($row['total_harga'], 0, ',', '.') . '</td>
                <td>Rp ' . number_format($row['ongkir'], 0, ',', '.') . '</td>
                <td>' . ucfirst($row['status']) . '</td>
            </tr>';
    }

    $html .= '</tbody></table>';

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
    ]);

    $mpdf->WriteHTML($html);
    $mpdf->Output("Laporan-$tanggal.pdf", 'I');
?>
