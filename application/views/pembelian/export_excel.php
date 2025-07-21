<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>No. Form</th>
            <th>Nama Aset</th>
            <th>Vendor</th>
            <th>Tanggal</th>
            <th>Nilai</th>
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
                <td><?= $p->nilai_realisasi ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>