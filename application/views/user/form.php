<div class="content-wrapper">
    <section class="content-header">
        <h1 style="font-size: 20px;"><?= $title ?></h1>
    </section>

    <section class="content">
        <div class="box box-solid" style="font-size: 13px;">
            <div class="box-body">
                <form method="post" action="<?= $action ?>">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= set_value('username', $user->username ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="<?= isset($user->name) ? $user->name : '' ?>" required>
                    </div>


                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" <?= (isset($user) && $user->role === 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="kepala_cabang" <?= (isset($user) && $user->role === 'kepala_cabang') ? 'selected' : '' ?>>Kepala Cabang</option>
                            <option value="area_manager" <?= (isset($user) && $user->role === 'area_manager') ? 'selected' : '' ?>>Area Manager</option>
                            <option value="admin_pusat" <?= (isset($user) && $user->role === 'admin_pusat') ? 'selected' : '' ?>>Admin Pusat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password <?= isset($user) ? '<small>(Biarkan kosong jika tidak ingin diganti)</small>' : '' ?></label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?= base_url('user') ?>" class="btn btn-default btn-sm">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
