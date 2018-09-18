<?php

include_once 'config.php';



$kode_pemesanan= isset($_GET['kode_pemesanan']) ? $_GET['kode_pemesanan'] : null;



$tsql = "SELECT tj.jenis,tr.jumlah,tr.harga
        FROM tbl_rincianPemesanan tr join tbl_jenis tj on (tr.kode_jenis = tj.kode_jenis)
        WHERE kode_pemesanan='$kode_pemesanan'";

$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      
        // connection node
      $response["dataRincianKamar"] = array();

      while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
            $dataRincianKamar = array(); // Your return array
            $dataRincianKamar["jenis"] = $row["jenis"];
            $dataRincianKamar["jumlah"] = $row["jumlah"];
            $dataRincianKamar["harga"] = $row["harga"];
            // pushes a new row onto your array with each iteration
            array_push($response["dataRincianKamar"], $dataRincianKamar);
        }

      	echo json_encode($response);
} else {
    echo 'failure'; //Empty result
}
 
?>