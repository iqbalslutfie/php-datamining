<?php

class mining
{
    protected $kon;
    function __construct()
    {
        //memanggil class koneksi
        $this->kon = new koneksi();
    }

    function menentukanLancarMacet()
    {
        $koneksi = $this->kon->konek();
        mysqli_query(
            $koneksi,
            "INSERT INTO klasifikasi (idpinjaman, nama, tahun, instansi,jenispinjaman,simpanan,pinjaman,jasa,lamaangsur,status)  
            SELECT idpinjaman, nama, tahun, instansi,jenispinjaman,simpanan,pinjaman,jasa,lamaangsur,status
              FROM pinjaman"
        );

        mysqli_query(
            $koneksi,
            "UPDATE klasifikasi 
            SET prediksi = CASE
            WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'NIAGA' THEN 'Lancar'
            WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'KMS' AND simpanan > 10000000 THEN 'Lancar'
            WHEN lamaangsur <= 20 AND pinjaman <= 10000000 AND jenispinjaman = 'KMS' AND simpanan <= 10000000 AND jasa > 200000 THEN 'Lancar'
            ELSE 'Macet'
            END"
        );
    }

    function seleksi()
    {
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();

        mysqli_query($koneksi, "TRUNCATE TABLE seleksi");
        mysqli_query($koneksi, "INSERT INTO seleksi SELECT idpinjaman,instansi,jenispinjaman,simpanan,pinjaman,jasa,lamaangsur,status FROM pinjaman ORDER BY idpinjaman ASC");
    }

    function pembersihan()
    {;
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();

        //echo "<center>" . join(", ", $this->hasilOutlier($this->getArrayLamaAngsur())) . "</center>";

        // print_r($this->getArraySimpanan());

        mysqli_query($koneksi, "TRUNCATE TABLE pembersihan");

        mysqli_query($koneksi, "INSERT INTO pembersihan SELECT * FROM seleksi WHERE NOT (simpanan = '-' or pinjaman = '-' or lamaangsur ='-' or simpanan = '' or pinjaman = '' or lamaangsur ='' or jasa = '' or jasa ='-' or jasa is null or simpanan is null or pinjaman is null or lamaangsur is null)"); // AND simpanan NOT IN " . $outlierSimpanan . " AND pinjaman NOT IN " . $outlierPinjaman . " AND lamaangsur NOT IN" . $outlierLamaAngsur . " ))");
    }

    function miningC45($atribut, $nilai_atribut)
    {
        // echo "<center>" . $this->median($this->getArraySimpanan(), 0, count($this->getArraySimpanan()));
        // // echo "<center>" . $this->Q1($this->getArraySimpanan(), count($this->getArraySimpanan()));
        // $Q1 = $this->Q1($this->getARrayPinjaman(), count($this->getARrayPinjaman()));
        // $Q3 = $this->Q3($this->getARrayPinjaman(), count($this->getARrayPinjaman()));
        // // echo "<center>" . $this->IQR($Q3, $Q1);
        // echo "<center>" . $Q1;
        // echo "<center>" . $Q3;
        // echo "<center>" . $this->median($this->getArraySimpanan(), 0, count($this->getArraySimpanan()));
        // echo $this->populateArrayAtribut();
        $this->seleksi();
        $this->pembersihan();
        $this->perhitunganC45($atribut, $nilai_atribut);
        $this->insertAtributPohonKeputusan($atribut, $nilai_atribut);
        $this->getInfGainMax($atribut, $nilai_atribut);
        $this->replaceNull();
    }

    //#1# Hapus semua DB dan insert default atribut dan nilai atribut
    function populateDb()
    { //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();
        // mysqli_query($koneksi, "TRUNCATE TABLE pembersihan");
        mysqli_query($koneksi, "TRUNCATE TABLE mining_c45");
        // mysqli_query($koneksi, "TRUNCATE TABLE iterasi_c45");
        // mysqli_query($koneksi, "TRUNCATE TABLE pohon_keputusan_c45");

        $this->populateAtribut();
        $this->populatePersiapan();
    }

