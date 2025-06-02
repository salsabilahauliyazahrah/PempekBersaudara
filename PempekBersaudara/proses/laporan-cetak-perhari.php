<?php 
    require_once __DIR__ . '/../vendor/autoload.php';
    include('../database/koneksi.php');

    $tanggal = $_GET['tanggal'] ?? date('Y-m-d');

    //mengambil data transaksi pada tanggal tertentu
    $query = "SELECT * FROM pesanan WHERE DATE(tanggal_transaksi) = '$tanggal' AND status = 'selesai'";
    $result = mysqli_query($koneksi, $query);

    $html = '
        <h2 style="text-align: center;">Laporan Transaksi - ' . date('d/m/Y', strtotime($tanggal)) . '</h2>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
                <th>Ongkir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
    ';

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>
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
    $mpdf->Output("Laporan-$tanggal.pdf", 'I');
?>