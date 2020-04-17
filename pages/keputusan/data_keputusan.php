<?php

class keputusan
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

        $data = "SELECT * FROM klasifikasi";
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
        $query = "SELECT * FROM klasifikasi ORDER BY idpinjaman ASC LIMIT $mulai,$limit";
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

    // function getAturan()
    // {

    //     // ini ubah ke string
    //     // $koneksi = $this->kon->konek();
    //     // $query = ("SELECT GROUP_CONCAT(kondisi_atribut) AS kondisi from pohon_keputusan_c45 WHERE keputusan = 'Lancar'");
    //     // $result = mysqli_query($koneksi, $query);
    //     // $result2 = mysqli_fetch_assoc($result);
    //     // $resultstring = $result2['kondisi'];
    //     // echo str_replace('~', '', $resultstring);

    //     //ini ubah ke array
    //     $koneksi = $this->kon->konek();
    //     $query = ("SELECT DISTINCT kondisi_atribut from pohon_keputusan_c45 WHERE keputusan = 'Lancar'");
    //     $result = mysqli_query($koneksi, $query);

    //     while ($d = mysqli_fetch_array($result)) {
    //         $d = str_replace('~', '', $d);
    //         $d = str_replace('= <=', '<= ', $d);
    //         $d = str_replace('= >', '> ', $d);
    //         $d = str_replace('NIAGA', "'NIAGA' ", $d);
    //         $d = str_replace('KMS', "'KMS' ", $d);
    //         $d = substr_replace($d, "", 0, 4);
    //         $tampil[] = $d;
    //     }

    //     return $tampil;
    // }

    // function menentukanLancarMacet()
    // {
    //     $koneksi = $this->kon->konek();
    //     mysqli_query(
    //         $koneksi,
    //         "INSERT INTO klasifikasi (idpinjaman, nama, tahun, instansi,jenispinjaman,simpanan,pinjaman,jasa,lamaangsur,status)  
    //         SELECT idpinjaman, nama, tahun, instansi,jenispinjaman,simpanan,pinjaman,jasa,lamaangsur,status
    //           FROM pinjaman"
    //     );

    //     mysqli_query(
    //         $koneksi,
    //         "UPDATE klasifikasi 
    //         SET prediksi = CASE
    //         WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'NIAGA' THEN 'Lancar'
    //         WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'KMS' AND simpanan > 10000000 THEN 'Lancar'
    //         WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'KMS' AND simpanan <= 10000000 AND jasa > 200000 THEN 'Lancar'
    //         ELSE 'Macet'
    //         END"
    //     );
    // }

    function bersihkanData()
    {
        $koneksi = $this->kon->konek();
        mysqli_query(
            $koneksi,
            "TRUNCATE TABLE klasifikasi"
        );
    }
}