    function populateAtribut()
    {
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();

        mysqli_query($koneksi, "TRUNCATE table atribut");
        mysqli_query($koneksi, "INSERT INTO `atribut` (`id`, `atribut`, `nilai_atribut`) VALUES
        -- (1, 'total', 'total'),
        -- (2, 'jasa', '<=200000'),
        -- (3, 'jasa', '>200000'),
        -- (4, 'jenispinjaman', 'NIAGA'),
        -- (5, 'jenispinjaman', 'KMS'),
        -- (6, 'pinjaman', '<=7250000'),
        -- (7, 'pinjaman', '>7250000'),
	    -- (8, 'lamaangsur', '<=20'),
	    -- (9, 'lamaangsur', '>20'),
        -- (10, 'simpanan', '<=8900000'),
        -- (11, 'simpanan', '>8900000')
        
        (1, 'total', 'total'),
        (2, 'jasa', '<=200000'),
        (3, 'jasa', '>200000'),
        (4, 'jenispinjaman', 'NIAGA'),
        (5, 'jenispinjaman', 'KMS'),
        (6, 'pinjaman', '<=10000000'),
        (7, 'pinjaman', '>10000000'),
	    (8, 'lamaangsur', '<=20'),
	    (9, 'lamaangsur', '>20'),
        (10, 'simpanan', '<=10000000'),
        (11, 'simpanan', '>10000000')
    
        ");
    }

    // function populateArrayAtribut()
    // {
    //     $arrayAtribut = [
    //         array('1', 'total', 'total'),
    //         array('2', 'jasa', '<=200000'),
    //         array('3', 'jasa', '>200000'),
    //         array('4', 'jenispinjaman', 'NIAGA'),
    //         array('5', 'jenispinjaman', 'KMS'),
    //         array('6', 'pinjaman', '<=10000000'),
    //         array('7', 'pinjaman', '>10000000'),
    //         array('8', 'lamaangsur', '<=20'),
    //         array('9', 'lamaangsur', '>20'),
    //         array('10', 'simpanan', '<=10000000'),
    //         array('11', 'simpanan', '>10000000')
    //     ];

    //     return $arrayAtribut;
    // }

    function populatePersiapan()
    {
        $koneksi = $this->kon->konek();

        mysqli_query($koneksi, "TRUNCATE TABLE persiapan");
        mysqli_query($koneksi, "INSERT INTO persiapan SELECT * FROM pembersihan");
        // mysqli_query($koneksi, "UPDATE persiapan SET pinjaman = '<=7250000' WHERE pinjaman <= 7250000");
        // mysqli_query($koneksi, "UPDATE persiapan SET pinjaman = '>7250000' WHERE pinjaman > 7250000");
        // mysqli_query($koneksi, "UPDATE persiapan SET simpanan = '<=8900000' WHERE simpanan <= 8900000");
        // mysqli_query($koneksi, "UPDATE persiapan SET simpanan = '>8900000' WHERE simpanan > 8900000");
        // mysqli_query($koneksi, "UPDATE persiapan SET lamaangsur = '<=20' WHERE lamaangsur <= 20");
        // mysqli_query($koneksi, "UPDATE persiapan SET lamaangsur = '>20' WHERE lamaangsur > 20");
        // mysqli_query($koneksi, "UPDATE persiapan SET jasa = '<=200000' WHERE jasa <= 200000");
        // mysqli_query($koneksi, "UPDATE persiapan SET jasa = '>200000' WHERE jasa > 200000");

        mysqli_query($koneksi, "UPDATE persiapan SET pinjaman = '<=10000000' WHERE pinjaman <= 10000000");
        mysqli_query($koneksi, "UPDATE persiapan SET pinjaman = '>10000000' WHERE pinjaman > 10000000");
        mysqli_query($koneksi, "UPDATE persiapan SET simpanan = '<=10000000' WHERE simpanan <= 10000000");
        mysqli_query($koneksi, "UPDATE persiapan SET simpanan = '>10000000' WHERE simpanan > 10000000");
        mysqli_query($koneksi, "UPDATE persiapan SET lamaangsur = '<=20' WHERE lamaangsur <= 20");
        mysqli_query($koneksi, "UPDATE persiapan SET lamaangsur = '>20' WHERE lamaangsur > 20");
        mysqli_query($koneksi, "UPDATE persiapan SET jasa = '<=200000' WHERE jasa <= 200000");
        mysqli_query($koneksi, "UPDATE persiapan SET jasa = '>200000' WHERE jasa > 200000");
    }

    function perhitunganC45($atribut, $nilai_atribut)
    {
        $koneksi = $this->kon->konek();

        if (empty($atribut) and empty($nilai_atribut)) {
            //#2# Jika atribut yg diinputkan kosong, maka lakukan perhitungan awal
            $kondisiAtribut = ""; // set kondisi atribut kosong
        } else if (!empty($atribut) and !empty($nilai_atribut)) {
            // jika atribut tdk kosong, maka select kondisi atribut dari DB
            $sqlKondisiAtribut = mysqli_query($koneksi, "SELECT kondisi_atribut FROM pohon_keputusan_c45 WHERE atribut = '$atribut' AND nilai_atribut = '$nilai_atribut' order by id DESC LIMIT 1");
            $rowKondisiAtribut = mysqli_fetch_array($sqlKondisiAtribut);
            $kondisiAtribut = str_replace("~", "'", $rowKondisiAtribut['kondisi_atribut']); // replace string ~ menjadi '
        }

        // ambil seluruh atribut
        $sqlAtribut = mysqli_query($koneksi, "SELECT distinct atribut FROM atribut");
        while ($rowGetAtribut = mysqli_fetch_array($sqlAtribut)) {
            $getAtribut = $rowGetAtribut['atribut'];
            if ($getAtribut === 'total') {
                //#3# Jika atribut = total, maka hitung jumlah kasus total, jumlah kasus Lancar dan jumlah kasus tdk Lancar
                // hitung jumlah kasus total
                $sqlJumlahKasusTotal = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_total FROM persiapan WHERE status is not null $kondisiAtribut");
                $rowJumlahKasusTotal = mysqli_fetch_array($sqlJumlahKasusTotal);
                $getJumlahKasusTotal = $rowJumlahKasusTotal['jumlah_total'];
                // echo $getJumlahKasusTotal

                // hitung jumlah kasus Lancar
                $sqlJumlahKasusLancar = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_lancar FROM persiapan WHERE status = 'Lancar' AND status is not null $kondisiAtribut");
                $rowJumlahKasusLancar = mysqli_fetch_array($sqlJumlahKasusLancar);
                $getJumlahKasusLancar = $rowJumlahKasusLancar['jumlah_lancar'];

                // hitung jumlah kasus tdk Lancar
                $sqlJumlahKasusMacet = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_macet FROM persiapan WHERE status = 'Macet' AND status is not null $kondisiAtribut");
                $rowJumlahKasusMacet = mysqli_fetch_array($sqlJumlahKasusMacet);
                $getJumlahKasusMacet = $rowJumlahKasusMacet['jumlah_macet'];

                //#4# Insert jumlah kasus total, jumlah kasus Lancar dan jumlah kasus tdk Lancar ke DB
                // insert ke database mining_c45
                mysqli_query($koneksi, "INSERT INTO mining_c45 VALUES ('', 'Total', 'Total', '$getJumlahKasusTotal', '$getJumlahKasusLancar', '$getJumlahKasusMacet', '', '', '', '', '', '')");
            } else {
                //#5# Jika atribut != total (atribut lainnya), maka hitung jumlah kasus total, jumlah kasus Lancar dan jumlah kasus tdk Lancar masing2 atribut
                // ambil nilai atribut
                $sqlNilaiAtribut = mysqli_query($koneksi, "SELECT nilai_atribut FROM atribut WHERE atribut = '$getAtribut' ORDER BY id");
                while ($rowNilaiAtribut = mysqli_fetch_array($sqlNilaiAtribut)) {
                    $getNilaiAtribut = $rowNilaiAtribut['nilai_atribut'];

                    // set kondisi dimana nilai_atribut = berdasakan masing2 atribut dan status data = data training
                    // if ($getAtribut == 'simpanan' and $getAtribut == 'pinjaman' and $getAtribut == 'lamaangsur') {
                    //     //
                    //     $kondisi = $getAtribut . ' $getNilaiAtribut' . "AND status is not null" . $kondisiAtribut;
                    // } else {
                    //     $kondisi = "$getAtribut = '$getNilaiAtribut' AND status is not null $kondisiAtribut";
                    // }

                    $kondisi = "$getAtribut = '$getNilaiAtribut' AND status is not null $kondisiAtribut";

                    // hitung jumlah kasus per atribut
                    $sqlJumlahKasusTotalAtribut = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_total FROM persiapan WHERE $kondisi");
                    $rowJumlahKasusTotalAtribut = mysqli_fetch_array($sqlJumlahKasusTotalAtribut);
                    $getJumlahKasusTotalAtribut = $rowJumlahKasusTotalAtribut['jumlah_total'];
                    // echo $getJumlahKasusTotalAtribut;

                    // hitung jumlah kasus Lancar
                    $sqlJumlahKasusLancarAtribut = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_lancar FROM persiapan WHERE $kondisi AND status = 'Lancar'");
                    $rowJumlahKasusLancarAtribut = mysqli_fetch_array($sqlJumlahKasusLancarAtribut);
                    $getJumlahKasusLancarAtribut = $rowJumlahKasusLancarAtribut['jumlah_lancar'];

                    // hitung jumlah kasus TDK Lancar
                    $sqlJumlahKasusMacetAtribut = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_macet FROM persiapan WHERE $kondisi AND status = 'Macet'");
                    $rowJumlahKasusMacetAtribut = mysqli_fetch_array($sqlJumlahKasusMacetAtribut);
                    $getJumlahKasusMacetAtribut = $rowJumlahKasusMacetAtribut['jumlah_macet'];

                    //#6# Insert jumlah kasus total, jumlah kasus Lancar dan jumlah kasus tdk Lancar masing2 atribut ke DB
                    // insert ke database mining_c45
                    mysqli_query($koneksi, "INSERT INTO mining_c45 VALUES ('', '$getAtribut', '$getNilaiAtribut', '$getJumlahKasusTotalAtribut', '$getJumlahKasusLancarAtribut', '$getJumlahKasusMacetAtribut', '', '', '', '', '', '')");

                    //#7# Lakukan perhitungan entropy
                    // perhitungan entropy
                    $sqlEntropy = mysqli_query($koneksi, "SELECT id, jml_kasus_total, jml_lancar, jml_macet FROM mining_c45");
                    while ($rowEntropy = mysqli_fetch_array($sqlEntropy)) {
                        $getJumlahKasusTotalEntropy = $rowEntropy['jml_kasus_total'];
                        $getJumlahKasusLancarEntropy = $rowEntropy['jml_lancar'];
                        $getJumlahKasusMacetEntropy = $rowEntropy['jml_macet'];
                        $idEntropy = $rowEntropy['id'];

                        // jika jml kasus = 0 maka entropy = 0
                        if ($getJumlahKasusTotalEntropy == 0 or $getJumlahKasusLancarEntropy == 0 or $getJumlahKasusMacetEntropy == 0) {
                            $getEntropy = 0;
                            // jika jml kasus Lancar = jml kasus tdk Lancar, maka entropy = 1
                        } else if ($getJumlahKasusLancarEntropy == $getJumlahKasusMacetEntropy) {
                            $getEntropy = 1;
                        } else { // jika jml kasus != 0, maka hitung rumus entropy:
                            $perbandingan_Lancar = $getJumlahKasusLancarEntropy / $getJumlahKasusTotalEntropy;
                            $perbandingan_Macet = $getJumlahKasusMacetEntropy / $getJumlahKasusTotalEntropy;

                            $rumusEntropy = (- ($perbandingan_Lancar) * log($perbandingan_Lancar, 2)) + (- ($perbandingan_Macet) * log($perbandingan_Macet, 2));
                            $getEntropy = round($rumusEntropy, 4); // 4 angka di belakang koma
                        }

                        //#8# Update nilai entropy
                        // update nilai entropy
                        mysqli_query($koneksi, "UPDATE mining_c45 SET entropy = $getEntropy WHERE id = $idEntropy");
                    }

                    //#9# Lakukan perhitungan information gain
                    // perhitungan information gain
                    // ambil nilai entropy dari total (jumlah kasus total)
                    $sqlJumlahKasusTotalInfGain = mysqli_query($koneksi, "SELECT jml_kasus_total, entropy FROM mining_c45 WHERE atribut = 'Total'");
                    $rowJumlahKasusTotalInfGain = mysqli_fetch_array($sqlJumlahKasusTotalInfGain);
                    $getJumlahKasusTotalInfGain = $rowJumlahKasusTotalInfGain['jml_kasus_total'];
                    // rumus information gain
                    $getInfGain = (- (($getJumlahKasusTotalEntropy / $getJumlahKasusTotalInfGain) * ($getEntropy)));

                    //#10# Update information gain tiap nilai atribut (temporary)
                    // update inf_gain_temp (utk mencari nilai masing2 atribut)
                    mysqli_query($koneksi, "UPDATE mining_c45 SET inf_gain_temp = $getInfGain WHERE id = $idEntropy");
                    $getEntropy = $rowJumlahKasusTotalInfGain['entropy'];

                    // jumlahkan masing2 inf_gain_temp atribut 
                    $sqlAtributInfGain = mysqli_query($koneksi, "SELECT SUM(inf_gain_temp) as inf_gain FROM mining_c45 WHERE atribut = '$getAtribut'");
                    while ($rowAtributInfGain = mysqli_fetch_array($sqlAtributInfGain)) {
                        $getAtributInfGain = $rowAtributInfGain['inf_gain'];

                        // hitung inf gain
                        $getInfGainFix = round(($getEntropy + $getAtributInfGain), 4);

                        //#11# Looping perhitungan information gain, sehingga mendapatkan information gain tiap atribut. Update information gain
                        // update inf_gain (fix)
                        mysqli_query($koneksi, "UPDATE mining_c45 SET inf_gain = $getInfGainFix WHERE atribut = '$getAtribut'");
                    }

                    //#12# Lakukan perhitungan split info
                    // rumus split info
                    $getSplitInfo = (($getJumlahKasusTotalEntropy / $getJumlahKasusTotalInfGain) * (log(($getJumlahKasusTotalEntropy / $getJumlahKasusTotalInfGain), 2)));

                    //#13# Update split info tiap nilai atribut (temporary)
                    // update split_info_temp (utk mencari nilai masing2 atribut)
                    mysqli_query($koneksi, "UPDATE mining_c45 SET split_info_temp = $getSplitInfo WHERE id = $idEntropy");

                    // jumlahkan masing2 split_info_temp dari tiap atribut 
                    $sqlAtributSplitInfo = mysqli_query($koneksi, "SELECT SUM(split_info_temp) as split_info FROM mining_c45 WHERE atribut = '$getAtribut'");
                    while ($rowAtributSplitInfo = mysqli_fetch_array($sqlAtributSplitInfo)) {
                        $getAtributSplitInfo = $rowAtributSplitInfo['split_info'];

                        // split info fix (4 angka di belakang koma)
                        $getSplitInfoFix = - (round($getAtributSplitInfo, 4));

                        //#14# Looping perhitungan split info, sehingga mendapatkan information gain tiap atribut. Update information gain
                        // update split info (fix)
                        mysqli_query($koneksi, "UPDATE mining_c45 SET split_info = $getSplitInfoFix WHERE atribut = '$getAtribut'");
                    }
                }

                //#15# Lakukan perhitungan gain ratio
                $sqlGainRatio = mysqli_query($koneksi, "SELECT id, inf_gain, split_info FROM mining_c45");
                while ($rowGainRatio = mysqli_fetch_array($sqlGainRatio)) {
                    $idGainRatio = $rowGainRatio['id'];
                    // jika nilai inf gain == 0 dan split info == 0, maka gain ratio = 0
                    if (($rowGainRatio['inf_gain'] == 0 or $rowGainRatio['inf_gain'] == '') and ($rowGainRatio['split_info'] == 0 or $rowGainRatio['split_info'] == '')) {
                        $getGainRatio = 0;
                    } else {
                        // rumus gain ratio
                        $getGainRatio = round(($rowGainRatio['inf_gain'] / $rowGainRatio['split_info']), 4);
                    }

                    //#16# Update gain ratio dari setiap atribut
                    mysqli_query($koneksi, "UPDATE mining_c45 SET gain_ratio = $getGainRatio WHERE id = '$idGainRatio'");
                }
            }
        }
    }

    //#17# Insert atribut dgn information gain max ke DB pohon keputusan
    function insertAtributPohonKeputusan($atribut, $nilai_atribut)
    {
        $koneksi = $this->kon->konek();
        // ambil nilai inf gain tertinggi dimana hanya 1 atribut saja yg dipilih
        $sqlInfGainMaxTemp = mysqli_query($koneksi, "SELECT distinct atribut, gain_ratio FROM mining_c45 WHERE gain_ratio in (SELECT max(gain_ratio) FROM `mining_c45`) LIMIT 1");
        $rowInfGainMaxTemp = mysqli_fetch_array($sqlInfGainMaxTemp);
        // hanya ambil atribut dimana jumlah kasus totalnya tidak kosong
        if ($rowInfGainMaxTemp['gain_ratio'] > 0) {
            // ambil nilai atribut yang memiliki nilai inf gain max
            $sqlInfGainMax = mysqli_query($koneksi, "SELECT * FROM mining_c45 WHERE atribut = '$rowInfGainMaxTemp[atribut]'");
            while ($rowInfGainMax = mysqli_fetch_array($sqlInfGainMax)) {
                if ($rowInfGainMax['jml_lancar'] == 0 and $rowInfGainMax['jml_macet'] == 0) {
                    $keputusan = 'Kosong'; // jika jml_lancar = 0 dan jml_macet = 0, maka keputusan Null
                } else if ($rowInfGainMax['jml_lancar'] !== 0 and $rowInfGainMax['jml_macet'] == 0) {
                    $keputusan = 'Lancar'; // jika jml_lancar != 0 dan jml_macet = 0, maka keputusan Lancar
                } else if ($rowInfGainMax['jml_lancar'] == 0 and $rowInfGainMax['jml_macet'] !== 0) {
                    $keputusan = 'Macet'; // jika jml_lancar = 0 dan jml_macet != 0, maka keputusan Tidak Lancar
                } else {
                    $keputusan = '?'; // jika jml_lancar != 0 dan jml_macet != 0, maka keputusan ?
                }

                if (empty($atribut) and empty($nilai_atribut)) {
                    //#18# Jika atribut yang diinput kosong (atribut awal) maka insert ke pohon keputusan id_parent = 0
                    // set kondisi atribut = AND atribut = nilai atribut
                    $kondisiAtribut = "AND $rowInfGainMax[atribut] = ~$rowInfGainMax[nilai_atribut]~";
                    // insert ke tabel pohon keputusan
                    mysqli_query($koneksi, "INSERT INTO pohon_keputusan_c45 VALUES ('', '$rowInfGainMax[atribut]', '$rowInfGainMax[nilai_atribut]', 0, '$rowInfGainMax[jml_lancar]', '$rowInfGainMax[jml_macet]', '$keputusan', 'Belum', '$kondisiAtribut', 'Belum')");
                }

                //#19# Jika atribut yang diinput tidak kosong maka insert ke pohon keputusan dimana id_parent diambil dari tabel pohon keputusan sebelumnya (where atribut = atribut yang diinput)
                else if (!empty($atribut) and !empty($nilai_atribut)) {
                    $perhitunganPessimisticChildIncrement = 0;
                    $sqlIdParent = mysqli_query($koneksi, "SELECT id, atribut, nilai_atribut, jml_lancar, jml_macet FROM pohon_keputusan_c45 WHERE atribut = '$atribut' AND nilai_atribut = '$nilai_atribut' order by id DESC LIMIT 1");
                    while ($rowIdParent = mysqli_fetch_array($sqlIdParent)) {
                        // insert ke tabel pohon keputusan
                        mysqli_query($koneksi, "INSERT INTO pohon_keputusan_c45 VALUES ('', '$rowInfGainMax[atribut]', '$rowInfGainMax[nilai_atribut]', $rowIdParent[id], '$rowInfGainMax[jml_lancar]', '$rowInfGainMax[jml_macet]', '$keputusan', 'Belum', '', 'Belum')");

                        //#PRE PRUNING (dokumentasi -> http://id3-c45.xp3.biz/dokumentasi/Decision-Tree.10.11.ppt)#
                        // hitung Pessimistic error rate parent dan child 
                        $perhitunganParentPrePruning = $this->loopingPerhitunganPrePruning($rowIdParent['jml_lancar'], $rowIdParent['jml_macet']);
                        $perhitunganChildPrePruning = $this->loopingPerhitunganPrePruning($rowInfGainMax['jml_lancar'], $rowInfGainMax['jml_macet']);

                        // hitung average Pessimistic error rate child 
                        $perhitunganPessimisticChild = (($rowInfGainMax['jml_lancar'] + $rowInfGainMax['jml_macet']) / ($rowIdParent['jml_lancar'] + $rowIdParent['jml_macet'])) * $perhitunganChildPrePruning;
                        // Increment average Pessimistic error rate child
                        $perhitunganPessimisticChildIncrement += $perhitunganPessimisticChild;
                        $perhitunganPessimisticChildIncrement = round($perhitunganPessimisticChildIncrement, 4);

                        // jika error rate pada child lebih besar dari error rate parent
                        if ($perhitunganPessimisticChildIncrement > $perhitunganParentPrePruning) {
                            // hapus child (child tidak diinginkan)
                            mysqli_query($koneksi, "DELETE FROM pohon_keputusan_c45 WHERE id_parent = $rowIdParent[id]");

                            // jika jml kasus Lancar lbh besar, maka keputusan == Lancar
                            if ($rowIdParent['jml_lancar'] > $rowIdParent['jml_macet']) {
                                $keputusanPrePruning = 'Lancar';
                                // jika jml tdk kasus Lancar lbh besar, maka keputusan == tdk Lancar
                            } else if ($rowIdParent['jml_lancar'] < $rowIdParent['jml_macet']) {
                                $keputusanPrePruning = 'Macet';
                            }
                            // update keputusan parent
                            mysqli_query($koneksi, "UPDATE pohon_keputusan_c45 SET keputusan = '$keputusanPrePruning' where id = $rowIdParent[id]");
                        }
                    }
                }
            }
        }
        $this->loopingKondisiAtribut();
    }

    //#20# Lakukan looping kondisi atribut untuk diproses pada fungsi perhitunganC45()
    function loopingKondisiAtribut()
    {
        $koneksi = $this->kon->konek();
        // ambil semua id dan kondisi atribut
        $sqlLoopingKondisi = mysqli_query($koneksi, "SELECT id, kondisi_atribut FROM pohon_keputusan_c45");
        while ($rowLoopingKondisi = mysqli_fetch_array($sqlLoopingKondisi)) {
            // select semua data dimana id_parent = id awal
            $sqlUpdateKondisi = mysqli_query($koneksi, "SELECT * FROM pohon_keputusan_c45 WHERE id_parent = $rowLoopingKondisi[id] AND looping_kondisi = 'Belum'");
            while ($rowUpdateKondisi = mysqli_fetch_array($sqlUpdateKondisi)) {
                // set kondisi: kondisi sebelumnya yg diselect berdasarkan id_parent ditambah 'AND atribut = nilai atribut'
                $kondisiAtribut = "$rowLoopingKondisi[kondisi_atribut] AND $rowUpdateKondisi[atribut] = ~$rowUpdateKondisi[nilai_atribut]~";
                // update kondisi atribut
                mysqli_query($koneksi, "UPDATE pohon_keputusan_c45 SET kondisi_atribut = '$kondisiAtribut', looping_kondisi = 'Sudah' WHERE id = $rowUpdateKondisi[id]");
            }
        }
        $this->insertIterasi();
    }

    //#21# Insert iterasi nilai perhitungan ke DB
    function insertIterasi()
    {
        $koneksi = $this->kon->konek();

        $sqlInfGainMaxIterasi = mysqli_query($koneksi, "SELECT distinct atribut, gain_ratio FROM mining_c45 WHERE gain_ratio in (SELECT max(gain_ratio) FROM `mining_c45`) LIMIT 1");
        $rowInfGainMaxIterasi = mysqli_fetch_array($sqlInfGainMaxIterasi);
        // hanya ambil atribut dimana jumlah kasus totalnya tidak kosong
        if ($rowInfGainMaxIterasi['gain_ratio'] > 0) {
            $kondisiAtribut = "$rowInfGainMaxIterasi[atribut]";
            $iterasiKe = 1;
            $sqlInsertIterasiC45 = mysqli_query($koneksi, "SELECT * FROM mining_c45");
            while ($rowInsertIterasiC45 = mysqli_fetch_array($sqlInsertIterasiC45)) {
                // insert ke tabel iterasi
                mysqli_query($koneksi, "INSERT INTO iterasi_c45 VALUES ('', $iterasiKe, '$kondisiAtribut', '$rowInsertIterasiC45[atribut]', '$rowInsertIterasiC45[nilai_atribut]', '$rowInsertIterasiC45[jml_kasus_total]', '$rowInsertIterasiC45[jml_lancar]', '$rowInsertIterasiC45[jml_macet]', '$rowInsertIterasiC45[entropy]', '$rowInsertIterasiC45[inf_gain]', '$rowInsertIterasiC45[split_info]', '$rowInsertIterasiC45[gain_ratio]')");
                $iterasiKe++;
            }
        }
    }

    //#22# Ambil information gain max untuk diproses pada fungsi loopingMiningC45()
    function getInfGainMax($atribut, $nilai_atribut)
    {
        $koneksi = $this->kon->konek();
        // select inf gain max
        $sqlInfGainMaxAtribut = mysqli_query($koneksi, "SELECT distinct atribut FROM mining_c45 WHERE gain_ratio in (SELECT max(gain_ratio) FROM `mining_c45`) LIMIT 1");
        while ($rowInfGainMaxAtribut = mysqli_fetch_array($sqlInfGainMaxAtribut)) {
            $inf_gain_max_atribut = "$rowInfGainMaxAtribut[atribut]";
            if (empty($atribut) and empty($nilai_atribut)) {
                // jika atribut kosong, proses atribut dgn inf gain max pada fungsi loopingMiningC45()
                $this->loopingMiningC45($inf_gain_max_atribut);
            } else if (!empty($atribut) and !empty($nilai_atribut)) {
                // jika atribut tdk kosong, maka update diproses = sudah pada tabel pohon_keputusan_c45
                mysqli_query($koneksi, "UPDATE pohon_keputusan_c45 SET diproses = 'Sudah' WHERE nilai_atribut = '$nilai_atribut'");
                // proses atribut dgn inf gain max pada fungsi loopingMiningC45()
                $this->loopingMiningC45($inf_gain_max_atribut);
            }
        }
    }

    //#23# Looping proses mining dimana atribut dgn information gain max yang akan diproses pada fungsi miningC45()
    function loopingMiningC45($inf_gain_max_atribut)
    {
        $koneksi = $this->kon->konek();
        $sqlBelumAdaKeputusanLagi = mysqli_query($koneksi, "SELECT * FROM pohon_keputusan_c45 WHERE keputusan = '?' and diproses = 'Belum' AND atribut = '$inf_gain_max_atribut'");
        while ($rowBelumAdaKeputusanLagi = mysqli_fetch_array($sqlBelumAdaKeputusanLagi)) {
            if ($rowBelumAdaKeputusanLagi['id_parent'] == 0) {
                $this->populateAtribut();
            }
            $atribut = "$rowBelumAdaKeputusanLagi[atribut]";
            $nilai_atribut = "$rowBelumAdaKeputusanLagi[nilai_atribut]";
            $kondisiAtribut = "AND $atribut = \'$nilai_atribut\'";
            mysqli_query($koneksi, "TRUNCATE mining_c45");
            mysqli_query($koneksi, "DELETE FROM atribut WHERE atribut = '$inf_gain_max_atribut'");
            $this->miningC45($atribut, $nilai_atribut);
            $this->populateAtribut();
        }
    }

    // rumus menghitung Pessimistic error rate
    function perhitunganPrePruning($r, $z, $n)
    {
        $rumus = ($r + (($z * $z) / (2 * $n)) + ($z * (sqrt(($r / $n) - (($r * $r) / $n) + (($z * $z) / (4 * ($n * $n))))))) / (1 + (($z * $z) / $n));
        $rumus = round($rumus, 4);
        return $rumus;
    }

    // looping perhitungan Pessimistic error rate
    function loopingPerhitunganPrePruning($positif, $negatif)
    {
        $z = 1.645; // z = batas kepercayaan (confidence treshold)
        $n = $positif + $negatif; // n = total jml kasus
        $n = round($n, 4);
        // r = perbandingan child thd parent
        if ($positif < $negatif) {
            $r = $positif / ($n);
            $r = round($r, 4);
            return $this->perhitunganPrePruning($r, $z, $n);
        } elseif ($positif > $negatif) {
            $r = $negatif / ($n);
            $r = round($r, 4);
            return $this->perhitunganPrePruning($r, $z, $n);
        } elseif ($positif == $negatif) {
            $r = $negatif / ($n);
            $r = round($r, 4);
            return $this->perhitunganPrePruning($r, $z, $n);
        }
    }

    // replace keputusan jika ada keputusan yg Null
    function replaceNull()
    {
        $koneksi = $this->kon->konek();
        $sqlReplaceNull = mysqli_query($koneksi, "SELECT id, id_parent FROM pohon_keputusan_c45 WHERE keputusan = 'Null'");
        while ($rowReplaceNull = mysqli_fetch_array($sqlReplaceNull)) {
            $sqlReplaceNullIdParent = mysqli_query($koneksi, "SELECT jml_lancar, jml_macet, keputusan FROM pohon_keputusan_c45 WHERE id = $rowReplaceNull[id_parent]");
            $rowReplaceNullIdParent = mysqli_fetch_array($sqlReplaceNullIdParent);
            if ($rowReplaceNullIdParent['jml_lancar'] > $rowReplaceNullIdParent['jml_macet']) {
                $keputusanNull = 'lancar'; // jika jml_lancar != 0 dan jml_macet = 0, maka keputusan Lancar
            } else if ($rowReplaceNullIdParent['jml_lancar'] < $rowReplaceNullIdParent['jml_macet']) {
                $keputusanNull = 'Tidak lancar'; // jika jml_lancar = 0 dan jml_macet != 0, maka keputusan Tidak Lancar
            }
            mysqli_query($koneksi, "UPDATE pohon_keputusan_c45 SET keputusan = '$keputusanNull' WHERE id = $rowReplaceNull[id]");
        }
    }

    function tampilData()
    {
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $tampil = [];
        //melakukan inisiasi method konek di class koneksi ke var koneksi
        $koneksi = $this->kon->konek();
        $query = "SELECT * FROM iterasi_c45";
        $result = mysqli_query($koneksi, $query);

        while ($d = mysqli_fetch_array($result)) {
            $tampil[] = $d;
        }

        return $tampil;
    }
}

// echo "<script>window.alert('Proses Mining Sukses !!!') </script>";
