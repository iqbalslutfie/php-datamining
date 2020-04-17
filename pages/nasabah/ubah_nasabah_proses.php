<?php
include "../../config/koneksi.php";
if ($_POST) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $unitkerja = $_POST['unitkerja'];
    $query = ("UPDATE nasabah SET nama='$nama',jeniskelamin='$jeniskelamin',unitkerja='$unitkerja' WHERE idnasabah ='$id'");
    if (!mysqli_query($koneksi, $query)) {
        die(mysqli_error($koneksi));
    } else {
        echo '<script>alert("Data Berhasil Diubah !!!");
window.location.href="../../index.php?page=data_nasabah"</script>';
    }
}
