<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$assetId = $_REQUEST['assetId'];
$depriciationId = $_REQUEST['depriciationId'];

$query = "select a.no_serries, adh.price, adh.price_buy, adh.price_min, adh.depriciation,
			(select asset.code from asset where asset.id = a.asset_id) as asset_code
		from asset_depriciation_history as adh
		inner join asset_series as a		
		  on a.id = adh.asset_series_id
		   and is_delete = '0'
		   and is_remove = '0'	
		where a.asset_id = '$assetId'
		  and adh.asset_depriciation_id = '$depriciationId'
		order by a.no_serries asc";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>