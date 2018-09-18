<?php

try{
	$conn = new PDO("sqlsrv:Server=.;Database=DB_SIGAHOT","","");
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
	die(print_r($e->getMessage()));
}
?>