<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../../lib/connection.php';

	$name = trim($_POST['name']);
	$alias = trim($_POST['aliasa']);
	$parentId = $_REQUEST['parentId'];
	$level = $_REQUEST['level'];
	$size = $_REQUEST['size'];
	$status = $_REQUEST['status'];


	$query = "insert location	
		set name = '$name',
		  alias = '$alias',
		  parent_id = '$parentId',
		  level = '$level',
		  size = '$size',
		  status = '$status'";

	mysqli_query($con, $query)  or die(mysql_error());

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&level='.$level.'&parentId='.$parentId);
?>
