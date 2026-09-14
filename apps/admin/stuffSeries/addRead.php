<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$assetId = $_REQUEST['assetId'];

	$query = "select if(max(no_serries)=null,0,max(no_serries)) as code 
		from asset_series
		where asset_id = '$assetId'";

	$data = mysqli_query($con, $query)  or die(mysql_error());
	$assetSeriesCode = mysqli_fetch_array($data);
	$assetSeriesCodeSugest = str_pad((int) $assetSeriesCode['code'] + 1, 4, "0", STR_PAD_LEFT); 


	$query = "select id, name, code
		from asset
		where id = '$assetId'";

	$tmp = mysqli_query($con, $query); 
	$dataAsset = mysqli_fetch_array($tmp);


	$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

	$dataFund = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "select id,name
		from departement
		order by name";

	$dataDepartement = mysqli_query($con, $query) or die(mysqli_error($con));


	$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

	$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));
	
	$dataLocation = array();
	while($row = mysqli_fetch_array($tmpLocation)) {
	  $dataLocation[] = array('id'=>$row['id'],'name'=>getLocation($row['id'],$con));
	}

	function getLocation($id) {		
		$query = "select id,parent_id,name,level,alias 
		  from location
		  where id = '$id'
		   and is_delete = '0'";

		$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
		$result = mysqli_fetch_array($tmp);

		$locationName = $result['name'];

		if(strlen($result['alias']) > 0) {
			$locationName =  $locationName.' ('.$result['alias'].' )';
		}

		if(strlen($result['parent_id']) > 0) {
			if($result['level'] > 1) {
				$locationName = getLocation($result['parent_id'],$con).'~'.$locationName;
			}
		}

		return $locationName;
	}	
	include '../../lib/connection-close.php';
?>
