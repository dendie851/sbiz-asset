<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$id = $_REQUEST['id'];

	$query = "select id,name,description 
		from departement
		where id='$id'";

	$tmp = mysqli_query($con, $query); 
	$data = mysqli_fetch_array($tmp);

	include '../../lib/connection-close.php';
?>
