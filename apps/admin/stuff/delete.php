<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$id = $_GET['id'];

	$query = "select foto, foto_thumb 
		from asset		
		where id = '$id'";

	$tmp = mysqli_query($con, $query)  or die(mysql_error());	
	$data = mysqli_fetch_array($tmp);

	is_file(dirname(__FILE__).'/../asset/foto/'.$data['foto']) ? unlink(dirname(__FILE__).'/../asset/foto/'.$data['foto']) : false;
	is_file(dirname(__FILE__).'/../asset/foto/'.$data['foto_thumb']) ? unlink(dirname(__FILE__).'/../asset/foto/'.$data['foto_thumb']) : false;
			
	$query = "update asset
		set is_delete = '1'
		where id='$id'";

	mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "update asset_series
		set is_delete = '1'
		where asset_id='$id'";

	mysqli_query($con, $query) or die(mysqli_error($con));

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess');
?>
