<?php
include '../lib/connection.php';
include '../lib/split.class.php';
include '../lib/message.class.php';

$keyword = isset($_REQUEST['keyword']) ? trim(str_replace('/', '', str_replace('-', '', $_REQUEST['keyword']))) : '';
$where = " and concat((select code from asset as a where a.id = asset_series.asset_id and asset_series.is_delete = '0'),asset_series .no_serries)  like '%$keyword%' ";

$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,
		  merk, price_buy, price, price_min, depriciation, cond, description, departement_id,
		  (select date_format(date,'%d-%m-%Y') as date from asset_history as ah where ah.asset_series_id = asset_series.id and type = '0') as date_buy,
		  (select code from asset as a where a.id = asset_series.asset_id) as code,
		  (select concat(name,if(length(alias) > 0, concat('<br />(',alias,')'),'')) from location as l where l.id = asset_series.location_id) as location_name,		  
		  (select name from fund as f where f.id = asset_series.fund_id) as fund_name,
		  (select name from departement as d where d.id = asset_series.departement_id) as departement_name,
		  (select name from asset as a where id = asset_series.asset_id) as asset_name,
		  (select foto from asset as a where a.id = asset_series.asset_id) as foto								
		from asset_series 
		where 1=1
		  $where";
$data = mysqli_query($con, $query) or die(mysqli_error($con));




include '../lib/connection-close.php';
?>