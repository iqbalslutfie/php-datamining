<!-- Content Wrapper. Contains page content -->
<?php
include_once "mining.php";

// $koneksi = $this->kon->konek();
$koneksi = new koneksi();
$latih = new mining();

$banyakdata = mysqli_query($koneksi->konek(), "SELECT * FROM mining_c45");
$banyakdatapinjaman = mysqli_query($koneksi->konek(), "SELECT * FROM pinjaman");
if (mysqli_num_rows($banyakdatapinjaman) == 0) {
    echo "<script>window.alert('Data Pinjaman Kosong, Import Data Terlebih Dahulu !!!') </script>";
    $latih->populateDb();
} else if (mysqli_num_rows($banyakdatapinjaman) != 0 && mysqli_num_rows($banyakdata) != 0) {
    // echo "<script>window.alert('Mining Sudah Dilakukan !!!') </script>";
    // 				window.location='index.php?page=data_mining'</script>";
} else {
    # code...
    $latih->populateDb();
    $latih->miningC45('', '');
    // $latih->menentukanLancarMacet();
    // $latih->miningC45('', '');
    echo "<script>document.body.innerHTML = '';window.location.reload(true);window.alert('Proses Mining Sukses !!!') </script>";
    // 				window.location='index.php?page=data_mining'</script>";
    // echo "<script>window.location.reload(true)</script>";
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DATA MINING
            <small>Perhitungan C45</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?page=data_mining"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">DATA MINING</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">

                    <div class="box-body table-responsive">
                        <table id="latih" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style=" vertical-align: middle">No</th>
                                    <th class="text-center" style=" vertical-align: middle">Atribut Gain Ratio</th>
                                    <th class="text-center" style=" vertical-align: middle">ATRIBUT</th>
                                    <th class="text-center" style=" vertical-align: middle">NILAI ATRIBUT</th>
                                    <th class="text-center" style=" vertical-align: middle">TOTAL</th>
                                    <th class="text-center" style=" vertical-align: middle">JUMLAH LANCAR</th>
                                    <th class="text-center" style=" vertical-align: middle">JUMLAH MACET</th>
                                    <th class="text-center" style=" vertical-align: middle">ENTROPY</th>
                                    <th class="text-center" style=" vertical-align: middle">GAIN</th>
                                    <!-- <th class="text-center" style=" vertical-align: middle">AKSI</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($latih->tampilData() as $row) { ?>
                                    <tr>
                                        <td class="text-center" style=" vertical-align: middle"><?php echo $no++; ?></td>
                                        <td style="vertical-align: middle"><?php echo $row['atribut_gain_ratio_max']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['atribut']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['nilai_atribut']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['jml_kasus_total']; ?></td>
                                        <td class="text-right" style="vertical-align: middle"><?php echo $row['jml_lancar']; ?></td>
                                        <td class="text-right" style="vertical-align: middle"><?php echo $row['jml_macet']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['entropy']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['inf_gain']; ?></td>
                                        <!--                                         
                                        <td class="text-center">
                                            <a href="index.php?page=ubah_latih&id=#" class="btn btn-success" role="button" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a href="pages/latih/hapus_latih.php?id=#" class="btn btn-danger" role="button" title="Hapus Data"><i class="glyphicon glyphicon-trash"></i></a>
                                        </td>
                                         -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper  -->