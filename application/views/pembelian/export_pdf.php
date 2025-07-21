<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian Aset</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Pembelian Aset</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Form</th>
                <th>Nama Aset</th>
                <th>Vendor</th>
                <th>Tanggal Pembelian</th>
                <th>Nilai Realisasi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pembelian as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p->nomor_form ?></td>
                    <td><?= $p->nama_aset ?></td>
                    <td><?= $p->vendor ?></td>
                    <td><?= $p->tanggal_pembelian ?></td>
                    <td>Rp <?= number_format($p->nilai_realisasi, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>