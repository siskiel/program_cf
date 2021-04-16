<?php 
$id_pasien =$_GET['id'];
$ambil=$koneksi->query("SELECT * FROM pasien WHERE pasien.id_pasien='$id_pasien'");
$detail = $ambil->fetch_assoc();

 $result = $koneksi->query("SELECT * FROM pasien  WHERE id_pasien='$id_pasien'");
// $row = mysqli_fetch_array($result);
?>
<h2>Detail Pasien <?php echo $detail['nama_pasien']; ?> </h2>
<div class="pull-right">
    <a href="index.php?halaman=diagnosa" class="btn btn-warning">
        << Kembali </a>
</div>
<br>
<div class="form-row">
    <div class="form-group">
        <div class="col-md-6">
            <p> Tanggal Lahir</p>
            <input type="text" readonly value="<?php  echo date ('d F Y', strtotime($detail['tgl_lahir']));?>"
                class="form-control">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <div class="col-md-6">
            <p>Jenis Kelamin</p>
            <input type="text" readonly value="<?php echo $detail['jk']; ?>" class="form-control">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <div class="col-md-6">
            <p>No. HP</p>
            <input type="text" readonly value="<?php echo $detail['no_hp']; ?>" class="form-control">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <div class="col-md-6">
            <p>Alamat</p>
            <input type="text" readonly value="<?php echo $detail['alamat']; ?>" class="form-control">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <div class="col-md-6">
            <p>Tanggal Konsul</p>
            <input type="text" readonly value="<?php echo date ('d F Y', strtotime( $detail['tgl_konsul'])); ?>"
                class="form-control">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <div class="col-md-6">
            <p>Total Perhitungan</p>
            <input type="text" readonly value="<?php echo round($detail['total_perhitungan'],2); ?>"
                class="form-control">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <div class="col-md-12">
            <h4><strong>Detail Gejala</strong></h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2">Penjelasan</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- <th>Ini penjelsanan</th> -->
                    <?php
    // print_r($row);
    // echo "<pre>".$row. "</pre>";
                        $no = 1;
                      while($row = mysqli_fetch_array($result)):

                        
                        echo "<tr>";
                        echo "<th>Penyakit</th>";
                        echo "<td>"; 
                        $penyakit = unserialize($row['id_penyakit']);
                        foreach ($penyakit as $key => $value) {
                            $result_penyakit = $koneksi->query("SELECT * FROM penyakit WHERE id_penyakit='".$value."'");
                            while($row_penyakit = mysqli_fetch_array($result_penyakit)):
                                echo $key+1 . ". " . $row_penyakit['nama_penyakit'] . "<br>";
                            endwhile;
                        }
                        echo "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Gejala</th>";
                        echo "<td>";
                        $gejala = unserialize($row['gejala']);
                        foreach ($gejala as $key => $value) {
                            $result_gejala = $koneksi->query("SELECT * FROM gejala WHERE id_gejala='".$value."'");
                            while($row_gejala = mysqli_fetch_array($result_gejala)):
                                echo $key+1 . ". " . $row_gejala['nama_gejala'] . "<br>";
                            endwhile;
                        }
                        echo "</td>";
                        echo "<td>";
                        $piliha_user = unserialize($row['pilihan_user']);
                        foreach ($piliha_user as $key => $value) {
                            $result_pilihan = $koneksi->query("SELECT * FROM pilihan_user WHERE id_pilihan_user ='".$value."'");
                            while($row_pilihan = mysqli_fetch_array($result_pilihan)):
                                echo $key+1 . ". " . $row_pilihan['bobot_pilihan'] . "<br>";
                            endwhile;
                        }
                        echo "</td>";
                        echo "</tr>";
                        
                        $no++;
                    endwhile;
    
                    mysqli_close($koneksi);
               ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- <div class="pull-right">
<a href="cetak.php&id=<?php echo $detail['id_pasien'];?>" class="btn btn-primary" > <i class="fa fa-print">  Print</i> </a>
</div> -->