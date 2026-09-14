<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$assetId = $_REQUEST['assetId'];
	$condId = $_REQUEST['condId'];

	$query = "select count(id) as jml, id, asset_id, location_id, no_serries, 
		  (select code from asset as a where a.id = ase.asset_id) as code,
		  (select name from asset as a where a.id = ase.asset_id) as asset_name,
		  (select name from category as c where c.id = (select category_id from asset as a where a.id =  ase.asset_id)) as category_name,
		  (select name from location as l where l.id = ase.location_id) as location_name,		  
		  (select foto from asset as a where a.id = ase.asset_id) as foto
		from asset_series as ase
		  where 1=1
			and ase.is_delete = '0'
			and ase.is_remove = '0'
			and ase.asset_id = '$assetId'
			and ase.cond = '$condId'
		  group by location_id, asset_id	
		  order by location_name desc, code, no_serries";	
		  
	$data = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

	$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));
	
	$dataLocation = array();
	while($row = mysqli_fetch_array($tmpLocation)) {
	  $dataLocation[$row['id']] = getLocation($row['id'],$con);
	}

	
	function getLocation($id) {		
		$query = "select id,parent_id,name,level,alias 
		  from location
		  where id = '$id'
		   and is_delete = '0'";

		$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
		$result = mysqli_fetch_array($tmp);

		$locationName = $result['name'];

		if(strlen($result['parent_id']) > 0) {
			if($result['level'] > 1) {
				$locationName = getLocation($result['parent_id'],$con).'~'.$locationName;
			}
		}

		return $locationName;
	}	
		
	function getLocation($id,$con) {		
		$query = "select id,parent_id,level
		  from location
		  where parent_id = '$id'
		   and is_delete = '0'";

		$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
		
		if(mysqli_num_rows($tmp) > 0) {
			while($row = mysqli_fetch_array($tmp)) {
			  $locationId = getLocationSub($row['id'],$con).'~'.$locationId.'~'.$row['id'];
			}
		}

		return $locationId;
	}	
	
	function concat($arrdataLocationAsset) {
		$locationAsset = '(';
		$i = 1;
		foreach($arrdataLocationAsset as $val) {
			if(strlen($val) > 0) {
				$locationAsset = $locationAsset.$val;
				
				if($i < count($arrdataLocationAsset)) {
					$locationAsset = $locationAsset.',';
				}
			}
			
			$i++;
		}
		$locationAsset = $locationAsset.')';	
		
		return $locationAsset;
	}				
	include '../../lib/connection-close.php';
?>
