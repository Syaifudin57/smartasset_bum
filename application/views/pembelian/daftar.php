<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Daftar Pembelian Aset</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                                    <a href="<?= base_url('pembelian/export_excel') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
                                    <a href="<?= base_url('pembelian/export_pdf') ?>" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. Form</th>
                            <th>Nama Aset</th>
                            <th>Vendor</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Nota</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembelian as $p): ?>
                            <tr>
                                <td><?= $p->nomor_form ?></td>
                                <td><?= $p->nama_aset ?></td>
                                <td><?= $p->vendor ?></td>
                                <td><?= $p->tanggal_pembelian ?></td>
                                <td>Rp <?= number_format($p->nilai_realisasi, 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($p->bukti_nota): ?>
                                        <a href="<?= base_url('uploads/bukti_pembelian/' . $p->bukti_nota) ?>" target="_blank" class="btn btn-sm btn-info">Lihat Nota</a>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($p->foto_barang): ?>
                                        <a href="<?= base_url('uploads/bukti_pembelian/' . $p->foto_barang) ?>" target="_blank" class="btn btn-sm btn-secondary">Lihat Barang</a>
                                    <?php endif; ?>
                                </td>
                                

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>