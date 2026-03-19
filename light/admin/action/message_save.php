<?php
	include("../auth.php");
	include('../../../connect/db.php');
	
	$tname=$_POST["tname"];
	$sname=$_POST["sname"];
	$subjt=$_POST["subjt"];
	$desp=$_POST["desp"];
	$photo=$_POST["photo"];
	
	$date=date("d-m-Y");
	
	date_default_timezone_set('Asia/Kolkata');
$tm = date( 'h:i:s A', time () );


	$image = addslashes(file_get_contents($_FILES['file1']['tmp_name']));
	$image_name = addslashes($_FILES['file1']['name']);
	$image_size = getimagesize($_FILES['file1']['tmp_name']);
	move_uploaded_file($_FILES["file1"]["tmp_name"], "../../photo/" . $_FILES["file1"]["name"]);
	$file1 = $_FILES["file1"]["name"];

	$sql = "insert into message(tname,sname,subjt,desp,photo,file1,date,tm)values('$tname','$sname','$subjt','$desp','$photo','$file1','$date','$tm')";
	$q1 = $db->prepare($sql);
	$q1->execute();	


	header("location:../mail_send.php");
?>
