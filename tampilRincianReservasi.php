<?php

include_once 'config.php';



$kode_pemesanan= isset($_GET['kode_pemesanan']) ? $_GET['kode_pemesanan'] : null;


$tsql = "SELECT tc.cabang,tp.jenis_pemesanan,tp.tanggal,tp.jml_dewasa,tp.jml_anak,tp.tanggal_masuk,tp.tanggal_keluar,tp.permintaan_khusus,tp.status
        FROM tbl_pemesanan tp join tbl_cabang tc on (tp.kode_cabang = tc.kode_cabang)
        WHERE tp.kode_pemesanan ='$kode_pemesanan'";

$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      
        // connection node
      $response["dataRincian"] = array();

      while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
            $dataRincian = array(); // Your return array
            //$dataRincian["kode_pemesanan"] = $row["kode_pemesanan"];
            $dataRincian["cabang"] = $row["cabang"];
            $dataRincian["jenis_pemesanan"] = $row["jenis_pemesanan"];
        	$dataRincian["tanggal"] = $row["tanggal"];
            $dataRincian["jml_dewasa"] = $row["jml_dewasa"];
            $dataRincian["jml_anak"] = $row["jml_anak"];
            $dataRincian["tanggal_masuk"] = $row["tanggal_masuk"];
            $dataRincian["tanggal_keluar"] = $row["tanggal_keluar"];
            $dataRincian["permintaan_khusus"] = $row["permintaan_khusus"];
            $dataRincian["status"] = $row["status"];
            // pushes a new row onto your array with each iteration
            array_push($response["dataRincian"], $dataRincian);
        }

      	echo json_encode($response);
} else {
    echo 'failure'; //Empty result
}
 
?>