<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/message.class.php';

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$type = $_REQUEST['type'];

	$where =  $type == 'x' ? '' : " and type = '$type' ";

	$query = "select ah.id, asset_series_id, date, date_format(date,'%d %M %Y') as format_date, type, decription, 
			(select ase.no_serries from asset_series as ase where ase.id = ah.asset_series_id ) no_serries,
			(select ase.location_id from asset_series as ase where ase.id = ah.asset_series_id ) location_id,
			(select a.code from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) no_asset,
			(select a.name from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_name,
			(select a.code from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_id,
			(select a.foto from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_foto,
			(select a.foto_thumb from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_foto_thumb,						
			(select name from category as c where c.id = (select a.category_id from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id))) category_name
		from asset_history as ah
		inner join asset_series as ase
			on ase.id = ah.asset_series_id
			and ase.departement_id in ($loginAccessDepartement)
		    and ase.fund_id in ($loginAccessFund)
		where (ah.date >= '$dateFrom' and ah.date <= '$dateTo')
		$where
		order by date desc
		limit 0,500";	

	$dataHistory = mysql_query($query) or die (mysql_error());


	$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

	$tmpLocation = mysql_query($query) or die (mysql_error());

	$dataLocation = array();
	while($row = mysql_fetch_array($tmpLocation)) {
	  $dataLocation[$row['id']] = getLocation($row['id']);
	}
	
	function getLocation($id) {		
		$query = "select id,parent_id,name,level,alias 
		  from location
		  where id = '$id'
		   and is_delete = '0'";

		$tmp = mysql_query($query) or die (mysql_error());
		$result = mysql_fetch_array($tmp);

		$locationName = $result['name'];

		if(strlen($result['parent_id']) > 0) {
			if($result['level'] > 1) {
				$locationName = getLocation($result['parent_id']).'~'.$locationName;
			}
		}

		return $locationName;
	}	

	include '../../lib/connection-close.php';	
?>
