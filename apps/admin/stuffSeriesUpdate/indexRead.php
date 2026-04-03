<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$keyword = trim(str_replace('-', '', $_REQUEST['keyword']));

if (strlen($keyword) > 3) {
	$where .= strlen($keyword) > 0 != '' ? " and concat((select code from asset as a where a.id = ase.asset_id),ase.no_serries)  like '%$keyword%' " : "";
} else {
	$where .= " and ase.no_serries = 'xxxxxxxxxxxx' ";

}

$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,
		   merk, price_buy, price, cond, description, departement_id,depriciation, price_min,	
		  (select date from asset_history as ah where ah.asset_series_id = ase.id and type = '0') as date_buy,
		  (select code from asset as a where a.id = ase.asset_id) as code,
		  (select name from asset as a where a.id = ase.asset_id) as asset_name,
		  (select name from category as c where c.id = (select category_id from asset as a where a.id =  ase.asset_id)) as category_name,		 
		  (select foto from asset as a where a.id = ase.asset_id) as foto		 
		from asset_series as ase
		  where 1=1
			and ase.is_delete = '0'
			and ase.is_remove = '0'
		  $where
		  order by code, no_serries
		  limit 0,100
		  ";
$data = mysqli_query($con, $query) or die(mysqli_error($con));

$split = new Split('index.php', $total['total'], 25, 25);

$query = "select id,name
		from departement
		order by name";

$tmpDepartement = mysqli_query($con, $query) or die(mysqli_error($con));

$dataDepartement = array();
while ($row = mysqli_fetch_array($tmpDepartement)) {
	$dataDepartement[] = array('id' => $row['id'], 'name' => $row['name']);
}

$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

$tmpFund = mysqli_query($con, $query) or die(mysqli_error($con));

$dataFund = array();
while ($row = mysqli_fetch_array($tmpFund)) {
	$dataFund[] = array('id' => $row['id'], 'name' => $row['name']);
}

$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));

$dataLocation = array();
while ($row = mysqli_fetch_array($tmpLocation)) {
	$dataLocation[] = array('id' => $row['id'], 'name' => getLocation($row['id']));
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


include '../../lib/connection-close.php';
?>