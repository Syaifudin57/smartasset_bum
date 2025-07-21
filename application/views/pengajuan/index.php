<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Pengajuan (Draft)</h3>
                <div class="pull-right">
                    <a href="<?= base_url('pengajuan/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Pengajuan</a>
                </div>
            </div>
            <div class="box-body">
                <form action="<?= base_url('pengajuan/index') ?>" method="get" class="form-inline">
                    <div class="form-group">
                        <label for="tanggal_mulai">Dari Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $this->input->get('tanggal_mulai') ?>">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_sampai">Sampai Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" value="<?= $this->input->get('tanggal_sampai') ?>">
                    </div>
                    <div class="form-group">
                        <label for="keyword">Cari:</label>
                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Cari aset..." value="<?= $this->input->get('keyword') ?>">
                    </div>
                    <button type="submit" class="btn btn-default">Filter</button>
                    <a href="<?= base_url('pengajuan') ?>" class="btn btn-default">Reset</a>
                </form>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>No. Form</th>
                            <th>Tanggal</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengajuan)) : ?>
                            <?php foreach ($pengajuan as $item) : ?>
                                <tr>
                                    <td><?= $item->cabang ?? '-' ?></td>
                                    <td><?= $item->nomor_form ?? '-' ?></td>
                                    <td><?= isset($item->tanggal_form) ? date('d-m-Y', strtotime($item->tanggal_form)) : '-' ?></td>
                                    <td><?= $item->kode_aset ?? '-' ?></td>
                                    <td><?= $item->nama_aset ?? '-' ?></td>
                                    <td><?= $item->quantity_aset ?? '-' ?></td>
                                    <td><?= isset($item->estimasi_harga) ? number_format($item->estimasi_harga, 0, ',', '.') : '-' ?></td>
                                    <td><?= $item->keterangan ?? '-' ?></td>
                                    <td><?= ucfirst($item->overall_status ?? 'Draft') ?></td>
                                    <td>
                                        <?php if (($item->overall_status ?? 'Draft') === 'Draft') : ?>
                                            <a href="<?= base_url('pengajuan/edit/' . $item->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="<?= base_url('pengajuan/submit/' . $item->id) ?>" class="btn btn-info btn-sm" onclick="return confirm('Apakah Anda yakin ingin submit pengajuan ini?');">Submit</a>
                                            <a href="<?= base_url('pengajuan/delete/' . $item->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">Hapus</a>
                                        <?php else : ?>
                                            <span><?= ucfirst($item->overall_status) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data pengajuan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>