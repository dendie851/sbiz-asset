<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../../lib/connection.php';
	include '../../lib/image.class.php';

	$id = trim($_POST['id']);
	$parentId = trim($_POST['parentId']);
	$name = trim($_POST['name']);
	$alias = trim($_POST['aliasa']);
	$level = $_REQUEST['level'];
	$size = $_REQUEST['size'];
	$status = $_REQUEST['status'];	

	$query = "update location
		set name = '$name',
		  alias = '$alias',	
		  parent_id = '$parentId',
		  size = '$size',
		  status = '$status'
		where id = '$id'";

	mysql_query($query) or die(mysql_error());	

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&level='.$level.'&parentId='.$parentId);
?>
