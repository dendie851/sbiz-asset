<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$assetId = $_REQUEST['assetId'];

	$query = "select if(max(no_serries)=null,0,max(no_serries)) as code 
		from asset_series
		where asset_id = '$assetId'";

	$data = mysql_query($query) or die(mysql_error());
	$assetSeriesCode = mysql_fetch_array($data);
	$assetSeriesCodeSugest = str_pad((int) $assetSeriesCode['code'] + 1, 4, "0", STR_PAD_LEFT); 


	$query = "select id, name, code
		from asset
		where id = '$assetId'";

	$tmp = mysql_query($query);
	$dataAsset = mysql_fetch_array($tmp);


	$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

	$dataFund = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from departement
		order by name";

	$dataDepartement = mysql_query($query) or die (mysql_error());


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
