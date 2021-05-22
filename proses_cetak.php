<?php
    include('assets/hasil-konsultasi/plugins/dompdf/autoload.inc.php');
    include('config/koneksi.php');
    ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Prediksi Penyakit</title>

    <style>
    .table {
        width: 100%;
        background-color: transparent;
        border-collapse: collapse;
        display: table;
        /* border: 1px; */
    }

    .table tr th {
        background: #35A9DB;
        color: black;
        font-weight: normal;
        /* border: 1px; */
    }
    </style>
</head>

<body>
    <center>
        <h1>Laporan Perdiksi Pasien Penyakit Ginjal</h1>
        <h1>RSUD Deli Serdang</h1>
        <h2>Jl. Mh. Thamrin No.126, Lubuk Pakam Pekan, Kec. Lubuk Pakam, Kabupaten Deli
            Serdang, Sumatera Utara</h2>
        <hr /><br /><br /><br />

        <table class="table" border="1px">
            <tbody>
                <!-- <th>Ini penjelsanan</th> -->
                <?php
                        // print_r($row);
                        // echo "<pre>".$row. "</pre>";
                        $result = $koneksi->query("SELECT * FROM pasien  WHERE id_pasien='".$_GET['id']."'");
                        $no = 1;
                      while($row = mysqli_fetch_array($result)):
                                                echo "<tr>";
                        echo "<th>Nama Lengkap</th>";
                        echo "<td colspan='2' >" . $row['nama_pasien'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Tgl. Lahir</th>";
                        echo "<td colspan='2'>" . date ('d F Y', strtotime($row['tgl_lahir'])) . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Jenis Kelamin</th>";
                        echo "<td colspan='2'>" . $row['jk'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>No. Hp</th>";
                        echo "<td colspan='2'>" . $row['no_hp'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Alamat</th>";
                        echo "<td colspan='2'>" . $row['alamat'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th >Tgl. Konsul</th>";
                        echo "<td colspan='2'>" . date ('d F Y', strtotime($row['tgl_konsul'])) . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Derajat Kepercayaan</th>";
                        echo "<td colspan='2'>" . round($row['total_perhitungan'],2) . " %</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<th>Penyakit</th>";
                        echo "<td>"; 
                        $penyakit = unserialize($row['id_penyakit']);
                        foreach ($penyakit as $key => $value) {
                            $result_penyakit = $koneksi->query("SELECT * FROM penyakit WHERE id_penyakit='".$value."'");
                            while($row_penyakit = mysqli_fetch_array($result_penyakit)):
                                echo " " . $row_penyakit['nama_penyakit'] . "<br>";
                            endwhile;
                            
                        }
                        echo "</td>";
                        echo "<td>Nilai Jawaban </td>";
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
                        $pilihan_user = unserialize($row['pilihan_user']);
                        foreach ($pilihan_user as $key => $value) {
                            $result_pilihan = $koneksi->query("SELECT * FROM pilihan_user WHERE bobot_pilihan ='".$value."'");
                            while($row_pilihan = mysqli_fetch_array($result_pilihan)):
                                echo $row_pilihan['bobot_pilihan'] . " (" . $row_pilihan['nama_pilihan'] . ")" . "<br>";
                            endwhile;
                        }
                         echo "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Solusi</th>";
                        echo "<td colspan='2'>";
                        $penyakit = unserialize($row['id_penyakit']);
                        foreach ($penyakit as $key => $value) {
                            $result_penyakit = $koneksi->query("SELECT * FROM penyakit WHERE id_penyakit='".$value."'");
                            while($row_penyakit = mysqli_fetch_array($result_penyakit)):
                                echo " " . $row_penyakit['solusi'] . "<br>";
                            endwhile;
                            
                        }
                        $no++;
                    endwhile;
    
                    mysqli_close($koneksi);
               ?>

            </tbody>
        </table>

    </center>

    <p style="text-align: right;">dr.Asri Ludin Tambunan</p>
    <br>
    <br>
    <br>
    <h4 style="text-align: right; "><strong> Dokter Spesialis Penyakit Dalam </strong> </h4>
    <br><br><br>

</body>

</html>

<?php
$html = ob_get_clean();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('laporan_hasil.pdf');
?>