<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$id = $_GET['id'];
	$parentId = $_REQUEST['parentId'];
	$level = $_REQUEST['level'];

	$query = "update location
		  set is_delete = '1'
		where id='$id'";

	mysql_query($query) or die(mysql_error());

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&level='.$level.'&parentId='.$parentId);
?>
