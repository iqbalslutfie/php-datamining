<?php
include_once "../config/koneksi.php";
$koneksi = new koneksi();

$namapengguna = mysqli_real_escape_string($koneksi->konek(), htmlentities($_POST['namapengguna']));
$katasandi = mysqli_real_escape_string($koneksi->konek(), htmlentities($_POST['katasandi']));
$check    = mysqli_query($koneksi->konek(), "SELECT * FROM akun WHERE username = '$namapengguna' AND password = '$katasandi'") or die(mysqli_error($koneksi));
if (mysqli_num_rows($check) >= 1) {
    while ($row = mysqli_fetch_array($check)) {
        session_start();
        $_SESSION['idakun'] = $row['idakun'];
?>
        <script>
            alert("Selamat Datang <?= $row['nama']; ?> Kamu Telah Login Ke Halaman Admin !!!");
            window.location.href = "../index.php"
        </script>
<?php
    }
} else {
    echo '<script>alert("Masukan Username dan Password dengan Benar !!!");
window.location.href="login.php"</script>';
}
?>