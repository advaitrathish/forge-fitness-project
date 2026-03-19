<?php
	include("../auth.php");
	include('../../../connect/db.php');
	error_reporting(0);

	$Log_Id=$_POST["Log_Id"];
	$name=$_POST["name"];
	
	$age=$_POST["age"];
	$sex=$_POST["sex"];
	$cntno=$_POST["cntno"];
	
	$subjct=$_POST["subjct"];
	$descp=$_POST["descp"];	

	$photo=$_POST["photo"];	
	
	$reply="Pending";

	$date=date("d-m-Y");
	date_default_timezone_set('Asia/Kolkata');
	$tm = date( 'h:i:s A', time () );

	$sql = "insert into complaints(Log_Id,name,subjct,descp,reply,date,age,sex,cntno,tm,photo)values('$Log_Id','$name','$subjct','$descp','$reply','$date','$age','$sex','$cntno','$tm','$photo')";
	$q1 = $db->prepare($sql);
	$q1->execute();	
		
	header("location:../complaint_view.php");
?>
