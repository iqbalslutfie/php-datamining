<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            TAMBAH LATIH
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?page=data_latih"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">TAMBAH LATIH</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="pages/latih/tambah_latih_proses.php">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Nasabah" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <input type="text" name="tahun" class="form-control" placeholder="Tahun Pinjam" required>
                            </div>
                            <div class="form-group">
                                <label>Instansi</label>
                                <select class="form-control" name="instansi">
                                    <option value="">- Pilih Instansi -</option>
                                    <option value="SD">SD (Sekolah Dasar)</option>
                                    <option value="STAP DISDIK">STAP DISDIK (Dinas Pendidikan)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Pinjaman</label>
                                <select class="form-control" name="jenispinjaman">
                                    <option value="">- Pilih Jenis Pinjaman -</option>
                                    <option value="KMS">KMS (Kredit Modal Sendiri)</option>
                                    <option value="NIAGA">NIAGA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Simpanan</label>
                                <input type="text" name="simpanan" class="form-control" placeholder="Simpanan (Rp. )" required>
                            </div>
                            <div class="form-group">
                                <label>Pinjaman</label>
                                <input type="text" name="pinjaman" class="form-control" placeholder="Pinjaman (Rp. )" required>
                            </div>
                            <div class="form-group">
                                <label>Lama Angsur</label>
                                <input type="text" name="lamaangsur" class="form-control" placeholder="Lama Angsur (Bulan)" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="">- Pilih Status Pinjaman -</option>
                                    <option value="LANCAR">LANCAR</option>
                                    <option value="MACET">MACET</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" title="Simpan Data"> <i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->