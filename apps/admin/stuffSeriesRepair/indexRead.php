<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$keyword = trim(str_replace('-','',$_REQUEST['keyword']));
	
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
			and ase.is_remove = '0'
		  $where
		  order by code, no_serries
		  limit 0,100
		  ";	
	$data = mysqli_query($con, $query) or die(mysqli_error($con));

	$split = new Split('index.php',$total['total'],25,25);
	
	include '../../lib/connection-close.php';
?>
