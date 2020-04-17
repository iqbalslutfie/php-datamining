<?php

include_once "mining.php";

$latih = new mining();

$banyakdata = mysqli_query($koneksi->konek(), "SELECT * FROM mining_c45");
$banyakdatapinjaman = mysqli_query($koneksi->konek(), "SELECT * FROM pinjaman");
if (mysqli_num_rows($banyakdatapinjaman) == 0) {
    echo "<script>window.alert('Data Pinjaman Kosong, Import Data Terlebih Dahulu !!!') </script>";
    $latih->populateDb();
} else if (mysqli_num_rows($banyakdatapinjaman) != 0 && mysqli_num_rows($banyakdata) != 0) {
    // echo "<script>window.alert('Mining Sudah Dilakukan !!!') </script>";
    // 				window.location='index.php?page=data_mining'</script>";
} else {
    # code...
    $latih->populateDb();
    $latih->miningC45('', '');
    // $latih->menentukanLancarMacet();
    // $latih->miningC45('', '');
    echo "<script>document.body.innerHTML = '';window.location.reload(true);window.alert('Proses Mining Sukses !!!')";
    "window.location='index.php?page=proses_mining'</script>";
    // echo "<script>window.location.reload(true)</script>";
}
