<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';	
	
	$query = "select id,name 
		from position
		where is_delete = '0'
		order by name";

	$dataPosition = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

	$dataFund = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "select id,name
		from departement
		order by name";

	$dataDepartement = mysqli_query($con, $query) or die(mysqli_error($con));

	include '../../lib/connection-close.php';	
?>
