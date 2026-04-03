<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$locationId = $_REQUEST['locationId'];

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
			and ase.location_id = '$locationId'
		    and ase.departement_id in ($loginAccessDepartement)
			and ase.fund_id in ($loginAccessFund)		   	
		  group by location_id, asset_id	
		  order by location_name desc, code, no_serries";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select id,name,alias 
		from location
		where id = '$locationId'";
$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$infoLocation = mysqli_fetch_array($tmp);

$query = "select id,name,alias
		from location
		where is_delete = '0'
		order by parent_id,name";

$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));

$dataLocation = array();
while ($row = mysqli_fetch_array($tmpLocation)) {
	$dataLocation[$row['id']] = getLocation($row['id']);
}

function getLocation($id)
{
	global $con;
	$query = "select id,parent_id,name,level,alias 
		  from location
		  where id = '$id'
		   and is_delete = '0'";

	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$result = mysqli_fetch_array($tmp);

	$locationName = $result['name'];

	/*
	if(strlen($result['alias']) > 0) {
		$locationName =  $locationName.' <br />('.$result['alias'].' )';
	}
	*/

	if (strlen($result['parent_id']) > 0) {
		if ($result['level'] > 1) {
			$locationName = getLocation($result['parent_id']) . '~' . $locationName;
		}
	}

	return $locationName;
}

include '../../lib/connection-close.php';
?>