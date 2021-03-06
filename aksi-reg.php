<?php

include('config/koneksi.php');

$nama_pasien = $_POST['name'];
$tgl_lahir = date('Y-m-d', strtotime($_POST['tgllahir']));
$jk = $_POST['jk'];
$no_hp = $_POST['notlp'];
$alamat = $_POST['alamat'];
$tgl_konsul = $_POST['tglkonsul'];

$gejala_user = $_POST['gejala'];

// mengambil data penyakit
$data_penyakit = [];
$query = "SELECT * FROM penyakit";
$result = $koneksi->query($query);
$index = 0;
while ($row = mysqli_fetch_array($result)) :
    $data_penyakit['id_penyakit'][$index] = $row['id_penyakit'];
    $data_penyakit['kode_penyakit'][$index] = $row['kode_penyakit'];
    $data_penyakit['nama_penyakit'][$index] = $row['nama_penyakit'];
    $data_penyakit['solusi'][$index] = $row['solusi'];

    $index++;
endwhile;

// mengambil data gejala
$data_gejala = [];
$query = "SELECT * FROM gejala";
$result = $koneksi->query($query);
$index = 0;
while ($row = mysqli_fetch_array($result)) :
    $data_gejala['id_gejala'][$index] = $row['id_gejala'];
    $data_gejala['kode_gejala'][$index] = $row['kode_gejala'];
    $data_gejala['nama_gejala'][$index] = $row['nama_gejala'];
    $data_gejala['nilai_bobot'][$index] = $row['nilai_bobot'];

    $index++;
endwhile;

// mengambil rule berdasarkan gejala user untuk mengambil nilai cf
$gejala_user_fix = [];
$pilihan_user = [];
$pilihan_user_value = [];
foreach ($gejala_user as $key => $value) {
    array_push($pilihan_user, $key);
    array_push($pilihan_user_value, $value);

    $result = $koneksi->query("SELECT * FROM rule INNER JOIN gejala ON rule.id_gejala = gejala.id_gejala WHERE rule.id_gejala='" . $key . "'");
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) :
            $gejala_user_fix[$row['id_penyakit']]['cf'][] = $row['nilai_bobot'] * $value;
        endwhile;
    }
}

$CF_HE = [];
foreach ($gejala_user_fix as $key => $value) {
    if (count($value['cf']) > 1) {
        // echo "lebih dari satu penyakit";
        $cfold = 0;

        for ($i = 0; $i < (count($value['cf']) - 1); $i++) {
            if ($i == 0) {
                $cfold = $value['cf'][$i] + ($value['cf'][$i + 1] * (1 - $value['cf'][$i]));
            } else {
                $cfold = $cfold + ($value['cf'][$i + 1] * (1 - $cfold));
            }
        }

        $CF_HE[$key] = $cfold;
    } else {
        // echo "cuma satu penyakit";
        $CF_HE[$key] = $value['cf'][0];
    }
}

// urutkan nilai dari terbesar ke terkecil;
arsort($CF_HE);

// lalu hasilkan lagi array yang bisa di gunakan secara dinamis
$cf_hasil_akhir['keys'] = array_keys($CF_HE);
$cf_hasil_akhir['values'] = array_values($CF_HE);

