<?php
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Expert System - Deteksi</title>

    <!-- Icons font CSS-->
    <link href="assets/registrasi/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="assets/registrasi/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i"
        rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="assets/registrasi/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/registrasi/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="assets/registrasi/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-blue p-t-180 p-b-100 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Registration Info</h2>
                    <form method="POST" action="aksi-reg.php">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Nama" name="name" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="number" min="11" placeholder="No. Hp"
                                        name="notlp" required>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2 js-datepicker" type="text" placeholder="Tanggal Lahir"
                                        name="tgllahir" required>
                                    <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select class="form-select" name="jk" id="jk" required>
                                            <option disabled="disabled" selected="selected">Jenis Kelamin</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <div class="row row-space">
                            <div class="col-2"> -->
                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Alamat" name="alamat" required>
                        </div>
                        <input type="hidden" name="tglkonsul" value="<?php echo date("Y-m-d"); ?>">
                        <!--     </div>
                        </div> -->
                        <h4><strong> Siliahkan Pilih gejala yang anda alami</strong></h4>
                        <br>
                        <br>
                        <?php $ambil = $koneksi->query("SELECT * FROM gejala");
                        $no = 1; ?>
                        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                        <div class="row row-space">
                            <div class="col-2">
                                <h5 name="id_gejala[<?php echo $pecah['id_gejala'] ?>]"
                                    id="id_gejala[<?php echo $pecah['id_gejala'] ?>]">
                                    <?php echo $pecah['nama_gejala']; ?></h5>
                            </div>
                            <?php $ambil_datapilihan = $koneksi->query("SELECT * FROM pilihan_user");
                         ?>

                            <div class="col-2">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="gejala[<?php echo $pecah['id_gejala'] ?>]">
                                            <option disabled="disabled" selected="selected">--Pilih--</option>

                                            <?php while ($tampildata = $ambil_datapilihan->fetch_assoc()) { ?>
                                            <option value="<?php echo $tampildata['bobot_pilihan'];?>">
                                                <?php echo $tampildata['nama_pilihan']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green light" name="submit"
                                type="submit">Konsultasi</button>
                            <!-- <a href="diagnosis.php">Konsultasi</a> -->
                        </div>
                        <div class="col-12">
                            <a href="index.php" style="text-decoration: none">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="assets/registrasi/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="assets/registrasi/vendor/select2/select2.min.js"></script>
    <script src="assets/registrasi/vendor/datepicker/moment.min.js"></script>
    <script src="assets/registrasi/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="assets/registrasi/js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->