<?php
include_once "../../config/koneksi.php";
include_once "../../config/excel_reader2.php";

$koneksi = new koneksi();

$ekstensi_file    = array('xls');
$ekstensi        = strtolower(end(explode('.', $_FILES['fileklasifikasi']['name'])));
// $ekstensi = pathinfo($_FILES['fileklasifikasi']['name'], PATHINFO_EXTENSION);
$ekstensi_ok    = in_array($ekstensi, $ekstensi_file);

// validasi input type file
if (!($ekstensi_ok)) {
    echo '<script>document.body.innerHTML = "";alert("Maaf, file yang boleh diupload hanya file excel berekstensi .xls , ulangi !");
    window.location.href="../../index.php?page=import_klasifikasi"</script>';
}
// jika validasi type file terpenuhi
else {

    // echo '<script>alert("hey");
    // </script>';
    //Tulis query database disini
    // echo "Good! Input type file sesuai ketentuan ekstensi. Silahkan lanjut query database nya ...<br>";

    //upload file xlss
    $target = basename($_FILES['fileklasifikasi']['name']);

    move_uploaded_file($_FILES['fileklasifikasi']['tmp_name'], $target);

    // beri permisi agar file xls dapat di baca
    chmod($_FILES['fileklasifikasi']['name'], 0777);

    mysqli_query($koneksi->konek(), "TRUNCATE TABLE klasifikasi");

    // mengambil isi file xls
    $data = new Spreadsheet_Excel_Reader($_FILES['fileklasifikasi']['name'], false);
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
        $prediksi  = '';

        $query = "INSERT into klasifikasi values('','$nama','$tahun','$instansi','$jenispinjaman','$simpanan','$pinjaman','$jasa','$lamaangsur','$prediksi')";
        if (!mysqli_query($koneksi->konek(), $query)) {
            die(mysqli_error($koneksi->konek()));
        } else {
            echo '<script>document.body.innerHTML = "";alert("Import Data Berhasil Ditambahkan !!!");
window.location.href="../../index.php?page=klasifikasi"</script>';
        }

        mysqli_query(
            $koneksi->konek(),
            "UPDATE klasifikasi 
            SET prediksi = CASE
            WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'NIAGA' THEN 'Lancar'
            WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'KMS' AND simpanan > 10000000 THEN 'Lancar'
            WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'KMS' AND simpanan <= 10000000 AND jasa > 200000 THEN 'Lancar'
            ELSE 'Macet'
            END"
        );
    }

    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['fileklasifikasi']['name']);
}
