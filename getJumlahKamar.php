<?php

include_once 'config.php';

$cabang= isset($_GET['cabang']) ? $_GET['cabang'] : null;


$tsql = "SELECT count(*) 
        FROM tbl_kamar tk join tbl_cabang tc on (tk.kode_cabang = tc.kode_cabang)
        WHERE tk.kode_jenis='S' and tc.cabang='$cabang'";
$tsql2 = "SELECT count(*) 
        FROM tbl_kamar tk join tbl_cabang tc on (tk.kode_cabang = tc.kode_cabang)
        WHERE tk.kode_jenis='DD' and tc.cabang='$cabang'";
$tsql3 = "SELECT count(*) 
        FROM tbl_kamar tk join tbl_cabang tc on (tk.kode_cabang = tc.kode_cabang)
        WHERE tk.kode_jenis='ED' and tc.cabang='$cabang'";
$tsql4 = "SELECT count(*) 
        FROM tbl_kamar tk join tbl_cabang tc on (tk.kode_cabang = tc.kode_cabang)
        WHERE tk.kode_jenis='JS' and tc.cabang='$cabang'";


$getResults = $conn->prepare($tsql);
$getResults->execute();
$countSuperior = $getResults->fetchColumn();

$getResults2 = $conn->prepare($tsql2);
$getResults2->execute();
$countDoubleDeluxe = $getResults2->fetchColumn();

$getResults3 = $conn->prepare($tsql3);
$getResults3->execute();
$countExecutiveDeluxe= $getResults3->fetchColumn();

$getResults4 = $conn->prepare($tsql4);
$getResults4->execute();
$countJuniorSuite = $getResults4->fetchColumn();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      
        // connection node
        $response["dataJumlahKamar"] = array();

        $dataJumlahKamar = array(); // Your return array
        $dataJumlahKamar["jumlah_superior"] = $countSuperior;
        $dataJumlahKamar["jumlah_doubleDeluxe"] = $countDoubleDeluxe;
        $dataJumlahKamar["jumlah_ExecutiveDeluxe"] = $countExecutiveDeluxe;
        $dataJumlahKamar["jumlah_JuniorSuite"] = $countJuniorSuite;
            // pushes a new row onto your array with each iteration
        array_push($response["dataJumlahKamar"], $dataJumlahKamar);
        
      	echo json_encode($response);
} else {
    echo 'failure'; //Empty result
}
 
?>