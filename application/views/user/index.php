<div class="content-wrapper">
    <section class="content-header">
        <h1 style="font-size: 20px;">Manajemen User</h1>
    </section>

    <section class="content">
        <div class="box box-solid" style="font-size: 13px;">
            <div class="box-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <a href="<?= base_url('user/add') ?>" class="btn btn-warning btn-sm mb-3">
                    <i class="fa fa-plus"></i> Tambah User
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Nama Lengkap</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user->username ?></td>
                                    <td><?= ucfirst($user->role) ?></td>
                                    <td><?= $user->name ?? '-' ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('user/edit/' . $user->id) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url('user/delete/' . $user->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data user.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 