// echo "<pre>"; print_r($cf_hasil_akhir); echo "</pre>";

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Expert System | Diagnosa</title>


    <!-- Theme style -->
    <link rel="stylesheet" href="assets/laporan/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Gejala yang Anda Pilih</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <table class="table table-striped ">
                        <thead class="table-primary">
                            <tr class="text ">
                                <th>No</th>
                                <th>Kode Gejala</th>
                                <th>Nama Gejala</th>
                                <th>Nilai Bobot</th>
                                <th>Nilai User</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($pilihan_user as $key => $value) {
                                $index =  array_search("{$value}", $data_gejala['id_gejala'], true);

                                echo "<tr>";
                                echo "<td align='center'>" . $no . "</td>";
                                echo "<td >" . $data_gejala['kode_gejala'][$index] . "</td>";
                                echo "<td >" . $data_gejala['nama_gejala'][$index] . "</td>";
                                echo "<td >" . $data_gejala['nilai_bobot'][$index] . "</td>";
                                echo "<td >" . $gejala_user[$value] . "</td>";
                                echo "</tr>";

                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Hasil Perhitungan</h5>
                                <?php
                                if (isset($_POST['submit'])) {
                                    if ($cf_hasil_akhir['values'][0] == $cf_hasil_akhir['values'][1]) {
                                        $penyakit_gabungan = [$cf_hasil_akhir['keys'][0], $cf_hasil_akhir['keys'][1]];

                                        // lalu simpan hasil ke dalam table pasien
                                        $query = "INSERT INTO pasien (nama_pasien, tgl_lahir, jk, no_hp, alamat, tgl_konsul, id_penyakit, gejala, pilihan_user, total_perhitungan) VALUES ('" . $nama_pasien . "', '" . $tgl_lahir . "', '" . $jk . "', '" . $no_hp . "', '" . $alamat . "', '" . $tgl_konsul . "', '" . serialize($penyakit_gabungan) . "', '" . serialize($pilihan_user) . "', '" . serialize($pilihan_user_value) . "', '" . $cf_hasil_akhir['values'][0] . "')";

                                        if ($koneksi->query($query) === TRUE) :
                                            // tangkap last id
                                            $last_id = $koneksi->insert_id;

                                            // isi pesan untuk hasil diagnosa
                                            $pesan = "
							<p>
								Dari hasil perhitungan, maka dapat disimpulkan penyakit yang anda alami adalah
								<pre>" . $data_penyakit['nama_penyakit'][array_search($cf_hasil_akhir['keys'][0], $data_penyakit['id_penyakit'])] . " (" . $cf_hasil_akhir['keys'][0] . ")" . "</pre>
								<pre>" . $data_penyakit['nama_penyakit'][array_search($cf_hasil_akhir['keys'][1], $data_penyakit['id_penyakit'])] . " (" . $cf_hasil_akhir['keys'][1] . ")" . "</pre>
								Dengan tingkat presentasi:
								<pre>" . round(($cf_hasil_akhir['values'][0] * 100), 2) . "%</pre>
								Solusi : 
								<pre>" . $data_penyakit['nama_penyakit'][array_search($cf_hasil_akhir['keys'][0], $data_penyakit['id_penyakit'])] . " (" . $cf_hasil_akhir['keys'][0] . ")" . "</pre>
								<pre>" . $data_penyakit['solusi'][array_search($cf_hasil_akhir['keys'][0], $data_penyakit['id_penyakit'])] . "</pre>
				
								<pre>" . $data_penyakit['nama_penyakit'][array_search($cf_hasil_akhir['keys'][1], $data_penyakit['id_penyakit'])] . " (" . $cf_hasil_akhir['keys'][1] . ")" . "</pre>
								<pre>" . $data_penyakit['solusi'][array_search($cf_hasil_akhir['keys'][1], $data_penyakit['id_penyakit'])] . "</pre>
							</p>
							<a href='content/user/konsultasi/proses_cetak.php?id=" . $last_id . "' class='btn btn-primary btn-flat float-right'><i class='fa fa-print'></i> Cetak Laporan</a>
							<br><br>
							";
                                        else :
                                            $pesan = 'Gagal mendiagnosa penyakit';
                                        endif;
                                    } else {
                                        // lalu simpan hasil ke dalam tbl_konsultasi
                                        $penyakit_gabungan = [$cf_hasil_akhir['keys'][0]];

                                        // lalu simpan hasil ke dalam table pasien
                                        $query = "INSERT INTO pasien (nama_pasien, tgl_lahir, jk, no_hp, alamat, tgl_konsul, id_penyakit, gejala, pilihan_user, total_perhitungan) VALUES ('" . $nama_pasien . "', '" . $tgl_lahir . "', '" . $jk . "', '" . $no_hp . "', '" . $alamat . "', '" . $tgl_konsul . "', '" . serialize($penyakit_gabungan) . "', '" . serialize($pilihan_user) . "', '" . serialize($pilihan_user_value) . "', '" . $cf_hasil_akhir['values'][0] . "')";

                                        if ($koneksi->query($query) === TRUE) :
                                            // tangkap last id
                                            $last_id = $koneksi->insert_id;

                                            // isi pesan untuk hasil diagnosa
                                            $pesan = "
							<p>
								Dari hasil perhitungan certainty factor, maka dapat disimpulkan penyakit yang anda alami adalah
								<pre>" . $data_penyakit['nama_penyakit'][array_search($cf_hasil_akhir['keys'][0], $data_penyakit['id_penyakit'])] . " (" . $cf_hasil_akhir['keys'][0] . ")" . "</pre>
								Dengan tingkat presentasi:
								<pre>" . round(($cf_hasil_akhir['values'][0] * 100), 2) . "%</pre>
								<pre><strong>Anda akan menjalaini Hemodelosia</strong></pre>

							</p>
                            
							<a href='proses_cetak.php?id=" . $last_id . "' class='btn btn-primary btn-flat float-right'><i class='fa fa-print'></i> Cetak Laporan</a>
							<br><br>
							";
                                        else :
                                            $pesan = 'Gagal mendiagnosa penyakit ' . $koneksi->error;
                                        endif;
                                    }

                                    echo $pesan;
                                }
                                $result = $koneksi->query("SELECT * FROM pasien  WHERE id_pasien='" . $last_id . "'");
                                while ($row = mysqli_fetch_array($result)) :
                                    $penyakit = unserialize($row['id_penyakit']);
                                    foreach ($penyakit as $key => $value) {
                                        $result_penyakit = $koneksi->query("SELECT * FROM penyakit WHERE id_penyakit='" . $value . "'");
                                        while ($row_penyakit = mysqli_fetch_array($result_penyakit)) :
                                            echo " Solusi : <br>";
                                            echo " " . $row_penyakit['solusi'] . "<br>";
                                        endwhile;
                                    }
                                endwhile;
                                ?>
                                <!-- <p class="card-text">With supporting text below as a natural lead-in to additional
                                    content.</p> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body text-muted">
                                <h5 class="card-title">Keterangan</h5>
                                <p class="card-text">Nilai User merupakan, jawaban dari yang anda pilih pada halaman
                                    sebelumnya</p>
                                <table class="table text-muted">
                                    <thead class="table-info text-muted">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nilai</th>
                                            <th scope="col">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope="row">1</td>
                                            <td>0</td>
                                            <td>Tidak Tau</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">2</td>
                                            <td>0,2</td>
                                            <td>Tidak Yakin</td>

                                        </tr>
                                        <tr>
                                            <td scope="row">3</td>
                                            <td>0,4</td>
                                            <td>Sedikit Yakin</td>

                                        </tr>
                                        <tr>
                                            <td scope="row">4</td>
                                            <td>0,6</td>
                                            <td>Cukup Yakin</td>

                                        </tr>
                                        <tr>
                                            <td scope="row">5</td>
                                            <td>0,8</td>
                                            <td>Yakin</td>

                                        </tr>
                                        <tr>
                                            <td scope="row">6</td>
                                            <td>1</td>
                                            <td>Sangat Yakin</td>

                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

    </div>



    <hr style="border-top: 2px solid black;">


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="assets/laporan/js/bootstrap.js"></script>
</body>

</html>