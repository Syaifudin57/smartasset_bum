<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pengajuan Aset</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Pengajuan Aset</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Form</th>
                <th>Tanggal</th>
                <th>Nama Aset</th>
                <th>Jumlah</th>
                <th>Estimasi Harga</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pengajuan as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p->nomor_form ?></td>
                    <td><?= $p->tanggal_form ?></td>
                    <td><?= $p->nama_aset ?></td>
                    <td><?= $p->quantity_aset ?></td>
                    <td><?= number_format($p->estimasi_harga, 0, ',', '.') ?></td>
                    <td><?= $p->keterangan ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>