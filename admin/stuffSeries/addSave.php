<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../../lib/connection.php';

	$assetId = $_POST['assetId'];	
	$noSeries = $_POST['noSeries'];
	$noPurchase = $_POST['noPurchase'];	
	$locationId = $_POST['locationId'];	
	$fundId = $_POST['fundId'];	
	$departementId = $_POST['departementId'];	
	$merk = $_POST['merk'];
	$priceBuy = $_POST['priceBuy'];	
	$price = $_POST['price'];
	$condition = $_POST['condition'];	
	$description = $_POST['description'];
	$depriciation = $_POST['depriciation'];
	$priceMin = $_POST['priceMin'];

	
	$tmp = explode('/',$_POST['dateBuy']);
	$dateBuy  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	
	$query = "insert asset_series
		set asset_id = '$assetId',
		  location_id = '$locationId',
		  fund_id = '$fundId',
		  departement_id = '$departementId',
		  no_serries = '$noSeries',
		  no_purchase = '$noPurchase',
		  merk = '$merk',
		  price_buy = '$priceBuy',
		  price = '$price', 
		  depriciation = '$depriciation',
		  price_min = '$priceMin',
		  cond = '$condition',
		  description = '$description'";
	mysql_query($query) or die (mysql_error());
	
	$query = "select max(id) as id from asset_series";
	$tmp = mysql_query($query) or die (mysql_error());	
	$data = mysql_fetch_array($tmp);
	$assetSeriesId = $data['id'];
	
	$query = "insert asset_history
		   set asset_series_id = '$assetSeriesId',  
			  type = '0',
			  decription = '<b>Pembelian / Asset Masuk</b>',
			  date = '$dateBuy'";
				  
	mysql_query($query) or die (mysql_error());	
	
	include '../../lib/connection-close.php';

	header('Location:index.php?id='.$assetId.'&msg=addSuccess');
?>
