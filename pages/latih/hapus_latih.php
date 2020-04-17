<?php
include_once "../../config/koneksi.php";
$id = $_GET['id'];
$query = ("DELETE FROM pinjaman WHERE idpinjaman ='$id'");
if (!mysqli_query($koneksi, $query)) {
    die(mysqli_error($koneksi));
} else {
    echo '<script>alert("Data Berhasil Dihapus !!!");
window.location.href="../../index.php?page=data_latih"</script>';
}
