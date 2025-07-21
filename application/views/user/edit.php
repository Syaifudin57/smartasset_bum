<?php
// application/views/user/edit.php
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit User</h1>
    </section>

    <section class="content">
        <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= $user->username ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="<?= $user->name ?>" required>
            </div>
            <div class="form-group">
                <label>Password (kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="kepala_cabang" <?= $user->role == 'kepala_cabang' ? 'selected' : '' ?>>Kepala Cabang</option>
                    <option value="area_manager" <?= $user->role == 'area_manager' ? 'selected' : '' ?>>Area Manager</option>
                    <option value="admin_pusat" <?= $user->role == 'admin_pusat' ? 'selected' : '' ?>>Admin Pusat</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="<?= base_url('user') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </section>
</div>