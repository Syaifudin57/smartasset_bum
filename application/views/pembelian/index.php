<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Pengajuan Disetujui <small>(Untuk Input Pembelian)</small></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Berhasil!</h4> <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4> <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. Form</th>
                            <th>Tanggal</th>
                            <th>Nama Aset</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengajuan_disetujui)): // Menggunakan nama variabel $pengajuan_disetujui sesuai dengan yang disarankan dari controller 
                        ?>
                            <?php foreach ($pengajuan_disetujui as $p): ?>
                                <tr>
                                    <td><?= $p->nomor_form ?? '-' ?></td>
                                    <td><?= isset($p->tanggal_form) ? date('d-m-Y', strtotime($p->tanggal_form)) : '-' ?></td>
                                    <td><?= $p->nama_aset ?? '-' ?></td>
                                    <td><?= $p->quantity_aset ?? '-' ?></td>
                                    <td>Rp <?= isset($p->estimasi_harga) ? number_format($p->estimasi_harga, 0, ',', '.') : '-' ?></td>
                                    <td>
                                        <?php
                                        // Memastikan properti status_pembelian ada dan belum direalisasi
                                        // Gunakan $p->status_pembelian dari hasil JOIN di model
                                        if (($p->status_pembelian ?? 'belum_direalisasi') === 'belum_direalisasi'):
                                        ?>
                                            <a href="<?= base_url('pembelian/form/' . $p->id) ?>" class="btn btn-sm btn-primary">Input</a>
                                        <?php else: ?>
                                            <span class="label label-success">Sudah Diinput</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pengajuan yang disetujui HO dan belum diinput pembelian.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </section>
</div>