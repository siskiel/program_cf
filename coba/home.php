  <?php 
  include 'sidebar_template.php';   ?>
          <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0 text-dark">
                                    <p>Tanggal/Waktu : <span id="tanggalwaktu"></span></p>
                                    <script>
                                    var tw = new Date();
                                    if (tw.getTimezoneOffset() == 0) (a=tw.getTime() + ( 7 *60*60*1000))
                                    else (a=tw.getTime());
                                    tw.setTime(a);
                                    var tahun= tw.getFullYear ();
                                    var hari= tw.getDay ();
                                    var bulan= tw.getMonth ();
                                    var tanggal= tw.getDate ();
                                    var hariarray=new Array("Minggu,","Senin,","Selasa,","Rabu,","Kamis,","Jum'at,","Sabtu,");
                                    var bulanarray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
                                    document.getElementById("tanggalwaktu").innerHTML = hariarray[hari]+" "+tanggal+" "+bulanarray[bulan]+" "+tahun+" Jam " + ((tw.getHours() < 10) ? "0" : "") + tw.getHours() + ":" + ((tw.getMinutes() < 10)? "0" : "") + tw.getMinutes() + (" WIB ");
                                    </script>
                                                                
                                <div style="float:center; text-align:center; color:red;">
                                        <div class="page-header">
                                            <h5 class="entry-title"><b><marquee>Selamat Datang Di Halaman Admin</marquee></b></h5>
                                             </div>
                                         </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <!-- @yield('content') -->
            </div>
            <!-- /.content -->
        </div>

<?php include 'footer_template.php';    ?>



