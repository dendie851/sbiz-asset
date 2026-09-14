<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../../lib/connection.php';

	$name = $_POST['name'];

	$query = "insert category
		set name = '$name'";		

	mysqli_query($con, $query) or die(mysqli_error($con));

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
