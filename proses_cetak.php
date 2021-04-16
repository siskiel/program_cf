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
    }

    .table tr th {
        background: #35A9DB;
        color: #fff;
        font-weight: normal;
    }
    </style>
</head>

<body>
    <center>
        <h1>Laporan Diagnosa Penyakit</h1>

        <hr /><br /><br /><br />

        <table class="table" border="1px">
            <tbody>
                <?php
                    $result = $koneksi->query("SELECT * FROM pasien JOIN penyakit ON pasien.id_penyakit = penyakit.id_penyakit WHERE id_pasien='".$_GET['id']."'");
    
                    $no = 1;
                    while($row = mysqli_fetch_array($result)):
                        echo "<pre>".$row. "</pre>";
                        // echo "<tr>";
                        // echo "<th>No</th>";
                        // echo "<td>" . $no . "</td>";
                        // echo "</tr>";

                        echo "<tr>";
                        echo "<th>Nama Lengkap</th>";
                        echo "<td>" . $row['nama_pasien'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Tgl. Lahir</th>";
                        echo "<td>" . date ('d F Y', strtotime($row['tgl_lahir'])) . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Jenis Kelamin</th>";
                        echo "<td>" . $row['jk'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>No. Hp</th>";
                        echo "<td>" . $row['no_hp'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Alamat</th>";
                        echo "<td>" . $row['alamat'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Tgl. Konsul</th>";
                        echo "<td>" . date ('d F Y', strtotime($row['tgl_konsul'])) . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Penyakit</th>";
                        echo "<td>" . $row['kode_penyakit'] . " <br> " . $row['nama_penyakit'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>Derajat Kepercayaan</th>";
                        echo "<td>" . round($row['total_perhitungan'],2) . " %</td>";
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
                        echo "</tr>";

                        

                                             
                        $no++;
                    endwhile;
    
                    // mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
    </center>

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