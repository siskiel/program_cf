<h2>Edit Data Gejala</h2>
<div class="pull-right">
    <a href="index.php?halaman=gejala" class="btn-warning btn">
        << Kembali </a>
</div>
<br>
<br>
<?php

$ambil = $koneksi->query("SELECT * FROM gejala WHERE id_gejala='$_GET[id]'");
$pecah = $ambil->fetch_assoc();

// echo "<pre>";
// print_r($pecah);
// echo "</pre>";

?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Kode Gejala</label>
        <input type="text" class="form-control" name="kode" value="<?php echo $pecah['kode_gejala']; ?>">
    </div>
    <div class="form-group">
        <label>Nama Gejala</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $pecah['nama_gejala']; ?>">
    </div>
    <div class="form-group">
        <label>Measure Of Belief (MB)</label>
        <input type="float" class="form-control" name="mb" value="<?php echo $pecah['MB']; ?>">
    </div>
    <div class="form-group">
        <label>Measure Of Disbelief (MD)</label>
        <input type="float" class="form-control" name="md" value="<?php echo $pecah['MD']; ?>">
    </div>
    <button class="btn btn-primary" name="ubah">Ubah</button>
</form>
<?php
if (isset($_POST['ubah'])) {
    $mb = $_POST['mb'] ;
    $md =   $_POST['md'];
$nilai_bobot = $mb - $md;
    $koneksi->query("UPDATE gejala SET kode_gejala='$_POST[kode]', nama_gejala='$_POST[nama]', MB= $mb, MD= $md,
        nilai_bobot=$nilai_bobot WHERE id_gejala='$_GET[id]'");

    echo "<div class='alert alert-info'>Data Berhasil di ubah</div>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=gejala'>";
}
?>