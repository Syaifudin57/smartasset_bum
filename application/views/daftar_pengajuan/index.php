<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Cabang</th>
                    <th>No. Form</th>
                    <th>Tanggal</th>
                    <th>Nama Aset</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Status Keseluruhan</th>
                    <th>Approval Kacab</th>
                    <th>Approval AM</th>
                    <th>Approval HO</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pengajuan)): ?>
                    <?php foreach ($pengajuan as $item): ?>
                        <tr>
                            <td><?= $item->nama_cabang ?? '-' ?></td>
                            <td><?= $item->nomor_form ?? '-' ?></td>
                            <td><?= isset($item->tanggal_form) ? date('d-m-Y', strtotime($item->tanggal_form)) : '-' ?></td>
                            <td><?= $item->nama_aset ?? '-' ?></td>
                            <td><?= $item->quantity_aset ?? '-' ?></td>
                            <td><?= isset($item->estimasi_harga) ? number_format($item->estimasi_harga, 0, ',', '.') : '-' ?></td>
                            <td><?= ucfirst($item->overall_status ?? 'N/A') ?></td>
                            <td><?= ucfirst($item->status_kacab ?? 'pending') ?></td>
                            <td><?= ucfirst($item->status_am ?? 'pending') ?></td>
                            <td><?= ucfirst($item->status_ho ?? 'pending') ?></td>
                            <td>
                                <?php
                                $role = $this->session->userdata('role');
                                // Tampilkan tombol berdasarkan peran dan status approval
                                if ($item->overall_status === 'Submitted') { // Hanya izinkan aksi jika status keseluruhan masih 'Submitted'
                                    if ($role == 'kepala_cabang' && $item->status_kacab == 'pending') {
                                        echo "<a href='" . base_url('daftarpengajuan/approve/kacab/' . $item->id) . "' class='btn btn-success btn-sm'>✔</a> ";
                                        echo "<a href='" . base_url('daftarpengajuan/reject/kacab/' . $item->id) . "' class='btn btn-danger btn-sm'>✖</a>";
                                    } elseif ($role == 'area_manager' && $item->status_kacab == 'approved' && $item->status_am == 'pending') {
                                        echo "<a href='" . base_url('daftarpengajuan/approve/am/' . $item->id) . "' class='btn btn-success btn-sm'>✔</a> ";
                                        echo "<a href='" . base_url('daftarpengajuan/reject/am/' . $item->id) . "' class='btn btn-danger btn-sm'>✖</a>";
                                    } elseif ($role == 'admin_pusat' && $item->status_am == 'approved' && $item->status_ho == 'pending') {
                                        echo "<a href='" . base_url('daftarpengajuan/approve/ho/' . $item->id) . "' class='btn btn-success btn-sm'>✔</a> ";
                                        echo "<a href='" . base_url('daftarpengajuan/reject/ho/' . $item->id) . "' class='btn btn-danger btn-sm'>✖</a>";
                                    } else {
                                        echo "-"; // Jika tidak ada aksi yang bisa dilakukan oleh peran ini
                                    }
                                } else {
                                    echo "-"; // Jika status keseluruhan bukan 'Submitted' (misal Approved/Rejected)
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data pengajuan yang perlu disetujui.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>