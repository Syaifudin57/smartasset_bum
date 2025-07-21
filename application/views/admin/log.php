<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>User</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Sebagai</th>
                                <th>Status</th>
                                <th>Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($log->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php
                                        $this->db->where('id', $row['idUser']);
                                        foreach ($this->db->get('tb_user')->result() as $dUsr) {
                                            echo $dUsr->nama;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row['ipAddress'] ?></td>
                                    <td><?= $row['device'] ?></td>
                                    <td><?= $dUsr->level ?></td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 'Login') {
                                            echo '<div class="label label-success">' . $row['status'] . '</div>';
                                        } else {
                                            echo '<div class="label label-danger">' . $row['status'] . '</div>';
                                        }
                                        ?>
                                    </td>
                                    <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>