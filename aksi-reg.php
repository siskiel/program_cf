<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>Expert System | Diagnosa</title>

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="assets/hasil-konsultasi/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="assets/hasil-konsultasi/dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<div class="card">
			<div class="card-header">
			<h3 class="card-title">Gejala :</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body p-0">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="width: 10%">No</th>
							<th style="width: 20%">Kode Gejala</th>
							<th style="width: 60%">Nama Gejala</th>
							<th style="width: 10%">Nilai Bobot</th>
						</tr>
					</thead>
					<tbody>
					<?php include('config/koneksi.php') ?>

					<?php
						$pilihan_user = [];
						$no = 1;
						foreach ($_POST['id_gejala'] as $key => $value) {
							// if($value > 0):
								$result = $koneksi->query("SELECT * FROM gejala WHERE id_gejala='".$key."'");
								while($row = mysqli_fetch_array($result)):
									echo "<tr>";
									echo "<td>" . $no . "</td>";
									echo "<td>" . $row['kode_gejala'] . "</td>";
									echo "<td>" . $row['nama_gejala'] . "</td>";
									echo "<td>" . $row['nilai_bobt'] . "</td>";

									$no+=1;
								endwhile;
							// endif;
						}
					?>
					</tbody>
				</table>
			</div>
			<!-- /.card-body -->
			</div>

			<hr style="border-top: 2px solid black;">

			<?php
				if(isset($_POST['submit'])) {
					// gejala yg dipilih user
					$pilihan_user = [];
					foreach ($_POST['id_gejala'] as $key => $value) {
					// 	if($value > 0):
							$pilihan_user[] = $key;
					// 	endif;
					}


					$sql = "SELECT GROUP_CONCAT(penyakit.kode_penyakit), gejala.nilai_ds FROM rule JOIN penyakit ON rule.id_penyakit = penyakit.id_penyakit JOIN gejala ON rule.id_gejala = gejala.id_gejala WHERE rule.id_gejala IN (".implode(',',$pilihan_user).") GROUP BY rule.id_gejala";
					$result=$koneksi->query($sql);
					$gejala=array();
					while($row=$result->fetch_row()){
						$gejala[]=$row;
					}


					//simpan kedalam database table pasien
					$name = $_POST['name'];
					$tgllahir = $_POST['tgllahir'];
					$$no_hp = $_POST['notlp'];
					$jk = $_POST['jk'];
					$alamat = $_POST['alamat'];
					$tglkonsul = $_POST['tglkonsul'];

					$query = "INSERT INTO pasien (nama_pasien, tgl_lahir, jk, no_hp, alamat,id_penyakit, gejala, total_perhitungan) VALUES ('".$name."', '".$tgllahir."', '".$jk."',  '".$no_hp."', '".$alamat."', '".$tglkonsul."', '".$row[0]."', '".serialize($pilihan_user)."')";

					if($koneksi->query($query) === TRUE):
						// tangkap last id
						$last_id = $koneksi->insert_id;

						// hasil
						echo '<div class="alert alert-info alert-dismissible">';
						echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
						echo '<h5><i class="icon fas fa-info"></i> Hasil Diagnosa!</h5>';
						// echo "Terdeteksi penyakit <b>{$row[1]}</br> dengan derajat kepercayaan ".round($densitas_baru[$codes[0]],2)." % <br>";
						echo "<a href='proses_cetak.php?id=".$last_id."' class='btn btn-primary btn-flat '><i class='fa fa-print'></i> Cetak Laporan</a>";
						echo '</div>';
					else:
						// echo "<pre>";print_r($koneksi->error_list);
					endif;	
				} 
			?>
		</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery -->
	<script src="assets/hasil-konsultasi/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="assets/hasil-konsultasi/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="assets/hasil-konsultasi/dist/js/adminlte.min.js"></script>
</body>

</html>
