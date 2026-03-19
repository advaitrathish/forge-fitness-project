<?php
session_start();
if(!isset($_SESSION['SESS_TRAINEE_ID']) || (trim($_SESSION['SESS_TRAINEE_ID']) == '')) {
	header("location:../../");
	exit();
}

?>
