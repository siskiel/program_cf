<?php
  require_once("../config/koneksi.php");
  if (isset($_SESSION['nama_lengkap'])) {
      echo "<script>window.location= '".base_url('/admin/home.php')."';</script>";
  }

   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="assets/login/images/icons/favicon.ico"/>

    <title>Halaman Administrasi</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../assets/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/adminlte/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="../assets/images/images.png"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Perawat</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                 <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../assets/images/avatar.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Rini</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="home.php" class="nav-link {{ set_active('home') }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ set_active(['datapasien', 'datapenyakit', 'datadokter']) }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="datapasien.php" class="nav-link {{ set_active('data.alternatif.index') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Pasien</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kriteria.index') }}" class="nav-link {{ set_active('kriteria.index') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Gejala</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kriteria.index') }}" class="nav-link {{ set_active('kriteria.index') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Penyakit</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('proses.index') }}" class="nav-link {{ set_active('proses.index') }}">
                                <i class="nav-icon fas fa-heartbeat"></i>
                                <p>Riwayat</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link {{ set_active('laporan.index') }}">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Solusi</p>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                                <a href="{{ route('kriteria.index') }}" class="nav-link {{ set_active('kriteria.index') }}">
                                    <i class="nav-icon fas fa-address-card"></i>
                                <p>Data Dokter</p>
                           </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Log Out</p>
                                <form id="logout-form" action="logout.php" method="POST" style="display: none;">
                                    
                                </form>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

