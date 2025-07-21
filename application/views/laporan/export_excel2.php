<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_pengajuan_" . date('Ymd') . ".xls");
header("Cache-Control: max-age=0");
?>

<table border="1" cellpadding="5">
    <thead>
        <tr style="background-color: #f2f2f2;">
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
        <?php $no = 1; foreach ($pengajuan as $p): ?>
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
