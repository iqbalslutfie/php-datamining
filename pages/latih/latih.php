<?php

class latih
{
    protected $kon;
    function __construct()
    {
        //memanggil class koneksi
        $this->kon = new koneksi();
    }

    public function banyakData()
    {
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();

        $data = "SELECT * FROM pinjaman";
        $query = mysqli_query($koneksi, $data);
        $banyakdata = mysqli_num_rows($query);

        return $banyakdata;
    }

    function batasData()
    {
        $limit = 25;
        return $limit;
    }

    function banyakHalaman()
    {
        $halaman = ceil($this->banyakData() / $this->batasData());
        return $halaman;
    }
    function tampilData($hal)
    {
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $tampil = [];
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();
        $limit = $this->batasData();
        $mulai = ($hal > 1) ? ($hal * $limit) - $limit : 0;
        $query = "SELECT * FROM pinjaman ORDER BY idpinjaman ASC LIMIT $mulai,$limit";
        $result = mysqli_query($koneksi, $query);

        while ($d = mysqli_fetch_array($result)) {
            $tampil[] = $d;
        }

        return $tampil;
    }

    function mulaiNomor($hal, $limit)
    {
        $mulai = ($hal > 1) ? ($hal * $limit) - $limit : 0;

        return $mulai;
    }

    function rupiah($angka)
    {
        if ($angka != "-" or trim($angka)) {
            $hasil_rupiah = number_format((int) $angka, 0, ',', '.');
        } else if (trim($angka)) {
            $hasil_rupiah = trim($angka);
        }
        return $hasil_rupiah;
    }

    function halSebelumnya($hal)
    {
        if (($hal - 1) >= 1) {
            $sebelumnya = $hal - 1;
        }

        return $sebelumnya;
    }

    function halSelanjutnya($hal, $halaman)
    {
        if (($hal + 1) <= $halaman) {
            $selanjutnya = $hal + 1;
        }

        return $selanjutnya;
    }
}
