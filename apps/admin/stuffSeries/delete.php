<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$assetId = $_GET['assetId'];
	$id = $_GET['id'];

	$query = "update asset_series
		set is_delete = '1'
		where id='$id'";

	mysqli_query($con, $query) or die(mysqli_error($con));

	include '../../lib/connection-close.php';

	header('Location:index.php?id='.$assetId.'&msg=deleteSuccess');
?>
