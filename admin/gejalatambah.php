<h2>Tambah Gejala</h2>
<div class="pull-right">
    <a href="index.php?halaman=gejala" class="btn btn-warning">
        << Kembali </a>
</div>
<br>
<br>

<form method="post">
    <div class="form-group">
        <label>Kode Gejala</label>
        <input type="text" class="form-control" name="kode" placeholder="Kode Gejala">
    </div>
    <div class="form-group">
        <label>Nama Gejala</label>
        <input type="text" class="form-control" name="nama" placeholder="Nama Gejala">
    </div>
    <div class="form-group">
        <label>Measure Of Belief (MB)</label>
        <input type="descimal" class="form-control" name="mb" placeholder="0.8">
    </div>
    <div class="form-group">
        <label>Measure Of Disbelief (MD)</label>
        <input type="descimal" class="form-control" name="md" placeholder="0.8">
    </div>
    <div class="form-group pull-right">
        <button class="btn btn-default " name="rest" type="reset">Reset</button>
        <button class="btn btn-success" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {
    $mb = $_POST['mb'] ;
    $md =   $_POST['md'];
$nilai_bobot = $mb - $md;
    $koneksi->query("INSERT INTO gejala (kode_gejala,nama_gejala,MB,MD,nilai_bobot) VALUES('$_POST[kode]','$_POST[nama]',$mb,$md,$nilai_bobot)");
    echo "<div class='alert alert-info'>Data tersimpan</div>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=gejala'>";
}
?>