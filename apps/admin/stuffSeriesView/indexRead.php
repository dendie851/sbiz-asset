<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$id = $_REQUEST['id'];
	
	$query = "select a.id, a.code, a.category_id, a.name, a.size, a.foto, a.foto_thumb,
			(select name from category as c where c.id = a.category_id) as category_name  
		from asset as a
		where id = '$id'";
	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$dataInfo = mysqli_fetch_array($tmp);
	$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,
		  merk, price_buy, price, price_min, depriciation, cond, description, departement_id,
		  (select date_format(date,'%d-%m-%Y') as date from asset_history as ah where ah.asset_series_id = asset_series.id and type = '0') as date_buy,
		  (select code from asset as a where a.id = asset_series.asset_id) as code,
		  (select concat(name,if(length(alias) > 0, concat('<br />(',alias,')'),'')) from location as l where l.id = asset_series.location_id) as location_name,
		  (select name from fund as f where f.id = asset_series.fund_id) as fund_name,
		  (select name from departement as d where d.id = asset_series.departement_id) as departement_name								
		from asset_series 
		where asset_id = '$id'
		  and is_delete = '0'
		  and is_remove = '0'
		  and departement_id in ($loginAccessDepartement)
		  and fund_id in ($loginAccessFund)
		order by no_serries asc, location_id";
	$data = mysqli_query($con, $query) or die(mysqli_error($con));;

	$query = "select id,name
		from departement
		order by name";

	$tmpDepartement = mysqli_query($con, $query) or die(mysqli_error($con));

	$dataDepartement = array();
	while($row = mysqli_fetch_array($tmpDepartement)) {
		  $dataDepartement[] = array('id'=>$row['id'],'name'=>$row['name']);
	}


	$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

	$tmpFund = mysqli_query($con, $query) or die(mysqli_error($con));

	$dataFund = array();
	while($row = mysqli_fetch_array($tmpFund)) {
	  $dataFund[] = array('id'=>$row['id'],'name'=>$row['name']);
	}

	$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

	$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));
	
	$dataLocation = array();
	while($row = mysqli_fetch_array($tmpLocation)) {
	  $dataLocation[] = array('id'=>$row['id'],'name'=>getLocation($row['id'],$con));
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
	
	include '../../lib/connection-close.php';
?>
