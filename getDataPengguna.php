<?php

include_once 'config.php';



$emailPengguna = isset($_GET['email']) ? $_GET['email'] : null;



$tsql = "SELECT nama,email,no_identitas,no_tlp,alamat,tanggal_lahir FROM tbl_pelanggan where email='$emailPengguna'";
$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$response = array();

if ($getResults) {
      
        // connection node
      $response["dataPengguna"] = array();

      while ($row = $getResults->fetch(PDO::FETCH_ASSOC)) {
            $dataPengguna = array(); // Your return array
            $dataPengguna["nama"] = $row["nama"];
            $dataPengguna["email"] = $row["email"];
            $dataPengguna["no_identitas"] = $row["no_identitas"];
        	$dataPengguna["nomor_telepon"] = $row["no_tlp"];
        	$dataPengguna["alamat"] = $row["alamat"];
        	$dataPengguna["tanggal_lahir"] = $row["tanggal_lahir"];
            // pushes a new row onto your array with each iteration
            array_push($response["dataPengguna"], $dataPengguna);
        }

      	echo json_encode($response);
} else {
    echo 'failure'; //Empty result
}
 
?>