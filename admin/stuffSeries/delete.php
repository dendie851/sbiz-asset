<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$assetId = $_GET['assetId'];
	$id = $_GET['id'];

	$query = "update asset_series
		set is_delete = '1'
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../../lib/connection-close.php';

	header('Location:index.php?id='.$assetId.'&msg=deleteSuccess');
?>
