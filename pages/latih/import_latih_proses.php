<?php
include_once "../../config/koneksi.php";
include_once "../../config/excel_reader2.php";

include_once "../mining/mining.php";
$koneksi = new koneksi();

$latih = new mining();

$ekstensi_file    = array('xls');
$ekstensi        = strtolower(end(explode('.', $_FILES['filelatih']['name'])));
$ekstensi_ok    = in_array($ekstensi, $ekstensi_file);

// validasi input type file
if (!($ekstensi_ok)) {
    echo '<script>document.body.innerHTML = "";alert("Maaf, file yang boleh diupload hanya file excel berekstensi .xls , ulangi !");
    window.location.href="../../index.php?page=import_latih"</script>';
}
// jika validasi type file terpenuhi
else {
    //Tulis query database disini
    // echo "Good! Input type file sesuai ketentuan ekstensi. Silahkan lanjut query database nya ...<br>";

    //upload file xlss
    $target = basename($_FILES['filelatih']['name']);

    move_uploaded_file($_FILES['filelatih']['tmp_name'], $target);

    // beri permisi agar file xls dapat di baca
    chmod($_FILES['filelatih']['name'], 0777);

    // mysqli_query($koneksi->konek(), "TRUNCATE TABLE persiapan");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE pinjaman");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE iterasi_c45");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE mining_c45");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE pohon_keputusan_c45");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE klasifikasi");
    // $latih->populateDb();

    // mengambil isi file xls
    $data = new Spreadsheet_Excel_Reader($_FILES['filelatih']['name'], false);
    // menghitung jumlah baris data yang ada
    $jumlah_baris = $data->rowcount($sheet_index = 0);

    // jumlah default data yang berhasil di import
    for ($i = 2; $i <= $jumlah_baris; $i++) {

        // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
        $no     = $data->val($i, 1);
        $nama   = $data->val($i, 2);
        $tahun  = $data->val($i, 3);
        $instansi  = $data->val($i, 4);
        $jenispinjaman  = $data->val($i, 5);
        $simpanan  = $data->val($i, 6);
        $pinjaman  = $data->val($i, 7);
        $jasa  = $data->val($i, 8);


        $lamaangsur  = $data->val($i, 9);
        $status  = $data->val($i, 10);

        $query = "INSERT into pinjaman values('','$nama','$tahun','$instansi','$jenispinjaman','$simpanan','$pinjaman','$jasa','$lamaangsur','$status')";
        if (!mysqli_query($koneksi->konek(), $query)) {
            die(mysqli_error($koneksi->konek()));
        } else {
            echo '<script>document.body.innerHTML = "";alert("Import Data Berhasil Ditambahkan !!!");
window.location.href="../../index.php?page=data_latih"</script>';
        }
    }
    // mysqli_query($koneksi->konek(), "TRUNCATE TABLE persiapan");
    // mysqli_query($koneksi->konek(), "TRUNCATE TABLE pembersihan");
    // mysqli_query($koneksi->konek(), "TRUNCATE TABLE seleksi");

    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['filelatih']['name']);
}
