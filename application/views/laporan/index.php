<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
    </section>

    <section class="content">
        <form method="get" class="form-inline mb-3">
            <input type="date" name="mulai" value="<?= $mulai ?>" class="form-control mr-2" required>
            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control mr-2" required>
            <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-filter"></i> Filter</button>

            <!-- Tombol Export -->
            <a href="<?= base_url('lapor/export_excel?mulai=' . $mulai . '&sampai=' . $sampai) ?>" class="btn btn-success mr-2">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </a>
            <a href="<?= base_url('lapor/export_pdf?mulai=' . $mulai . '&sampai=' . $sampai) ?>" target="_blank" class="btn btn-danger">
                <i class="fa fa-file-pdf-o"></i> Export PDF
            </a>
        </form>

        <table class="table table-bordered table-striped table-sm" style="font-size: 13px;">
            <thead class="text-center">
                <tr>
                    <th>Nomor Form</th>
                    <th>Nama Aset</th>
                    <th>Status Kacab</th>
                    <th>Status AM</th>
                    <th>Status HO</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pengajuan)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pengajuan as $p): ?>
                        <tr>
                            <td><?= $p->nomor_form ?></td>
                            <td><?= $p->nama_aset ?></td>
                            <td class="text-center">
                                <span class="badge badge-<?= $p->approval_kacab == 'approved' ? 'success' : ($p->approval_kacab == 'rejected' ? 'danger' : 'secondary') ?>">
                                    <?= ucfirst($p->approval_kacab) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-<?= $p->approval_am == 'approved' ? 'success' : ($p->approval_am == 'rejected' ? 'danger' : 'secondary') ?>">
                                    <?= ucfirst($p->approval_am) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-<?= $p->approval_ho == 'approved' ? 'success' : ($p->approval_ho == 'rejected' ? 'danger' : 'secondary') ?>">
                                    <?= ucfirst($p->approval_ho) ?>
                                </span>
                            </td>
                            <td class="text-center"><?= date('d-m-Y', strtotime($p->tanggal_form)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>