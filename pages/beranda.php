<?php
$koneksi = new koneksi();

$query = mysqli_query($koneksi->konek(), "select nama, profil from akun where idakun ='" . $_SESSION['idakun'] . "'");
$row = mysqli_fetch_assoc($query);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            BERANDA
            <small>Halaman
                <?php
                echo $row['profil'];
                ?>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">BERANDA</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h1 class="text-justify">PENERAPAN DATA MINING KLASIFIKASI DALAM MENENTUKAN PINJAMAN NASABAH DI KOPERASI PENDIDIKAN CICALENGKA</h1>
                        <hr>
                        <h4 class="text-justify">
                            Deskripsi : <br>Aplikasi ini digunakan sebagai penelitian untuk mengetahui bagaimana penerapan data mining untuk
                            klasifikasi pinjaman nasabah lancar dan macet dalam memberikan rekomendasi menambah besar pinjaman
                            menggunakan metode pohon keputusan (Decision Tree) dengan Algoritma C4.5</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.Main content -->
</div>
<!-- /.content-wrapper -->