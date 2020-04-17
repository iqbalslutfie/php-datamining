<?php
if (isset($_GET['page'])) {
  $page = $_GET['page'];
  switch ($page) {
      // Beranda
    case 'data_nasabah':
      include 'pages/nasabah/data_nasabah.php';
      break;
    case 'tambah_nasabah':
      include 'pages/nasabah/tambah_nasabah.php';
      break;
    case 'ubah_nasabah';
      include 'pages/nasabah/ubah_nasabah.php';
      break;

    case 'data_latih':
      include 'pages/latih/data_latih.php';
      break;
    case 'tambah_latih':
      include 'pages/latih/tambah_latih.php';
      break;
    case 'ubah_latih';
      include 'pages/latih/ubah_latih.php';
      break;
    case 'import_latih';
      include 'pages/latih/import_latih.php';
      break;
      // case 'import_latih_proses';
      //   include 'pages/latih/import_latih_proses.php';
      //   break;
    case 'bersihkan_latih';
      include 'pages/latih/bersihkan_latih.php';
      break;

    case 'data_mining';
      include 'pages/mining/data_mining.php';
      break;
    case 'mining';
      include 'pages/mining/mining.php';
      break;
    case 'proses_mining';
      include 'pages/mining/proses_mining.php';
      break;
    case 'pohon_keputusan';
      include 'pages/mining/pohon_keputusan.php';
      break;
    case 'melakukan_mining';
      include 'pages/mining/melakukan_mining.php';
      break;

    case 'klasifikasi';
      include 'pages/keputusan/keputusan.php';
      break;
    case 'import_klasifikasi':
      include 'pages/keputusan/import_klasifikasi.php';
      break;
    case 'ubah_keputusan';
      include 'pages/keputusan/ubah_keputusan.php';
      break;

    case 'laporan';
      include 'pages/laporan/laporan.php';
      break;
  }
} else {
  include "pages/beranda.php";
}
