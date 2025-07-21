<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengajuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            text-align: center;
            margin-bottom: 0;
        }
    </style>
</head>

<body>

    <h3>Laporan Pengajuan Aset</h3>
    <p style="text-align:center;">Periode: <?= date('d-m-Y', strtotime($mulai)) ?> s.d <?= date('d-m-Y', strtotime($sampai)) ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Form</th>
                <th>Nama Aset</th>
                <th>Status Kacab</th>
                <th>Status AM</th>
                <th>Status HO</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pengajuan as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p->nomor_form ?></td>
                    <td><?= $p->nama_aset ?></td>
                    <td><?= ucfirst($p->approval_kacab) ?></td>
                    <td><?= ucfirst($p->approval_am) ?></td>
                    <td><?= ucfirst($p->approval_ho) ?></td>
                    <td><?= date('d-m-Y', strtotime($p->tanggal_form)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>