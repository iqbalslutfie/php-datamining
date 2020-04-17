<?php
include_once "../../config/koneksi.php";
if ($_POST) {
    $nama = $_POST['nama'];
    $tahun = $_POST['tahun'];
    $instansi = $_POST['instansi'];
    $jenispinjaman = $_POST['jenispinjaman'];
    $simpanan = $_POST['simpanan'];
    $pinjaman = $_POST['pinjaman'];
    $lamaangsur = $_POST['lamaangsur'];
    $status = $_POST['status'];
    $query = ("UPDATE pinjaman SET nama='$nama',tahun='$tahun',jeniskelamin='$jeniskelamin',instansi='$instansi',jenispinjaman='$jenispinjaman',simpanan='$simpanan',pinjaman='$pinjaman',status='$status' WHERE idpinjaman ='$id'");
    if (!mysqli_query($koneksi, $query)) {
        die(mysqli_error($koneksi));
    } else {
        echo '<script>alert("Data Berhasil Diubah !!!");
window.location.href="../../index.php?page=data_latih"</script>';
    }
}
