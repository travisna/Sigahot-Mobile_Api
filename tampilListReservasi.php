<?php

include_once 'config.php';


$email = isset($_GET['email']) ? $_GET['email'] : null;
$status= isset($_GET['status_reservasi']) ? $_GET['status_reservasi'] : null;


$tsql = "SELECT tp.kode_pemesanan,tc.cabang,tp.tanggal_masuk,tp.tanggal_keluar
        FROM tbl_pelanggan te JOIN tbl_pemesanan tp on (te.id_pelanggan = tp.id_pelanggan)
        JOIN tbl_cabang tc on (tp.kode_cabang = tc.kode_cabang)
        WHERE tp.status in($status) and te.email= '$email'";

$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      
        // connection node
      $response["dataList"] = array();

      while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
            $dataList = array(); // Your return array
            $dataList["kode_pemesanan"] = $row["kode_pemesanan"];
            $dataList["cabang"] = $row["cabang"];
            $dataList["tanggal_masuk"] = $row["tanggal_masuk"];
            $dataList["tanggal_keluar"] = $row["tanggal_keluar"];

            // pushes a new row onto your array with each iteration
            array_push($response["dataList"], $dataList);
        }

      	echo json_encode($response);
} else {
    echo 'failure'; //Empty result
}
 
?>