<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <h1>Form Input Pembelian</h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Alert Success / Error -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="card card-orange card-outline">
            <div class="card-header bg-orange text-white">
                <h3 class="card-title">Input Realisasi Pembelian Aset</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('pembelian/simpan') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_pengajuan" value="<?= $pengajuan->id ?>">

                    <div class="form-group">
                        <label>No. Form</label>
                        <input type="text" class="form-control" value="<?= $pengajuan->nomor_form ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Nama Aset</label>
                        <input type="text" class="form-control" value="<?= $pengajuan->nama_aset ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>No. Pembelian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_pembelian" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pembelian <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_pembelian" required>
                    </div>

                    <div class="form-group">
                        <label>Vendor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="vendor" required>
                    </div>

                    <div class="form-group">
                        <label>Nilai Realisasi (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="nilai_realisasi" required min="0">
                    </div>

                    <div class="form-group">
                        <label>Upload Nota Pembelian (jpg/png/pdf)</label>
                        <input type="file" class="form-control" name="nota" accept=".jpg,.jpeg,.png,.pdf" onchange="previewFile(this, 'nota-preview')" required>
                        <div id="nota-preview" class="mt-2"></div>
                    </div>

                    <div class="form-group">
                        <label>Upload Foto Barang (jpg/png)</label>
                        <input type="file" class="form-control" name="foto_barang" accept=".jpg,.jpeg,.png" onchange="previewFile(this, 'barang-preview')" required>
                        <div id="barang-preview" class="mt-2"></div>
                    </div>


                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('pembelian') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Preview Script -->
<script>
    function previewFile(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileType = file.type;

            if (fileType.includes('image')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '300px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                const object = document.createElement('object');
                object.data = URL.createObjectURL(file);
                object.type = 'application/pdf';
                object.width = '100%';
                object.height = '400px';
                preview.appendChild(object);
            } else {
                preview.innerHTML = '<p class="text-danger">File tidak didukung untuk preview.</p>';
            }
        }
    }
</script>