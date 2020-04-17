<!-- Content Wrapper. Contains page content -->
<?php


function generatePohonC45($idparent, $spasi)
{
    $koneksi = new koneksi();

    $result = mysqli_query($koneksi->konek(), "select * from pohon_keputusan_c45 where id_parent= '$idparent'");
    while ($row = mysqli_fetch_row($result)) {
        for ($i = 1; $i <= $spasi; $i++) {
            echo "|&nbsp;&nbsp;";
        }

        if ($row[6] === 'Lancar') {
            $keputusan = "<font color=green>$row[6]</font>";
        } elseif ($row[6] === 'Macet') {
            $keputusan = "<font color=red>$row[6]</font>";
        } elseif ($row[6] === '?') {
            $keputusan = "<font color=blue>$row[6]</font>";
        } else {
            $keputusan = "<b>$row[6]</b>";
        }
        echo "<font color=red>$row[1]</font> adalah $row[2] (Lancar = $row[4], Macet = $row[5]) : <b>$keputusan</b><br>";

        /*panggil dirinya sendiri*/
        generatePohonC45($row[0], $spasi + 1);
    }
}

function getAturan()
{

    // ini ubah ke string
    // $koneksi = $this->kon->konek();
    // $query = ("SELECT GROUP_CONCAT(kondisi_atribut) AS kondisi from pohon_keputusan_c45 WHERE keputusan = 'Lancar'");
    // $result = mysqli_query($koneksi, $query);
    // $result2 = mysqli_fetch_assoc($result);
    // $resultstring = $result2['kondisi'];
    // echo str_replace('~', '', $resultstring);

    //ini ubah ke array
    $tampil = [];

    $koneksi = new koneksi();
    $query = ("SELECT DISTINCT kondisi_atribut from pohon_keputusan_c45 WHERE keputusan = 'Lancar'");
    $result = mysqli_query($koneksi->konek(), $query);

    while ($d = mysqli_fetch_array($result)) {
        $d = str_replace('~', '', $d);
        $d = str_replace('= <=', '<= ', $d);
        $d = str_replace('= >', '> ', $d);
        $d = str_replace('NIAGA', "'NIAGA' ", $d);
        $d = str_replace('KMS', "'KMS' ", $d);
        $d = substr_replace($d, "", 0, 4);
        $tampil[] = $d;
    }

    return $tampil;
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Aturan Keputusan
            <!-- <small>Perhitungan C45</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?page=data_mining"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">ATURAN KEPUTUSAN</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <!-- <div class="box-body table-responsive">
                        <?php
                        echo "<font face='Courier New' size='2'>";
                        // generatePohonC45('0', 0);
                        echo "</font>";
                        echo "<br><h4>Keterangan Hasil dari Pohon Keputusan:</h4><hr>";

                        if (!getAturan()) {
                            echo "Data Kosong";
                        } else {
                            echo "<br>
                                <table>
                                <tr><td width='80px;' style='color:green;'>Lancar</td> <td>:</td><td>Nasabah Lancar jauh lebih banyak dari Macet..</td></tr>
                                <tr><td style='color:red;'>Macet</td> <td>:</td><td>Nasabah Macet jauh lebih banyak dari Lancar..</td></tr>
                                <tr><td style='color:black;'>Kosong</td> <td>:</td><td>Nasabah Lancar tidak ada, dan Macet Pun Tidak ada,.</td></tr>
                                <tr><td style='color:blue;'>?</td> <td>: </td><td>Jumlah Nasabah Lancar dan Macet Beda Tipis,.</td>
                                </tr></table>";
                        }
                        ?>
                    </div> -->

                    <div class="box-header">
                        <h4>Aturan Mining:</h4>
                        <!-- <hr> -->
                        <?php
                        // $koneksi = new koneksi();
                        // $query = ("SELECT GROUP_CONCAT(kondisi_atribut) AS kondisi from pohon_keputusan_c45 WHERE keputusan = 'Lancar'");
                        // $result = mysqli_query($koneksi->konek(), $query);
                        // $result2 = mysqli_fetch_assoc($result);
                        // $resultstring = $result2['kondisi'];

                        // echo str_replace('~', '', $resultstring);
                        if (!getAturan()) {
                            echo "Data Kosong";
                        } else {
                        ?>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style=" vertical-align: middle">No</th>
                                        <th class="text-center" style=" vertical-align: middle">Aturan</th>
                                        <!-- <th>No</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach (getAturan() as $result) {
                                    ?>
                                        <tr>
                                            <td class="text-center" style=" vertical-align: middle"><?php echo $i ?></td>
                                            <td><?php echo $result['kondisi_atribut'] ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper  -->