<?php

include_once 'config.php';

$email = isset($_POST['email']) ? $_POST['email'] : null;
$kataSandi = isset($_POST['kataSandi']) ? $_POST['kataSandi'] : null;



$tsql = "UPDATE tbl_pelanggan 
		SET kata_sandi='$kataSandi'
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