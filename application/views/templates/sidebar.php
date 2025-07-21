<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #f57c00;">
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard'); ?>" class="brand-link text-center" style="background-color: #ef6c00; color: #fff;">
        <span class="brand-text font-weight-bold">SMARTASSET - BUM</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= base_url('dashboard'); ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>

                <!-- Pengajuan Aset (Hanya untuk Admin dan Super Admin) -->
                <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'super_admin'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('pengajuan'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-file-upload"></i>
                            <p>Pengajuan Aset</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Daftar Pengajuan (Semua Role bisa lihat) -->
                <li class="nav-item">
                    <a href="<?= base_url('pengajuan/daftar'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Daftar Pengajuan</p>
                    </a>
                </li>

                <!-- Pembelian (Semua Role Bisa Melihat) -->
                <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'pembelian' ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $this->uri->segment(1) == 'pembelian' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Pembelian
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('pembelian'); ?>" class="nav-link <?= $this->uri->segment(2) == '' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('pembelian/daftar'); ?>" class="nav-link <?= $this->uri->segment(2) == 'daftar' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Pembelian</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Laporan (Semua Role Bisa Melihat) -->
                <li class="nav-item">
                    <a href="<?= base_url('lapor'); ?>" class="nav-link <?= $this->uri->segment(1) == 'lapor' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan</p>
                    </a>
                </li>

                <!-- Pengaturan Akun -->
                <li class="nav-item">
                    <a href="<?= base_url('account') ?>" class="nav-link <?= ($this->uri->segment(1) == 'account') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Pengaturan Akun</p>
                    </a>
                </li>

                <!-- Manajemen User (khusus super admin) -->
                <?php if ($this->session->userdata('role') == 'super_admin'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('user'); ?>" class="nav-link <?= $this->uri->segment(1) == 'user' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                <?php endif; ?>


                <!-- Logout -->
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout'); ?>" class="nav-link bg-danger text-white">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>