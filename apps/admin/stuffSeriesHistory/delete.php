<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$id = $_REQUEST['id'];
	$assetid = $_REQUEST['assetId'];
	
	$query = "delete from asset_history 
		  where id = '$id'";	
		  
	$data = mysqli_query($con, $query) or die(mysqli_error($con));	

	header('Location:history.php?msg=deleteSuccess&id='.$assetid);
	
	include '../../lib/connection-close.php';
?>