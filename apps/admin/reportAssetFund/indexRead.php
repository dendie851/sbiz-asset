<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$locationId = $_REQUEST['locationId'];
$fundId = $_REQUEST['fundId'];

$where = '';
if (($locationId != 'x') && isset($_REQUEST['locationId'])) {
	$tmpdataLocationAsset = getLocationSub($locationId) . '~' . $locationId;
	$locationParentId = concat(explode('~', $tmpdataLocationAsset));
	$where .= " and ase.location_id in $locationParentId ";
} else {
	$where .= '';
}

if (($fundId != 'x') && isset($_REQUEST['fundId'])) {
	$where .= " and ase.fund_id = '$fundId' ";
} else {
	$where .= '';
}

$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,cond,
		   merk, price_buy, price, cond, description, 
		  (select date from asset_history as ah where ah.asset_series_id = ase.id and type = '0') as date_buy,
		  (select code from asset as a where a.id = ase.asset_id) as code,
		  (select name from asset as a where a.id = ase.asset_id) as asset_name,
		  (select name from category as c where c.id = (select category_id from asset as a where a.id =  ase.asset_id)) as category_name,		 
		  (select foto from asset as a where a.id = ase.asset_id) as foto,
		  (select name from fund as f where f.id = ase.fund_id) as fund_name,
		  (select name from location as l where l.id = ase.location_id) as location_name
		from asset_series as ase
		  where 1=1
			and ase.is_delete = '0'
			and ase.is_remove = '0'
		    and ase.departement_id in ($loginAccessDepartement)
			and ase.fund_id in ($loginAccessFund)		   	
			$where
		group by location_id, asset_id
		  order by ase.location_id, code, no_serries";

$dataResult = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select id,name
		from fund
		where is_delete = '0'
		  and id in ($loginAccessFund)		   	
		order by name";
$dataFund = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

$tmpLocationCmb = mysqli_query($con, $query) or die(mysqli_error($con));

$dataLocationCmb = array();
while ($row = mysqli_fetch_array($tmpLocationCmb)) {
	$dataLocationCmb[] = array('id' => $row['id'], 'name' => getLocation($row['id']));
}

$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));

$dataLocation = array();
while ($row = mysqli_fetch_array($tmpLocation)) {
	$dataLocation[$row['id']] = getLocation($row['id']);
}

$query = "select id,name
		from fund
		where id = '$fundId'";
$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$printDataFund = mysqli_fetch_array($tmp);

$query = "select id,name
		from location
		where id = '$locationId'";
$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$printDataLocation = mysqli_fetch_array($tmp);

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

	if (strlen($result['alias']) > 0) {
		$locationName = $locationName . ' (' . $result['alias'] . ' )';
	}

	if (strlen($result['parent_id']) > 0) {
		if ($result['level'] > 1) {
			$locationName = getLocation($result['parent_id']) . '~' . $locationName;
		}
	}

	return $locationName;
}

function getLocationSub($id)
{
	global $con;
	$locationId = '';
	$query = "select id,parent_id,level
		  from location
		  where parent_id = '$id'
		   and is_delete = '0'";

	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));

	if (mysql_num_rows($tmp) > 0) {
		while ($row = mysqli_fetch_array($tmp)) {
			$locationId = getLocationSub($row['id']) . '~' . $locationId . '~' . $row['id'];
		}
	}

	return $locationId;
}

function concat($arrdataLocationAsset)
{
	$locationAsset = '(';
	$i = 1;
	foreach ($arrdataLocationAsset as $val) {
		if (strlen($val) > 0) {
			$locationAsset = $locationAsset . $val;

			if ($i < count($arrdataLocationAsset)) {
				$locationAsset = $locationAsset . ',';
			}
		}

		$i++;
	}
	$locationAsset = $locationAsset . ')';

	return $locationAsset;
}

include '../../lib/connection-close.php';
?>