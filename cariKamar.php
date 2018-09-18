<?php

include_once 'config.php';



$tglMasuk= isset($_GET['tgl_masuk']) ? $_GET['tgl_masuk'] : null;
$tglKeluar=isset($_GET['tgl_keluar']) ? $_GET['tgl_keluar'] : null;
$cabang = isset($_GET['cabang']) ? $_GET['cabang'] : null;
//////////////////////////////////////////////////////////////////////////


  
$tsqlCabang = "SELECT kode_cabang from tbl_cabang where cabang='$cabang'";
$cabangQuery = $conn->prepare($tsqlCabang);
$cabangQuery->execute();

$rowCabang = $cabangQuery->fetch(PDO::FETCH_ASSOC);
$kode_cabang = $rowCabang["kode_cabang"];


$tsql = "SELECT tr.kode_jenis from tbl_pemesanan tp 
JOIN tbl_rincianPemesanan tr on(tp.kode_pemesanan = tr.kode_pemesanan)
where (tp.tanggal_masuk>='$tglMasuk' and tp.tanggal_keluar<='$tglKeluar') and kode_cabang=$kode_cabang";    


$getResults = $conn->prepare($tsql);
$getResults->execute();


$double_deluxe=0;
$superior=0;
$executive_deluxe=0;
$junior_suite=0;

$response = array();

if ($getResults) {
      
    $response["dataCariKamar"] = array();
    $dataCariKamar = array();

    while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
      if($row["kode_jenis"]=="S")
        $superior++;
      else if($row["kode_jenis"]=="ED")
        $executive_deluxe++;
      else if($row["kode_jenis"]=="DD")   
        $double_deluxe++;
      else
        $junior_suite++;
    }

    $dataCariKamar["double_deluxe"] = "$double_deluxe";
    $dataCariKamar["superior"] = "$superior";
    $dataCariKamar["executive_deluxe"] = "$executive_deluxe";
    $dataCariKamar["junior_suite"] = "$junior_suite";

    array_push($response["dataCariKamar"], $dataCariKamar);
        
        
    echo json_encode($response);

} else {
    echo 'failure'; //Empty result
}

 
?>