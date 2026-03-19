<?php
session_start();
if(!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) {
	header("location:../../");
	exit();
}

?>
