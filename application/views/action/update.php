<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Nasution">
    <?php $this->load->view("_isi/head.php"); ?>
</head>
<body>
    <?php $this->load->view("_isi/navbar.php"); ?>
    <div class="container">
        <div class="col-md-9">
            <h3>Update data Mahasiswa</h3>
            <hr>
            <form action="<?php echo site_url('Universitas/Update') ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tb_mahasiswa->id ?>">
                
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $tb_mahasiswa->nama ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control"><?php echo $tb_mahasiswa->alamat ?></textarea>
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <?php foreach ($tb_jurusan as $prodi): ?>
                            <option value="<?php echo $prodi->id ?>"
                                <?php if ($prodi->id == $tb_mahasiswa->id_jurusan) echo 'selected'; ?>>
                                <?php echo $prodi->nama_jurusan ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="submit" class="btn btn-success" value="Simpan">
            </form>
        </div>
    </div>
    <?php $this->load->view("_isi/footer.php"); ?>
    <?php $this->load->view("_isi/js.php"); ?>
</body>
</html>
