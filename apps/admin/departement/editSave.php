<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$description = $_POST['description'];

	$query = "update departement
		set name = '$name',
		  description = '$description' 
		where id='$id'";

	mysqli_query($con, $query) or die(mysqli_error($con));

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
