<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$id = $_REQUEST['id'];
	
	$query = "select a.id, a.code, a.category_id, a.name, a.size, a.foto, a.foto_thumb,
			(select name from category as c where c.id = a.category_id) as category_name  
		from asset as a
		where id = '$id'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataInfo = mysql_fetch_array($tmp);

	$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,
		  merk, price_buy, price, cond, description, departement_id, depriciation, price_min,	
		  (select date from asset_history as ah where ah.asset_series_id = asset_series.id and type = '0') as date_buy,
		  (select code from asset as a where a.id = asset_series.asset_id) as code
		from asset_series 
		where asset_id = '$id'
		  and is_delete = '0'
		  and is_remove = '0'
		order by no_serries asc, location_id";
	$data = mysql_query($query) or die (mysql_error());;

	$query = "select id,name
		from departement
		order by name";

	$tmpDepartement = mysql_query($query) or die (mysql_error());

	$dataDepartement = array();
	while($row = mysql_fetch_array($tmpDepartement)) {
	  $dataDepartement[] = array('id'=>$row['id'],'name'=>$row['name']);
	}


	$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

	$tmpFund = mysql_query($query) or die (mysql_error());

	$dataFund = array();
	while($row = mysql_fetch_array($tmpFund)) {
	  $dataFund[] = array('id'=>$row['id'],'name'=>$row['name']);
	}

	$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

	$tmpLocation = mysql_query($query) or die (mysql_error());
	
	$dataLocation = array();
	while($row = mysql_fetch_array($tmpLocation)) {
	  $dataLocation[] = array('id'=>$row['id'],'name'=>getLocation($row['id']));
	}


	function getLocation($id) {		
		$query = "select id,parent_id,name,level,alias 
		  from location
		  where id = '$id'
		   and is_delete = '0'";

		$tmp = mysql_query($query) or die (mysql_error());
		$result = mysql_fetch_array($tmp);

		$locationName = $result['name'];

		if(strlen($result['alias']) > 0) {
			$locationName =  $locationName.' ('.$result['alias'].' )';
		}

		if(strlen($result['parent_id']) > 0) {
			if($result['level'] > 1) {
				$locationName = getLocation($result['parent_id']).'~'.$locationName;
			}
		}

		return $locationName;
	}	
	
	include '../../lib/connection-close.php';
?>
