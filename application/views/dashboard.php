<?php $this->load->view('templates/header', ['title' => 'Dashboard']); ?>
<?php $this->load->view('templates/sidebar'); ?>

<!-- Content Wrapper -->
<div class="content-wrapper p-3">
    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-info">
                <h4>Selamat Datang, <?= $this->session->userdata('username'); ?>!</h4>
                <p>Anda login sebagai: <strong><?= $this->session->userdata('role'); ?></strong></p>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('templates/footer'); ?>