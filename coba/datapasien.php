  <?php 
  include '../template/sidebar_template.php';   ?>
          <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                                <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #17a2b8; color: white">
                        <h3 class="card-title">Table Data Pasien</h3>

                        <div class="card-tools">
                            <button class="btn btn-danger btn-black">Delete All</button>
                        </div>
                    </div>


                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped table-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Umur</th>
                                    <th>Tanggal Konsultasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


  <?php include '../template/footer_template.php';    ?>


