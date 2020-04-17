<?php
// include "../../config/koneksi.php";

// $koneksi = $this->kon->konek();

$noSeleksi = 1;
$noPembersihan = 1;
$noPersiapan = 1;
$halSeleksi = isset($_GET['pages']) ? $_GET['pages'] : 1;
$halPembersihan = isset($_GET['pages']) ? $_GET['pages'] : 1;
$halPersiapan = isset($_GET['pages']) ? $_GET['pages'] : 1;

function banyakPersiapan()
{
    $koneksi = new koneksi();
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $data = "SELECT * FROM persiapan";
    $query = mysqli_query($koneksi->konek(), $data);
    $banyakdata = mysqli_num_rows($query);

    return $banyakdata;
}

function banyakPembersihan()
{
    $koneksi = new koneksi();
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $data = "SELECT * FROM pembersihan";
    $query = mysqli_query($koneksi->konek(), $data);
    $banyakdata = mysqli_num_rows($query);

    return $banyakdata;
}

function banyakSeleksi()
{
    $koneksi = new koneksi();
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $data = "SELECT * FROM seleksi";
    $query = mysqli_query($koneksi->konek(), $data);
    $banyakdata = mysqli_num_rows($query);

    return $banyakdata;
}

function batasData()
{
    $limit = 20;
    return $limit;
}

function halSeleksi()
{
    $halaman = ceil($this->banyakSeleksi() / $this->batasData());
    return $halaman;
}

function halPembersihan()
{
    $halaman = ceil($this->banyakPembersihan() / $this->batasData());
    return $halaman;
}

function halPersiapan()
{
    $halaman = ceil($this->banyakPersiapan() / $this->batasData());
    return $halaman;
}

function tampilSeleksi($hal)
{
    $koneksi = new koneksi();
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $tampil = [];
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $limit = batasData();
    $mulai = ($hal > 1) ? ($hal * $limit) - $limit : 0;
    $query = "SELECT * FROM seleksi ORDER BY idpinjaman ASC LIMIT $mulai,$limit";
    $result = mysqli_query($koneksi->konek(), $query);

    while ($d = mysqli_fetch_array($result)) {
        $tampil[] = $d;
    }

    return $tampil;
}

function tampilPersiapan($hal)
{
    $koneksi = new koneksi();
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $tampil = [];
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $limit = batasData();
    $mulai = ($hal > 1) ? ($hal * $limit) - $limit : 0;
    $query = "SELECT * FROM persiapan ORDER BY idpinjaman ASC LIMIT $mulai,$limit";
    $result = mysqli_query($koneksi->konek(), $query);

    while ($d = mysqli_fetch_array($result)) {
        $tampil[] = $d;
    }

    return $tampil;
}

function tampilPembersihan($hal)
{
    $koneksi = new koneksi();
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $tampil = [];
    //melakukan inisiasi method konek di class koneksi ke var koneksi
    $limit = batasData();
    $mulai = ($hal > 1) ? ($hal * $limit) - $limit : 0;
    $query = "SELECT * FROM pembersihan ORDER BY idpinjaman ASC LIMIT $mulai,$limit";
    $result = mysqli_query($koneksi->konek(), $query);

    while ($d = mysqli_fetch_array($result)) {
        $tampil[] = $d;
    }

    return $tampil;
}


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            PROSES MINING
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?page=data_latih"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">PROSES MINING</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <!-- <a href="index.php?page=tambah_latih" class="btn btn-primary" role="button" title="Tambah Data"><i class="glyphicon glyphicon-plus"></i> Tambah</a> -->
                        <a href="index.php?page=melakukan_mining" class="btn btn-info" role="button" title="Import Data"><i class="glyphicon glyphicon-upload"></i> PROSES MINING</a>
                        <!-- <a href="index.php?page=bersihkan_latih" class="btn btn-danger" role="button" title="Hapus Data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a> -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Tabel Seleksi Data</h4>
                        <br>
                        <?php
                        echo "Jumlah data sebanyak : " . banyakSeleksi() . "data";
                        ?>
                        <div class="box-body table-responsive">
                            <table id="latih" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style=" vertical-align: middle">NO</th>
                                        <!-- <th class="text-center" style=" vertical-align: middle">NAMA</th>
                                        <th class="text-center" style=" vertical-align: middle">TAHUN</th> -->
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
                                    <?php foreach (tampilSeleksi($halSeleksi) as $row) { ?>
                                        <tr>
                                            <td class="text-center" style=" vertical-align: middle"><?php echo $noSeleksi++; ?></td>
                                            <!-- <td style="vertical-align: middle"><?php echo $row['nama']; ?></td>
                                            <td class="text-center" style="vertical-align: middle"><?php echo $row['tahun']; ?></td> -->
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
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Tabel Pembersihan Data</h4>
                        <br>
                        <?php
                        echo "Jumlah data sebanyak : " . banyakPembersihan() . "data";
                        ?>
                        <div class="box-body table-responsive">
                            <table id="latih" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style=" vertical-align: middle">NO</th>
                                        <!-- <th class="text-center" style=" vertical-align: middle">NAMA</th>
                                        <th class="text-center" style=" vertical-align: middle">TAHUN</th> -->
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
                                    <?php foreach (tampilPembersihan($halPembersihan) as $row) { ?>
                                        <tr>
                                            <td class="text-center" style=" vertical-align: middle"><?php echo $noPembersihan++; ?></td>
                                            <!-- <td style="vertical-align: middle"><?php echo $row['nama']; ?></td>
                                            <td class="text-center" style="vertical-align: middle"><?php echo $row['tahun']; ?></td> -->
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
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Tabel Persiapan Data Mining</h4>
                        <br>
                        <?php
                        echo "Jumlah data sebanyak : " . banyakPersiapan() . "data";
                        ?>
                        <div class="box-body table-responsive">
                            <table id="latih" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style=" vertical-align: middle">NO</th>
                                        <!-- <th class="text-center" style=" vertical-align: middle">NAMA</th>
                                        <th class="text-center" style=" vertical-align: middle">TAHUN</th> -->
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
                                    <?php foreach (tampilPersiapan($halPersiapan) as $row) { ?>
                                        <tr>
                                            <td class="text-center" style=" vertical-align: middle"><?php echo $noPersiapan++; ?></td>
                                            <!-- <td style="vertical-align: middle"><?php echo $row['nama']; ?></td>
                                            <td class="text-center" style="vertical-align: middle"><?php echo $row['tahun']; ?></td> -->
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