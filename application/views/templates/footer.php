<!-- Footer -->
<footer class="main-footer mt-auto py-2 text-center bg-light text-muted">
    <div class="container">
        <small><strong>© 2025 PT. Bangun Usaha Mulia</strong> All rights reserved.</small>
    </div>
</footer>

</div> <!-- /.wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="<?= base_url('assets/AdminLTE/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/AdminLTE/dist/js/adminlte.min.js') ?>"></script>

<!-- iziToast CSS -->
<link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/izitoast/iziToast.min.css') ?>">

<!-- iziToast JS -->
<script src="<?= base_url('assets/AdminLTE/plugins/izitoast/iziToast.min.js') ?>"></script>

<!-- Flashdata to iziToast -->
<script>
    $(document).ready(function() {
        <?php if ($this->session->flashdata('success')): ?>
            iziToast.success({
                title: 'Berhasil',
                message: '<?= $this->session->flashdata('success'); ?>',
                position: 'topRight',
                timeout: 3000,
                transitionIn: 'fadeInDown',
                transitionOut: 'fadeOutUp'
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            iziToast.error({
                title: 'Gagal',
                message: '<?= $this->session->flashdata('error'); ?>',
                position: 'topRight',
                timeout: 3000,
                transitionIn: 'fadeInDown',
                transitionOut: 'fadeOutUp'
            });
        <?php endif; ?>
    });
</script>

</body>

</html>