<?php

include_once 'config.php';

$kode_pemesanan= isset($_POST['kode_pemesanan']) ? $_POST['kode_pemesanan'] : null;


$tsql = "UPDATE tbl_pemesanan
		SET status='Batal'
		WHERE kode_pemesanan='$kode_pemesanan'";

$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);

$count = $getResults->rowCount();

if($count==1)
{
	echo 'success';
}
else
	echo 'error';

?>