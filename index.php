<?php
session_start();
include_once "config/koneksi.php";
$koneksi = new koneksi();

if (isset($_SESSION['idakun']) == 0) {
  echo '<script>alert("Anda Harus Login Terlebih Dahulu !!!");
window.location.href="pages/login.php"</script>';
} else {
  $query = mysqli_query($koneksi->konek(), "select nama, profil from akun where idakun ='" . $_SESSION['idakun'] . "'");
  $row = mysqli_fetch_assoc($query);
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="dist\img\koperasi6464.ico">
    <title>KOPERASI PENDIDIKAN CICALENGKA</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <!-- <link rel="stylesheet" href="bower_components/morris.js/morris.css"> -->
    <!-- jvectormap -->
    <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
    <!-- Date Picker -->
    <!-- <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> -->
    <!-- Daterange picker -->
    <!-- <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- DataTables -->
    <!-- <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css"> -->
    <!-- jQuery 2.2.3 -->
    <!-- <script src="plugins/jQuery/jquery-2.2.3.min.js"></script> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="dist/img/logo-koperasi.png" class="img-circle" width="50" style="padding-top:0; "></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-md" style="margin:0 auto;">
            <img src="dist/img/logo-koperasi.png" class="img-circle" width="50" style="padding-top:0; margin-right:10px;"><b>KOPERASI</b>PC</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs">
                    <?php
                    echo $row['nama'];
                    ?>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <?php
                    echo "<p> " . $row['nama'] . " - " . $row['profil'] . "</p>";
                    ?>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="pages\logout_proses.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/logo-koperasi.png" class="img-circle" alt="User Image">
            </div>
          </div> -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <!-- <li class="header">MENU</li> -->
            <li class="treeview">
            <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> <span>Beranda</span></a></li>
            <li><a href="index.php?page=data_latih"><i class="glyphicon glyphicon-education"></i> <span>Data Pinjaman</span></a></li>
            </li>

            <!-- <li class="treeview">
              <a href="#">
                <i class="glyphicon glyphicon-briefcase"></i> <span>Kelola Data</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="index.php?page=data_nasabah"><i class="glyphicon glyphicon-education"></i> <span>Data Nasabah</span></a></li>
                <li><a href="index.php?page=data_latih"><i class="glyphicon glyphicon-education"></i> <span>Data Latih</span></a></li>
              </ul>
            </li> -->
            <!-- <li><a href="index.php?page=data_mining"><i class="glyphicon glyphicon-education"></i> <span>Data Mining</span></a></li> -->
            <li class="treeview">
              <a href="#">
                <i class="glyphicon glyphicon-briefcase"></i> <span>Data Mining</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <!-- <li><a href="index.php?page=data_mining"><i class="glyphicon glyphicon-education"></i> <span>Pemodelan C45</span></a></li> -->
                <li><a href="index.php?page=proses_mining"><i class="glyphicon glyphicon-education"></i> <span>Proses Mining</span></a></li>
                <li><a href="index.php?page=pohon_keputusan"><i class="glyphicon glyphicon-education"></i> <span>Aturan Keputusan</span></a></li>
                <!-- <li><a href="#"><i class="glyphicon glyphicon-education"></i> <span>Evaluasi</span></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-education"></i> <span>Pengujian</span></a></li> -->
              </ul>
            </li>
            <li><a href="index.php?page=klasifikasi"><i class="glyphicon glyphicon-education"></i> <span>Klasifikasi</span></a></li>
            <li><a href="index.php?page=laporan"><i class="glyphicon glyphicon-education"></i> <span>Buat Laporan</span></a></li>
            <li><a href="pages/logout_proses.php"><i class="glyphicon glyphicon-lock"></i> <span>Logout</span></a></li>

            <!-- <li class="header">SETTING</li>
            <li class="treeview">
            <li><a href="#"><i class="glyphicon glyphicon-cog"></i> <span>Pengaturan</span></a></li>
            <li><a href="pages/logout_proses.php"><i class="glyphicon glyphicon-lock"></i> <span>Logout</span></a></li>
            </li> -->
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Konten -->
      <!-- Content -->
      <?php include "config/page.php"; ?>
      <!-- /Content -->

      <footer class="main-footer">
        <center>
          <strong>Copyright &copy; 2019</strong> Koperasi Pendidikan Cicalengka
        </center>
      </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="bower_components/raphael/raphael.min.js"></script>
    <script src="bower_components/morris.js/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

    <!-- DataTables -->
    <!-- <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script> -->

  </body>

  </html>

<?php } ?>