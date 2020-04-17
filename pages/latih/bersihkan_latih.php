<?php

$banyakdata = mysqli_query($koneksi->konek(), "SELECT * FROM pinjaman");

if (mysqli_num_rows($banyakdata) != 0) {
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE pinjaman");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE iterasi_c45");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE pohon_keputusan_c45");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE mining_c45");
    mysqli_query($koneksi->konek(), "TRUNCATE TABLE klasifikasi");
    echo '<script>alert("Data Berhasil Dibersihkan !!!");
    window.location.href="index.php?page=data_latih"</script>';
} else {
    echo '<script>alert("Data Sudah Kosong !!!");
                window.location.href="index.php?page=data_latih"</script>';
}
