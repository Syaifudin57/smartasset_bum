<?php
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Tambah User</h1>
    </section>

    <section class="content">
        <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="kepala_cabang">Kepala Cabang</option>
                    <option value="area_manager">Area Manager</option>
                    <option value="admin_pusat">Admin Pusat</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('user') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </section>
</div>