<?php
include "../../config/koneksi.php";
$id = $_GET['id'];
$query = ("DELETE FROM nasabah WHERE idnasabah ='$id'");
if (!mysqli_query($koneksi, $query)) {
    die(mysqli_error($koneksi));
} else {
    echo '<script>alert("Data Berhasil Dihapus !!!");
window.location.href="../../index.php?page=data_nasabah"</script>';
}
