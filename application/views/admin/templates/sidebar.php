<aside class="main-sidebar">
    <section class="sidebar">
        <!-- <div class="user-panel">
           <div class="pull-left image">
               <img src="<?= base_url('assets') ?>/profil/<?= $this->session->userdata('foto') ?>" class="img-circle" alt="User Image">
           </div>
           <div class="pull-left info">
               <p><?= $this->session->userdata('nama') ?></p>
           <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
           </div>
       </div> -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?= base_url('admin/dashboard') ?>">
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/ruangan') ?>">
                    <i class="fa fa-windows"></i> <span>Data Ruangan</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('admin/booking') ?>">
                    <i class="fa fa-shopping-cart"></i> <span>Data Booking</span>
                </a>
            </li>
            <?php if ($this->session->userdata('level') == 'Administrator') { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('admin/user') ?>"><i class="fa fa-circle-o"></i> Manajemen User</a></li>
                        <li><a href="<?= base_url('admin/aplikasi') ?>"><i class="fa fa-circle-o"></i> Tentang Aplikasi</a></li>
                        <li><a href="<?= base_url('admin/backupdatabase') ?>"><i class="fa fa-circle-o"></i> Backup Database</a></li>
                        <li><a href="<?= base_url('admin/log') ?>"><i class="fa fa-circle-o"></i> Log Status</a></li>
                    </ul>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('admin/profil') ?>">
                    <i class="fa fa-user"></i> <span>Profil</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('auth/logout') ?>" class="tombol-yakin" data-isidata="Ingin keluar dari sistem ini?">
               <i class="fa fa-sign-out"></i> <span>Sign Out</span> </a>
            </li>
        </ul>
    </section>
</aside>

<!-- SweetAlert2 -->
<script src="<?= base_url('assets') ?>/bower_components/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $('.tombol-yakin').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            const isidata = $(this).data('isidata') || 'Yakin ingin melanjutkan?';

            Swal.fire({
                title: 'Konfirmasi',
                text: isidata,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            });
        });
    });
</script>