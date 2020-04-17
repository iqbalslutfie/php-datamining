<?php

// $koneksi = mysqli_connect("localhost", "root", "", "kpc");

// // Check connection
// if (mysqli_connect_errno()) {
//     echo "Koneksi database gagal : " . mysqli_connect_error();
// }

class koneksi
{
    var $host = "localhost";
    var $username = "root";
    var $password = "";
    var $database = "kpcbaru";

    function __construct()
    {
        mysqli_connect($this->host, $this->username, $this->password, $this->database);
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Koneksi database gagal : " . mysqli_connect_error();
        }
    }

    public function konek()
    {
        return mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }
}
