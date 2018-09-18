<?php

include_once 'config.php';

$namaLengkap = isset($_POST['nama']) ? $_POST['nama'] : null;
$emailPengguna = isset($_POST['email']) ? $_POST['email'] : null;
$kataSandi = isset($_POST['kata_sandi']) ? $_POST['kata_sandi'] : null;
$jawaban = isset($_POST['pertanyaan_unik']) ? $_POST['pertanyaan_unik'] : null;
$jenisKelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : null;



$cek = "SELECT COUNT(*) FROM tbl_pelanggan where email='$emailPengguna'";
$cek = $conn->prepare($cek);
$cek->execute();
$countEmail = $cek->fetchColumn();

if($countEmail==1)
{
	$cekEmail = FALSE;
}
else{
	$cekEmail = TRUE;
}

if($cekEmail){
	$tsql = "INSERT INTO tbl_pelanggan (nama,email,kata_sandi,jenis_kelamin,pertanyaan_unik,flag_pemesanan)
			values('$namaLengkap','$emailPengguna','$kataSandi','$jenisKelamin','$jawaban',0)";

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
}
else{
	echo 'error02';
}



 
?>