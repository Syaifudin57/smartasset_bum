<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login | Smartasset BUM Magelang</title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/AdminLTE.min.css') ?>">
    <style>
        html,
        body {
            /* Pastikan html dan body mengambil tinggi penuh */
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', sans-serif;
            /* Agar font konsisten */
            background-color: #f7941d;
            /* Warna oranye latar belakang */
        }

        body {
            display: flex;
            /* Menggunakan flexbox untuk pemusatan */
            justify-content: center;
            /* Memusatkan secara horizontal */
            align-items: center;
            /* Memusatkan secara vertikal */
            /* min-height: 100vh; /* Hapus atau ganti dengan height: 100% dari html/body */
            /* margin: 0; padding: 0; /* Pastikan tidak ada margin/padding dari Bootstrap yang mengganggu */
        }

        .login-box {
            width: 360px;
            /* Lebar standar AdminLTE login box */
            /* margin: 0 auto; /* Hapus margin auto jika menggunakan flexbox */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Memberi sedikit kedalaman */
            border-radius: 8px;
            /* Sudut membulat */
            overflow: hidden;
            /* Memastikan konten tidak keluar dari border-radius */
            /* Pastikan tidak ada float atau absolute positioning yang mengganggu flexbox */
        }

        .login-logo {
            background-color: transparent;
            /* Latar belakang transparan */
            padding: 20px 0 0;
            /* Padding atas untuk logo */
            text-align: center;
            /* Pusatkan konten */
            margin-bottom: 20px;
            /* Jarak antara logo dan kotak login */
        }

        .login-logo img {
            width: 100px;
            /* Ukuran logo */
            height: auto;
            display: block;
            margin: 0 auto;
            /* Memusatkan gambar logo */
        }

        .login-logo b {
            color: #212121;
            /* Warna teks lebih gelap seperti contoh */
            font-size: 24px;
            display: block;
            margin-top: 15px;
            /* Jarak teks dari logo */
        }

        .login-box-body {
            background: #ffffff;
            /* Latar belakang putih untuk kotak form */
            border-radius: 0 0 8px 8px;
            /* Hanya sudut bawah yang membulat */
            padding: 30px;
            /* Padding di dalam kotak form */
            border: none;
            /* Hapus border */
        }

        .form-group {
            margin-bottom: 20px;
            /* Jarak antar input field */
            position: relative;
            /* Untuk posisi bintang */
        }

        .form-control {
            border: 1px solid #ddd;
            /* Warna border input */
            border-radius: 4px;
            /* Sudut membulat input */
            padding-right: 30px;
            /* Ruang untuk bintang */
        }

        .form-control:focus {
            border-color: #f7941d;
            /* Warna border saat fokus */
            box-shadow: none;
            /* Hapus shadow default bootstrap */
        }

        .form-group.has-feedback:after {
            /* Styling untuk bintang */
            content: '*';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #f7941d;
            /* Warna oranye untuk bintang */
            font-size: 1.2em;
        }

        .btn-warning {
            background-color: #f7941d;
            /* Warna oranye untuk tombol login */
            border-color: #f7941d;
            color: #fff;
            font-weight: bold;
            padding: 10px 0;
            width: 100%;
            border-radius: 4px;
        }

        .btn-warning:hover,
        .btn-warning:active,
        .btn-warning.focus {
            background-color: #e07b00;
            /* Warna oranye sedikit lebih gelap saat hover */
            border-color: #e07b00;
            color: #fff;
        }

        .login-actions {
            margin-top: 15px;
            /* Jarak dari input ke tombol/link */
        }

        .login-actions .col-xs-12:first-child {
            margin-bottom: 15px;
            /* Jarak antara tombol login dan link */
        }

        .login-actions .col-xs-12 {
            text-align: right;
            /* Pusatkan konten ke kanan */
        }

        .forgot-register-links a {
            color: #007bff;
            /* Warna biru untuk link */
            text-decoration: none;
            font-size: 14px;
            margin-left: 15px;
            /* Jarak antar link */
        }

        .forgot-register-links a:first-child {
            margin-left: 0;
        }

        .forgot-register-links a:hover {
            text-decoration: underline;
        }

        /* Sembunyikan elemen AdminLTE default yang tidak dipakai */
        .login-box-msg,
        .form-control-feedback {
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= base_url('assets/img/logo-bum.png') ?>" alt="Logo BUM Depo">
            <b>Sistem Informasi Inventaris</b>
        </div>
        <div class="login-box-body">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="row login-actions">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-warning"><b>Login</b></button>
                    </div>
                    <div class="col-xs-12 forgot-register-links">
                        <a href="<?= base_url('auth/forgot_password') ?>">Forgot Password?</a> |
                        <a href="<?= base_url('auth/register') ?>">Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/AdminLTE/dist/js/adminlte.min.js') ?>"></script>
</body>

</html>