<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Form</th>
            <th>Tanggal</th>
            <th>Nama Aset</th>
            <th>Jumlah</th>
            <th>Harga Estimasi</th>
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
                <td><?= $p->estimasi_harga ?></td>
                <td><?= $p->keterangan ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>