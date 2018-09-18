<?php

include_once 'config.php';



$emailPengguna = isset($_POST['email']) ? $_POST['email'] : null;
$jawaban = isset($_POST['jawaban']) ? $_POST['jawaban'] : null;


$tsql = "SELECT COUNT(*) FROM tbl_pelanggan where email='$emailPengguna' and pertanyaan_unik='$jawaban'";
$getResults = $conn->prepare($tsql);
$getResults->execute();
//$results = $getResults->fetchAll(PDO::FETCH_BOTH);
$count = $getResults->fetchColumn();


if($count==1)
{
echo 'success';
}
else
{
echo 'failure';
}
 
?>