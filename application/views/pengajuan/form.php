<div class="content-wrapper">
    <section class="content-header">
        <h1><?= isset($pengajuan) ? 'Edit Pengajuan Aset' : 'Tambah Pengajuan Aset' ?></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <form action="<?= $action ?>" method="post">

                    <!-- Cabang -->
                    <div class="form-group">
                        <label for="id_cabang">Cabang</label>
                        <select name="id_cabang" class="form-control" required>
                            <option value="">-- Pilih Cabang --</option>
                            <?php foreach ($cabang as $cb): ?>
                                <option value="<?= $cb->id ?>"
                                    <?= isset($pengajuan) && $pengajuan->id_cabang == $cb->id ? 'selected' : '' ?>>
                                    <?= $cb->nama_cabang ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nomor Form -->
                    <div class="form-group">
                        <label for="nomor_form">Nomor Form</label>
                        <input type="text" name="nomor_form" class="form-control"
                            value="<?= isset($pengajuan) ? $pengajuan->nomor_form : $next_nomor_form ?>" readonly>
                    </div>

                    <!-- Tanggal Form -->
                    <div class="form-group">
                        <label for="tanggal_form">Tanggal</label>
                        <input type="date" name="tanggal_form" class="form-control"
                            value="<?= isset($pengajuan) ? $pengajuan->tanggal_form : date('Y-m-d') ?>" required>
                    </div>

                    <!-- Kode Aset -->
                    <div class="form-group">
                        <label for="kode_aset">Kode Aset</label>
                        <input type="text" name="kode_aset" class="form-control"
                            value="<?= isset($pengajuan) ? $pengajuan->kode_aset : '' ?>" required>
                    </div>

                    <!-- Nama Aset -->
                    <div class="form-group">
                        <label for="nama_aset">Nama Aset</label>
                        <input type="text" name="nama_aset" class="form-control"
                            value="<?= isset($pengajuan) ? $pengajuan->nama_aset : '' ?>" required>
                    </div>

                    <!-- Quantity -->
                    <div class="form-group">
                        <label for="quantity_aset">Quantity</label>
                        <input type="number" name="quantity_aset" class="form-control"
                            value="<?= isset($pengajuan) ? $pengajuan->quantity_aset : '' ?>" required>
                    </div>

                    <!-- Estimasi Harga -->
                    <div class="form-group">
                        <label for="estimasi_harga">Estimasi Harga</label>
                        <input type="number" step="0.01" name="estimasi_harga" class="form-control"
                            value="<?= isset($pengajuan) ? $pengajuan->estimasi_harga : '' ?>" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"><?= isset($pengajuan) ? $pengajuan->keterangan : '' ?></textarea>
                    </div>

                    <!-- Tombol Simpan -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('pengajuan') ?>" class="btn btn-default">Kembali</a>

                </form>
            </div>
        </div>
    </section>
</div>