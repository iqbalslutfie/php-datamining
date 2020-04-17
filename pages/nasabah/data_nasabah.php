<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DATA NASABAH
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">DATA NASABAH</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <a href="index.php?page=tambah_nasabah" class="btn btn-primary" role="button" title="Tambah Data"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
                        <a href="index.php?page=import_nasabah" class="btn btn-info" role="button" title="Import Data"><i class="glyphicon glyphicon-upload"></i> Import Data</a>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="mahasiswa" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAMA NASABAH</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>UNIT KERJA</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $koneksi = new koneksi();
                                $no = 0;
                                $query = mysqli_query($koneksi->konek(), "SELECT * FROM nasabah ORDER BY idnasabah ASC");
                                while ($row = mysqli_fetch_array($query)) {
                                ?>

                                    <tr>
                                        <td><?php echo $no = $no + 1; ?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['jeniskelamin']; ?></td>
                                        <td><?php echo $row['unitkerja']; ?></td>
                                        <td>
                                            <a href="index.php?page=ubah_nasabah&id=<?= $row['idnasabah']; ?>" class="btn btn-success" role="button" title="Ubah Data"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a href="pages/nasabah/hapus_nasabah.php?id=<?= $row['idnasabah']; ?>" class="btn btn-danger" role="button" title="Hapus Data"><i class="glyphicon glyphicon-trash"></i></a>
                                        </td>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#nasabah').DataTable();
    });
</script>