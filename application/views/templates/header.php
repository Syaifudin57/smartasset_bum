<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?> | SmartAsset BUM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/adminlte.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">

    <!-- Custom branding (orange) -->
    <style>
        .main-header,
        .brand-link {
            background-color: #f57c00 !important;
        }

        .navbar-nav .user-panel {
            display: flex;
            align-items: center;
        }

        .navbar-nav .user-panel img {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 8px;
        }

        .navbar-nav .user-name {
            font-size: 14px;
            font-weight: bold;
            color: #444;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

            <ul class="navbar-nav ml-auto align-items-center">

                <!-- Notifikasi Verifikasi -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <?php if (!empty($notifikasi_verifikasi) && $notifikasi_verifikasi > 0): ?>
                            <span class="badge badge-warning navbar-badge"><?= $notifikasi_verifikasi; ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">
                            <?= $notifikasi_verifikasi > 0 ? $notifikasi_verifikasi . ' Pengajuan Perlu Diverifikasi' : 'Tidak ada pengajuan baru' ?>
                        </span>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('pengajuan/daftar'); ?>" class="dropdown-item">
                            <i class="fas fa-file-signature mr-2"></i> Lihat Pengajuan
                        </a>
                    </div>
                </li>


                <!-- Foto Profil & Nama -->
                <li class="nav-item d-flex align-items-center mr-3">
                    <?php
                    $foto = $this->session->userdata('foto');
                    $nama = $this->session->userdata('nama');
                    $foto_url = base_url('assets/uploads/profile/' . ($foto ? $foto : 'default.png')) . '?t=' . time();
                    ?>
                    <div class="user-panel d-flex align-items-center">
                        <img src="<?= $foto_url ?>" alt="User Image">
                        <span class="user-name"><?= $nama ? $nama : 'Pengguna' ?></span>
                    </div>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
                </li>

            </ul>
        </nav>