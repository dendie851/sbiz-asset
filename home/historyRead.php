<?php 
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';

	$id = $_REQUEST['id'];

	$query = "select no_serries,
		  (select code from asset as a where a.id = ase.asset_id) as code
		from asset_series as ase
		where ase.id = '$id'";	
		
	$tmp = mysql_query($query) or die (mysql_error());
	$result = mysql_fetch_array($tmp);
	$assetSeriNomor = $result['code'].'-'.$result['no_serries'];
	
	$query = "select asset_id	 
		from asset_series ah
		  where id = '$id'
		";	
	$tmp = mysql_query($query) or die (mysql_error());
	$dataAsserSeries = mysql_fetch_array($tmp);
	$assetId = $dataAsserSeries['asset_id'];
	
	$query = "select ass.name,
			(select name from category as c where c.id =  ass.category_id) as category_name
		from asset as ass
		  where ass.id = '$assetId'";	
	$tmp = mysql_query($query) or die (mysql_error());
	$dataAsset = mysql_fetch_array($tmp);	
		
	$query = "select id, asset_series_id, date, decription,
			date_format('%d-%m-%Y',date) as format_date
		from asset_history as ah
		  where asset_series_id = '$id'	
		  order by date desc
		  limit 0,100
		";	
	$data = mysql_query($query) or die (mysql_error());	
	
	include '../lib/connection-close.php';
?>
