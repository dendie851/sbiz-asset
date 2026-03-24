<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$keyword = $_POST['keyword'];
	$assetId = $_POST['assetId'];
	$id = $_POST['id'];	
	$noPurchase = $_POST['noPurchase'];	
	$locationId = $_POST['locationId'];	
	$fundId = $_POST['fundId'];	
	$merk = $_POST['merk'];
	$priceBuy = $_POST['priceBuy'];	
	$price = $_POST['price'];
	$condition = $_POST['condition'];	
	$dataBuy = $_POST['dateBuy'];
	$departementId = $_POST['departementId'];
	$depriciation = $_POST['depriciation'];
	$priceMin = $_POST['priceMin'];

	$i=0;
	foreach($id as $val) {	
		$query = "update asset_series
			set location_id = '{$locationId[$i]}',
			  fund_id = '{$fundId[$i]}',
			  departement_id = '{$departementId[$i]}',
			  no_purchase = '{$noPurchase[$i]}',
			  merk = '{$merk[$i]}',
			  price_buy = '{$priceBuy[$i]}',
			  price = '{$price[$i]}', 
			  depriciation = '{$depriciation[$i]}',
			  price_min = '{$priceMin[$i]}',
			  cond = '{$condition[$i]}'
			where id = '$val'";
		mysql_query($query) or die (mysql_error());
		
		$tmp = explode('/',$dataBuy[$i]);
		$dateBuy  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];	

		$query = "update asset_history
			   set date = '$dateBuy',
				 decription = '<b>Pembelian / Asset Masuk</b>'
			   where asset_series_id = '$val' 
			      and type = '0'";	
		mysql_query($query) or die (mysql_error());	

		$i++;
	}

	include '../../lib/connection-close.php';

	header('Location:index.php?id='.$assetId.'&msg=addSuccess&keyword='.$keyword);
?>
