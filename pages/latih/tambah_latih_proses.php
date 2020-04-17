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
    $query = ("INSERT INTO pinjaman(idpinjaman,nama,tahun,instansi,jenispinjaman,simpanan,pinjaman,lamaangsur,status) VALUES ('','" . $nama . "','" . $tahun . "','" . $jeniskelamin . "','" . $instansi . "','" . $jenispinjaman . "','" . $simpanan . "','" . $pinjaman . "','" . $lamaangsur . "','" . $status . "')");
    if (!mysqli_query($koneksi, $query)) {
        die(mysqli_error($koneksi));
    } else {
        echo '<script>alert("Data Berhasil Ditambahkan !!!");
window.location.href="../../index.php?page=data_latih"</script>';
    }
}
