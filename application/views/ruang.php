<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="author" content="Nasution">
  <?php $this->load->view("_isi/head.php"); ?>
</head>
<body>
  <?php $this->load->view("_isi/navbar.php"); ?>
  <div class="container">
    <table class="table">
      <legend class="text-center">Table Data Mahasiswa</legend>
      <div>
        <a href="<?php echo site_url('Universitas/tambahData'); ?>" class="btn btn-success">Tambah</a>
      </div>

      <?php if ($this->session->flashdata('msg_success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('msg_success'); ?></div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('msg_error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('msg_error'); ?></div>
      <?php endif; ?>

      <thead class="thead_dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nama</th>
          <th scope="col">Alamat</th>
          <th scope="col">Jurusan</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        foreach ($tb_mahasiswa as $mhs):
        ?>
          <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $mhs->nama ?></td>
            <td><?php echo $mhs->alamat ?></td>
            <td><?php echo $mhs->nama_jurusan ?></td>
            <td>
              <a href="<?php echo site_url('Universitas/edit/'.$mhs->id); ?>" class="btn btn-primary">Edit</a>
              <a href="<?php echo site_url('Universitas/delete/'.$mhs->id); ?>" class="btn btn-danger" onclick="return confirm('Apakah kamu yakin?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php $this->load->view("_isi/footer.php"); ?>
  <?php $this->load->view("_isi/js.php"); ?>
</body>
</html>
