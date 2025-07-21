<!-- application/views/account/index.php -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Profil Saya</h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('account/update') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="<?= isset($user->name) ? $user->name : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= isset($user->username) ? $user->username : '' ?>" readonly>
            </div>

            <div class="form-group">
                <label>Role</label>
                <input type="text" class="form-control" value="<?= isset($user->role) ? ucfirst($user->role) : '' ?>" readonly>
            </div>


            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= isset($user->email) ? $user->email : '' ?>" required>
            </div>

            <div class="form-group">
                <label>Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Foto Profil</label><br>
                <?php if (isset($user->photo) && $user->photo): ?>
                    <img src="<?= base_url('assets/uploads/profile/' . $user->photo) ?>" width="100" class="img-thumbnail"><br><br>
                <?php endif; ?>
                <input type="file" name="photo" accept=".jpg,.jpeg,.png">
                <p class="help-block">Maks. 2MB. Format: JPG, PNG.</p>
            </div>

            <button type="submit" class="btn btn-primary">Update Profil</button>
        </form>
    </section>
</div>