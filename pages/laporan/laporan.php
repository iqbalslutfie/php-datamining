<!-- Content Wrapper. Contains page content -->
<?php
$koneksi = new koneksi();
$data = 'klasifikasi';
if (isset($_POST['submit'])) {
    $data = $_POST['data'];
    $sql = mysqli_query($koneksi->konek(), "select * from " . $data);
    // echo "<h4>$data</h4>";
    $i = 0;
    echo "<script> window.print(); </script>";
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            BUAT LAPORAN
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?page=keputusan"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">BUAT LAPORAN</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <!-- <a href="index.php?page=import_keputusan" class="btn btn-info" role="button" title="Import Data"><i class="glyphicon glyphicon-upload"></i> Import Data</a> -->
                        <!-- <a href="index.php?page=bersihkan_keputusan" class="btn btn-danger" role="button" title="Bersihkan Data"><i class="glyphicon glyphicon-trash"></i> Bersihkan Data</a> -->
                        <form method='POST' action=''>
                            <div class="row">
                                <div class="col-sm-3">
                                    <select name="data" class="form-control">
                                        <option value="klasifikasi">Data Klasifikasi</option>
                                        <option value="pinjaman">Data Pinjaman</option>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <input type="submit" class="btn btn-primary" role="button" title="Cetak Data" name="submit" Value="Cetak Data">
                                </div>
                                <!-- 
                                <div class="col-sm-1">
                                    <input type="submit" class="btn btn-primary" role="button" title="Cetak Data" name="submitcr" Value="Cetak Data">
                                </div> -->
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="keputusan" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style=" vertical-align: middle">NO</th>
                                    <th class="text-center" style=" vertical-align: middle">NAMA</th>
                                    <th class="text-center" style=" vertical-align: middle">TAHUN</th>
                                    <th class="text-center" style=" vertical-align: middle">INSTANSI</th>
                                    <th class="text-center" style=" vertical-align: middle">JENIS PINJAMAN</th>
                                    <th class="text-center" style=" vertical-align: middle">SIMPANAN<br>(RP)</th>
                                    <th class="text-center" style=" vertical-align: middle">PINJAMAN<br>(RP)</th>
                                    <th class="text-center" style=" vertical-align: middle">JASA<br>(RP)</th>
                                    <th class="text-center" style=" vertical-align: middle">LAMA ANGSUR<br>(Bulan)</th>
                                    <th class="text-center" style=" vertical-align: middle">
                                        <?php
                                        if ($data == 'klasifikasi') {
                                            echo 'PREDIKSI';
                                        } else {
                                            echo 'STATUS';
                                        } ?>
                                    </th>
                                    <!-- <th class="text-center" style=" vertical-align: middle">AKSI</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = mysqli_query($koneksi->konek(), "select * from " . $data);
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr>
                                        <td class="text-center" style=" vertical-align: middle"><?php echo $no++; ?></td>
                                        <td style="vertical-align: middle"><?php echo $row['nama']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['tahun']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['instansi']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['jenispinjaman']; ?></td>
                                        <td class="text-right" style="vertical-align: middle"><?php echo $row['simpanan']; ?></td>
                                        <td class="text-right" style="vertical-align: middle"><?php echo $row['pinjaman']; ?></td>
                                        <td class="text-right" style="vertical-align: middle"><?php echo $row['jasa']; ?></td>
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['lamaangsur']; ?></td>

                                        <td class="text-center" style="vertical-align: middle">
                                            <?php
                                            if ($data == 'klasifikasi') {
                                                echo $row['prediksi'];
                                            } else {
                                                echo $row['status'];
                                            } ?>
                                        </td>

                                        <!-- <td class="text-center">
                                            <a href="index.php?page=ubah_keputusan&id=<?php echo $row['idpinjaman']; ?>" class="btn btn-success" role="button" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a href="pages/keputusan/hapus_keputusan.php?id=<?php echo $row['idpinjaman']; ?>" class="btn btn-danger" role="button" title="Hapus Data"><i class="glyphicon glyphicon-trash"></i></a>
                                        </td> -->

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
<!-- /.content-wrapper -->