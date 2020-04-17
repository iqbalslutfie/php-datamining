<?php
session_start();
include_once '../config/koneksi.php';
$sess_admin = $_SESSION['idakun'];
if (isset($sess_admin)) {
    session_destroy();
    echo '<script>alert("Anda Telah Logout !!!");
    window.location.href="login.php"</script>';
}
