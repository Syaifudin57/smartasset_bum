<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - SmartAsset BUM</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- AdminLTE + Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte') ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte') ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte') ?>/plugins/iCheck/square/orange.css">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">

    <style>
        body {
            background-color: #f57c00;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        .register-box {
            width: 400px;
            margin: 7% auto;
        }

        .register-logo img {
            width: 90px;
        }

        .register-box-body {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }

        .btn-orange {
            background-color: #f57c00;
            color: white;
            border: none;
        }

        .btn-orange:hover {
            background-color: #e65100;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-box">
        <div class="register-logo">
            <img src="<?= base_url('assets/img/logo-bum.png') ?>" alt="Logo">
        </div>
        <div class="register-box-body">
            <h4 class="text-center mb-4"><b>Daftar Akun Baru</b></h4>
            <!-- Flashdata -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success py-1 px-2"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger py-1 px-2"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <form action="<?= base_url('auth/register') ?>" method="post">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email aktif" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="kacab">Kepala Cabang</option>
                        <option value="am">Area Manager</option>
                        <option value="ho">Admin Pusat</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-orange btn-block">Daftar</button>
            </form>

            <div class="login-link">
                <p>Sudah punya akun? <a href="<?= base_url('auth') ?>">Login di sini</a></p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('assets/adminlte') ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="<?= base_url('assets/adminlte') ?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/adminlte') ?>/plugins/iCheck/icheck.min.js"></script>

</body>

</html>