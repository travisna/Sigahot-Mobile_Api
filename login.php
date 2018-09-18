<?php

include_once 'config.php';



$emailPengguna = isset($_POST['email']) ? $_POST['email'] : null;
$kataSandi = isset($_POST['kata_sandi']) ? $_POST['kata_sandi'] : null;


$tsql = "SELECT COUNT(*) FROM tbl_pelanggan where email='$emailPengguna' and kata_sandi='$kataSandi'";
$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);
$count = $getResults->fetchColumn();

$tsql2 = "SELECT COUNT(*) FROM tbl_petugas tp join tbl_jabatan tj on (tp.kode_jabatan = tj.kode_jabatan) 
			where tp.username='$emailPengguna' and tp.kata_sandi='$kataSandi' and tj.jabatan in('Owner','General Manager')";
$getResults2 = $conn->prepare($tsql2);
$getResults2->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);
$count2 = $getResults2->fetchColumn();



if($count==1)
{
	echo 'pelanggan';
}
else
{
	if($count2==1)
		echo 'pegawai';
	else
		echo 'failure';
}
 
?>