<?php
	include("../../../connect/db.php");

	$Log_Id=$_POST["Log_Id"];
	$name=$_POST["name"];
	
	$design=$_POST["design"];
	$email=$_POST["email"];
	
	$contactno=$_POST["contactno"];
	$addrs=$_POST["addrs"];
	
	
	$image = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
	$image_name = addslashes($_FILES['photo']['name']);
	$image_size = getimagesize($_FILES['photo']['tmp_name']);
	move_uploaded_file($_FILES["photo"]["tmp_name"], "../../photo/" . $_FILES["photo"]["name"]);
	$photo = $_FILES["photo"]["name"];
	
	
	if($photo=="")
	{
		$sql = "update admin set name='$name',design='$design',email='$email',contactno='$contactno',addrs='$addrs' where Log_Id='$Log_Id'";
		$q1 = $db->prepare($sql);
		$q1->execute();	
	}
	else
	{
		$sql = "update admin set name='$name',design='$design',email='$email',contactno='$contactno',addrs='$addrs',photo='$photo' where Log_Id='$Log_Id'";
		$q1 = $db->prepare($sql);
		$q1->execute();	
	}

	header("location:../index.php");
?>
