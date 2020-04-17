<!-- Content Wrapper. Contains page content -->
<?php
include "latih.php";
$latih = new latih();

$hal = isset($_GET['pages']) ? $_GET['pages'] : 1;

$no = $latih->mulaiNomor($hal, $latih->batasData()) + 1;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DATA PINJAMAN
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?page=data_latih"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">DATA PINJAMAN</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <!-- <a href="index.php?page=tambah_latih" class="btn btn-primary" role="button" title="Tambah Data"><i class="glyphicon glyphicon-plus"></i> Tambah</a> -->
                        <a href="index.php?page=import_latih" class="btn btn-info" role="button" title="Import Data"><i class="glyphicon glyphicon-upload"></i> Import Data</a>
                        <!-- <a href="index.php?page=bersihkan_latih" class="btn btn-danger" role="button" title="Hapus Data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a> -->
                    </div>
                    <div class="box-header">
                        <?php
                        echo "Jumlah data sebanyak : " . $latih->banyakData() . "data";
                        ?>
                        <nav>
                            <ul class="pagination nav navbar-nav navbar-center">
                                <li class="page-item">
                                    <a href="index.php?page=data_latih&pages=<?php echo $latih->halSebelumnya($hal); ?>">
                                        <span class="page-link" aria-hidden="true">&laquo; Sebelumnya</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $latih->banyakHalaman(); $i++) {
                                    $active = false;
                                    if ($hal == $i) {
                                        $active = "active";
                                    } ?>
                                    <li class="page-item <?php echo $active ?>"><a class="page-link" href="index.php?page=data_latih&pages=<?php echo $i; ?>"> <?php echo $i; ?></a></li>
                                <?php } ?>
                                <li class="page-item">
                                    <a href="index.php?page=data_latih&pages=<?php echo $latih->halSelanjutnya($hal, $latih->banyakHalaman()); ?>">
                                        <span class="page-link" aria-hidden="true">Sesudahnya &raquo; </span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="latih" class="table table-bordered table-hover">
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
                                    <th class="text-center" style=" vertical-align: middle">STATUS</th>
                                    <!-- <th class="text-center" style=" vertical-align: middle">AKSI</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latih->tampilData($hal) as $row) { ?>
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
                                        <td class="text-center" style="vertical-align: middle"><?php echo $row['status']; ?></td>
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
<!-- /.content-wrapper -->

<!-- Javascript Datatable -->
<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#latih').DataTable();
    });
</script> -->