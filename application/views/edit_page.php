<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PayColl CTB</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/skins/_all-skins.min.css">
  <style type="text/css">
    .box{
      overflow-x: scroll;
    }
    .box-body{
      overflow-x: scroll;
    }
  </style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CTB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PayColl</b>CTB</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('telkom2.png');?>">&nbsp&nbsp&nbsp&nbsp<span class="hidden-xs"><?php echo $_SESSION['username']['nama'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url('index.php/auth/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo base_url('index.php/auth');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php if($_SESSION['username']['role']=="Administrator"){?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Data</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('index.php/crud/create');?>"><i class="fa fa-circle-o"></i> Tambah</a></li>
            <li><a href="<?php echo base_url('index.php/excel/import');?>"><i class="fa fa-circle-o"></i> Import</a></li>
            <li><a href="<?php echo base_url('index.php/excel/export');?>"><i class="fa fa-circle-o"></i> Export</a></li>
          </ul>
        </li>
          <?php }?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Work Order
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
      </ol>
    </section>
    <section class="content">
      
    <?php if(isset($error)){?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
      </div>
    <?php }?>
      <div class="row">
        <div class="col-lg-12">
          
          <!-- /.box -->

          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo base_url('index.php/crud/update/'.$id);?>" class="form-horizontal" enctype="multipart/form-data" method="POST">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Nama Visitor</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="merk" name="nama_visitor" value="<?php echo $nama_visitor;?>">
                        <input type="text" class="form-control" id="merk" name="nama_visitor" value="<?php echo $nama_visitor;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Visit</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="tipe" name="tgl_visit" value="<?php echo $tgl_visit;?>" >
                        <input type="text" class="form-control" id="tipe" name="tgl_visit" value="<?php echo $tgl_visit;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">No Inet</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="serial-number" name="no_inet" value="<?php echo $no_inet;?>">
                        <input type="text" class="form-control" id="serial-number" name="no_inet" value="<?php echo $no_inet;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">No Ref</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="mac-address" name="no_ref" value="<?php echo $no_ref;?>" >
                        <input type="text" class="form-control" id="mac-address" name="no_ref" value="<?php echo $no_ref;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Prioritas</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="status-ap" name="prioritas" value="<?php echo $prioritas;?>" >
                        <input type="text" class="form-control" id="status-ap" name="prioritas" value="<?php echo $prioritas;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="drop-from" name="alamat" value="<?php echo $alamat;?>" >
                        <input type="text" class="form-control" id="drop-from" name="alamat" value="<?php echo $alamat;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Customer</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="status-ap" name="customer" value="<?php echo $customer;?>" >
                        <input type="text" class="form-control" id="status-ap" name="customer" value="<?php echo $customer;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Nomor</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="location-type" name="nomor" value="<?php echo $nomor;?>" >
                        <input type="text" class="form-control" id="location-type" name="nomor" value="<?php echo $nomor;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">RT/RW</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="customer" name="rt_rw" value="<?php echo $rt_rw;?>" >
                        <input type="text" class="form-control" id="customer" name="rt_rw" value="<?php echo $rt_rw;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Kelurahan</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="alamat" name="kelurahan" value="<?php echo $kelurahan;?>" >
                        <input type="text" class="form-control" id="alamat" name="kelurahan" value="<?php echo $kelurahan;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Telp</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="skema-bisnis" name="mk_tlp" value="<?php echo $mk_tlp;?>" >
                        <input type="text" class="form-control" id="skema-bisnis" name="mk_tlp" value="<?php echo $mk_tlp;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="ssi" name="mk_email" value="<?php echo $mk_email;?>" >
                        <input type="text" class="form-control" id="ssi" name="mk_email" value="<?php echo $mk_email;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Tagihan N</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="posisi-ap" name="tagihan_n" value="<?php echo $tagihan_n;?>" >
                        <input type="text" class="form-control" id="posisi-ap" name="tagihan_n" value="<?php echo $tagihan_n;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Tagihan N1</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="tahun-aktif" name="tagihan_n1" value="<?php echo $tagihan_n1;?>" >
                        <input type="text" class="form-control" id="tahun-aktif" name="tagihan_n1" value="<?php echo $tagihan_n1;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Total Tagihan</label>
                      <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="tahun-aktif" name="tagihan_n1" value="<?php echo $tagihan_n1;?>" >
                        <input type="text" class="form-control" id="tahun-aktif" name="tagihan_n1" value="<?php echo $tagihan_n1;?>" 
                        <?php if ($_SESSION['username']['role'] != 'Administrator'): ?>
                          disabled=""  
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Kategori Visit</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="kategori_visit">
                          <option value="ALAMAT TIDAK DITEMUKAN"
                          <?php if($kategori_visit == "ALAMAT TIDAK DITEMUKAN"){
                            echo 'selected=""';
                          }?>
                          >ALAMAT TIDAK DITEMUKAN</option>
                          <option value="BUKAN PELANGGAN BERSANGKUTAN"
                          <?php if($kategori_visit == "BUKAN PELANGGAN BERSANGKUTAN"){
                            echo 'selected=""';
                          }?>
                          >BUKAN PELANGGAN BERSANGKUTAN</option>
                          <option value="BUKAN PEMILIK / DM"
                          <?php if($kategori_visit == 'BUKAN PEMILIK / DM'){
                            echo 'selected=""';
                          }?>
                          >BUKAN PEMILIK / DM</option>
                          <option value="INPROGRES VISIT" 
                          <?php if($kategori_visit == "INPROGRES VISIT"){
                            echo 'selected=""';
                          }?>
                          >INPROGRES VISIT</option>
                          <option value="JANJI BAYAR"
                          <?php if($kategori_visit == "JANJI BAYAR"){
                            echo 'selected=""';
                          }?>
                          >JANJI BAYAR</option>
                          <option value="JARANG DIPAKAI"
                          <?php if($kategori_visit == "JARANG DIPAKAI"){
                            echo 'selected=""';
                          }?>
                          >JARANG DIPAKAI</option>
                          <option value="KEMAHALAN"
                          <?php if($kategori_visit == "KEMAHALAN"){
                            echo 'selected=""';
                          }?>
                          >KEMAHALAN</option>
                          <option value="KENDALA KEUANGAN/ BANGKRUT"
                          <?php if($kategori_visit == 'KENDALA KEUANGAN/ BANGKRUT'){
                            echo 'selected=""';
                          }?>
                          >KENDALA KEUANGAN/ BANGKRUT</option>
                          <option value="LAYANAN BELUM AKTIF"
                          <?php if($kategori_visit == 'LAYANAN BELUM AKTIF'){
                            echo 'selected=""';
                          }?>
                          >LAYANAN BELUM AKTIF</option>
                          <option value="LUPA BAYAR"
                          <?php if($kategori_visit == 'LUPA BAYAR'){
                            echo 'selected=""';
                          }?>
                          >LUPA BAYAR</option>
                          <option value="PASANG TINGGAL/ CABUT PASANG"
                          <?php if($kategori_visit == 'PASANG TINGGAL/ CABUT PASANG'){
                            echo 'selected=""';
                          }?>
                          >PASANG TINGGAL/ CABUT PASANG</option>
                          <option value="PENANGANAN GANGGUAN LAMBAT/ BERTELE-TELE"
                          <?php if($kategori_visit == 'PENANGANAN GANGGUAN LAMBAT/ BERTELE-TELE'){
                            echo 'selected=""';
                          }?>
                          >PENANGANAN GANGGUAN LAMBAT/ BERTELE-TELE</option>
                          <option value="PINDAH RUMAH/ SELESAI KONTRAK"
                          <?php if($kategori_visit == 'PINDAH RUMAH/ SELESAI KONTRAK'){
                            echo 'selected=""';
                          }?>
                          >PINDAH RUMAH/ SELESAI KONTRAK</option>
                          <option value="RUMAH TAK BERPENGHUNI"
                          <?php if($kategori_visit == 'RUMAH TAK BERPENGHUNI'){
                            echo 'selected=""';
                          }?>
                          >RUMAH TAK BERPENGHUNI</option>
                          <option value="SERING GANGGUAN/ GANGGUAN BERULANG"
                          <?php if($kategori_visit == 'SERING GANGGUAN/ GANGGUAN BERULANG'){
                            echo 'selected=""';
                          }?>
                          >SERING GANGGUAN/ GANGGUAN BERULANG</option>
                          <option value="SUDAH BAYAR"
                          <?php if($kategori_visit == 'SUDAH BAYAR'){
                            echo 'selected=""';
                          }?>
                          >SUDAH BAYAR</option>
                          <option value="SUDAH MINTA CABUT MASIH TIMBUL TAGIHAN"
                          <?php if($kategori_visit == 'SUDAH MINTA CABUT MASIH TIMBUL TAGIHAN'){
                            echo 'selected=""';
                          }?>
                          >SUDAH MINTA CABUT MASIH TIMBUL TAGIHAN</option>
                          <option value="TAGIHAN MELONJAK"
                          <?php if($kategori_visit == 'TAGIHAN MELONJAK'){
                            echo 'selected=""';
                          }?>
                          >TAGIHAN MELONJAK</option>
                          <option value="TARIF TIDAK SESUAI JANJI"
                          <?php if($kategori_visit == 'TARIF TIDAK SESUAI JANJI'){
                            echo 'selected=""';
                          }?>
                          >TARIF TIDAK SESUAI JANJI</option>
                          <option value="TIDAK BERTEMU PENGHUNI"
                          <?php if($kategori_visit == 'TIDAK BERTEMU PENGHUNI'){
                            echo 'selected=""';
                          }?>
                          >TIDAK BERTEMU PENGHUNI</option>
                          <option value="TIDAK MERASA PASANG"
                          <?php if($kategori_visit == 'TIDAK MERASA PASANG'){
                            echo 'selected=""';
                          }?>
                          >TIDAK MERASA PASANG</option>
                          <option value="TIDAK SEMPAT BAYAR/ SIBUK/ LUPA"
                          <?php if($kategori_visit == 'TIDAK SEMPAT BAYAR/ SIBUK/ LUPA'){
                            echo 'selected=""';
                          }?>
                          >TIDAK SEMPAT BAYAR/ SIBUK/ LUPA</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Nama yang ditemui</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="bulan-aktif" name="nama_yang_ditemui" value="<?php echo $nama_yang_ditemui;?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="keterangan" value="<?php echo $keterangan;?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Foto</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" name="userfile">
                      </div>
                    </div>
                  </div>
                  
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Simpan</button>
              </div>
              <!-- /.box-footer -->

              <!-- modal -->
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Peringatan</h4>
                    </div>
                    <div class="modal-body">
                      Apakah anda yakin akan mengubah data tersebut ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                      <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https:telkom.co.id">Telkom Indonesia</a>.</strong> (940393)
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        
        <!-- /.control-sidebar-menu -->

        
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="https://adminlte.io/themes/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="https://adminlte.io/themes/AdminLTE/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
