<?php
include "../../config/koneksi.php";
if ($_POST) {
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $unitkerja = $_POST['unitkerja'];
    $query = ("INSERT INTO nasabah(idnasabah,nama,jeniskelamin,unitkerja) VALUES ('','" . $nama . "','" . $jeniskelamin . "','" . $unitkerja . "')");
    if (!mysqli_query($koneksi, $query)) {
        die(mysqli_error($koneksi));
    } else {
        echo '<script>alert("Data Berhasil Ditambahkan !!!");
window.location.href="../../index.php?page=data_nasabah"</script>';
    }
}
