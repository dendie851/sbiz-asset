<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$keyword = trim(str_replace('-', '', $_REQUEST['keyword']));

$where .= strlen($keyword) > 0 != '' ? " and concat((select code from asset as a where a.id = ase.asset_id),ase.no_serries)  like '%$keyword%' " : "";
$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,
		   merk, price_buy, price, cond, description, 
		  (select date from asset_history as ah where ah.asset_series_id = ase.id and type = '0') as date_buy,
		  (select code from asset as a where a.id = ase.asset_id) as code,
		  (select name from asset as a where a.id = ase.asset_id) as asset_name,
		  (select name from category as c where c.id = (select category_id from asset as a where a.id =  ase.asset_id)) as category_name,		 
		  (select foto from asset as a where a.id = ase.asset_id) as foto
		from asset_series as ase
		  where 1=1
			and ase.is_delete = '0'
		    $where
		    and ase.departement_id in ($loginAccessDepartement)
	        and ase.fund_id in ($loginAccessFund)
		  order by code, no_serries
		  limit 0,100
		  ";
$data = mysqli_query($con, $query) or die(mysqli_error($con));

$split = new Split('index.php', $total['total'], 25, 25);

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

	if (strlen($result['parent_id']) > 0) {
		if ($result['level'] > 1) {
			$locationName = getLocation($result['parent_id']) . '~' . $locationName;
		}
	}

	return $locationName;
}


include '../../lib/connection-close.php';
?>