<?php
	include("../../../connect/db.php");

	$Log_Id=$_POST["Log_Id"];
	$password=$_POST["password"];
	
	
	$sql = "update principal set password='$password' where Log_Id='$Log_Id'";
	$q1 = $db->prepare($sql);
	$q1->execute();	

	header("location:../index.php");
?>
