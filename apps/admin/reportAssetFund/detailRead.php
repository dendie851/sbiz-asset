<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$assetId = $_REQUEST['assetId'];
$locationId = $_REQUEST['locationId'];
$fundId = $_REQUEST['fundId'];

$query = "select id, no_serries, cond, price,
		  (select code from asset as a where a.id = ase.asset_id) as code
		from asset_series as ase
		  where 1=1
			and ase.is_delete = '0'
			and ase.is_remove = '0'
			and asset_id = '$assetId'
			and location_id = '$locationId'
		    and ase.departement_id in ($loginAccessDepartement)
			and fund_id = '$fundId'";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select count(id) as total
		from asset_series as ase
		  where 1=1
			and ase.is_delete = '0'
			and ase.is_remove = '0'
			and asset_id = '$assetId'
			and location_id = '$locationId'
		    and ase.departement_id in ($loginAccessDepartement)
			and fund_id = '$fundId'";

$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
$total = mysqli_fetch_array($dataTotal);

$split = new Split('detail.php', $total['total'], 25, 25);

include '../../lib/connection-close.php';
?>