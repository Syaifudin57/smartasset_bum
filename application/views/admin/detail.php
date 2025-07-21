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
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <button class="btn btn-primary" onclick="history.back(-1)">
                            <div class="fa fa-arrow-left"></div> Kembali
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <?php foreach ($ruangan->result_array() as $vRg) { ?>
                                    <tr>
                                        <td>Kode</td>
                                        <td width="10px">:</td>
                                        <td><?= $vRg['kode'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><?= $vRg['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Booking</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            $this->db->where('idRuangan', $vRg['id']);
                                            echo $this->m_model->get_desc('tb_booking')->num_rows();
                                            ?> Booking
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Terdaftar</td>
                                        <td>:</td>
                                        <td><?= date('d F Y H:i:s', strtotime($vRg['terdaftar'])) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Daftar Booking</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>Ruangan</th>
                                        <th>User</th>
                                        <th>Tanggal</th>
                                        <th>Dari Jam</th>
                                        <th>Sampai Jam</th>
                                        <th>Agenda</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($booking->result_array() as $vBk) {
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php
                                                $this->db->where('id', $vBk['idRuangan']);
                                                foreach ($this->m_model->get_desc('tb_ruangan')->result() as $vRgn) {
                                                    echo $vRgn->nama;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $this->db->where('id', $vBk['idUser']);
                                                foreach ($this->m_model->get_desc('tb_user')->result() as $vUsr) {
                                                    echo $vUsr->nama;
                                                }
                                                ?>
                                            </td>
                                            <td><?= date('d F Y', strtotime($vBk['tanggal'])) ?></td>
                                            <td><?= date('H:i', strtotime($vBk['dariJam'])) ?></td>
                                            <td><?= date('H:i', strtotime($vBk['sampaiJam'])) ?></td>
                                            <td><?= $vBk['agenda'] ?></td>
                                            <td>
                                                <?php
                                                if ($vBk['status'] == 'Diterima') {
                                                    echo '<label class="label label-success">' . $vBk['status'] . '</label>';
                                                } elseif ($vBk['status'] == 'Ditolak') {
                                                    echo '<label class="label label-danger">' . $vBk['status'] . '</label>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>