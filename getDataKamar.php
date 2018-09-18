<?php

include_once 'config.php';



$jenisKamar= isset($_GET['jenis_kamar']) ? $_GET['jenis_kamar'] : null;



$tsql = "SELECT tk.luas,tk.pemandangan,tj.jml_twin,tj.jml_king,tj.jml_double,tj.harga
        FROM tbl_kamar tk JOIN tbl_jenis tj on (tk.kode_jenis = tj.kode_jenis)  
        WHERE tj.jenis='$jenisKamar'";
$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      
        // connection node
      $response["dataKamar"] = array();

      while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
            $dataKamar = array(); // Your return array
            $dataKamar["luas"] = $row["luas"];
            $dataKamar["pemandangan"] = $row["pemandangan"];
            $dataKamar["jumlah_twin"] = $row["jml_twin"];
        	$dataKamar["jumlah_king"] = $row["jml_king"];
        	$dataKamar["jumlah_double"] = $row["jml_double"];
            //$dataKamar["status"] = $row["status"];
        	$dataKamar["harga"] = $row["harga"];
            // pushes a new row onto your array with each iteration
            array_push($response["dataKamar"], $dataKamar);
        }

      	echo json_encode($response);
} else {
    echo 'failure'; //Empty result
}
 
?>