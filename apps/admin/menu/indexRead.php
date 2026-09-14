<?php 

	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	ini_set('display_errors', 0);

	include '../login/auth.php';

	$loginGroup = $_SESSION['loginGroup'];

?>
