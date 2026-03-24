<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../../lib/connection.php';

	$year = $_POST['year'];
	$description = $_POST['description'];


	$query = "select  max(id) as max_id 
			  from asset_depriciation";

	$tmp = mysql_query($query) or die(mysql_error());
	$data = mysql_fetch_array($tmp);
	$assetDepriciationHistoryId = isset($data['max_id']) ? ($data['max_id'] + 1) : 1;

		
	$query = "select id,asset_id, price_buy, price, price_min, depriciation	 
			  from asset_series
			  where is_remove = '0'
			    and is_delete = '0'
			  order by asset_id";

	$data = mysql_query($query) or die(mysql_error());

	$jumlahData = 0;
	while($row = mysql_fetch_array($data)) {
		if($row['depriciation'] > 0) {

			if($row['price_min'] > 0) {
				if(($row['price'] - $row['depriciation'])  > $row['price_min']) {
					$query = "update asset_series
								set price = price - {$row['depriciation']}
							  where id = '{$row['id']}'";

					mysql_query($query) or die(mysql_error());

					$query = "insert asset_depriciation_history
								set asset_depriciation_id = '$assetDepriciationHistoryId',
								   asset_series_id = {$row['id']},	
								   price = '{$row['price']}', 
								   price_buy = '{$row['price_buy']}',
								   price_min = '{$row['price_min']}',
								   depriciation = '{$row['depriciation']}'
							  ";

					mysql_query($query) or die(mysql_error());

					$jumlahData++;
				}	
			}		
		}			
	}

	$query = "insert asset_depriciation
				set id = '$assetDepriciationHistoryId',
				   year = '$year',
				   description = 'jumlah data yang terkena deprisiasi $jumlahData data<br /> $description',
				   date = now()";			

	mysql_query($query) or die(mysql_error());


	include '../../lib/connection-close.php';

	header('Location:index.php?msg=uploadSuccess&jumlahData='.$jumlahData);
?>
