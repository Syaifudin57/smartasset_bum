<!-- application/views/auth/forgot_password.php -->
<div class="container mt-5">
    <div class="card col-md-6 offset-md-3">
        <div class="card-header bg-warning text-white">Lupa Password</div>
        <div class="card-body">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>Masukkan Email Anda</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
            </form>
        </div>
    </div>
</div>