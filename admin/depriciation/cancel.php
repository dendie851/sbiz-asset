<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$id = $_REQUEST['id'];

		
	$query = "select id,asset_series_id,depriciation	 
			  from asset_depriciation_history
			  where asset_depriciation_id = '$id'";

	$data = mysql_query($query) or die(mysql_error());

	$jumlahData = 0;
	while($row = mysql_fetch_array($data)) {
		$query = "update asset_series
					set price = price + {$row['depriciation']}
				  where id = '{$row['asset_series_id']}'";

		mysql_query($query) or die(mysql_error());

		$jumlahData++;
	}

	$query = "delete from asset_depriciation_history
			  where asset_depriciation_id = '$id'";			

	mysql_query($query) or die(mysql_error());

	$query = "delete from asset_depriciation
			  where id = '$id'";			

	mysql_query($query) or die(mysql_error());


	include '../../lib/connection-close.php';

	header('Location:index.php?msg=cancelSuccess&jumlahData='.$jumlahData);
?>
