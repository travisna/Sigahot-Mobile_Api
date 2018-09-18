<?php

include_once 'config.php';

$email = isset($_POST['email']) ? $_POST['email'] : null;

$namaLengkap = isset($_POST['nama']) ? $_POST['nama'] : null;
$noIdentitas = isset($_POST['no_identitas']) ? $_POST['no_identitas'] : null;
$noTelpon = isset($_POST['nomor_telepon']) ? $_POST['nomor_telepon'] : null;
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
$tglLahir = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;



$tsql = "UPDATE tbl_pelanggan 
		SET nama='$namaLengkap',
		no_identitas='$noIdentitas',
		no_tlp='$noTelpon',
		alamat='$alamat',
		tanggal_lahir='$tglLahir'
		WHERE email='$email'";

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