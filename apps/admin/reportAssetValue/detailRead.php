<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$assetId = $_REQUEST['assetId'];
	$fundId = strlen($_REQUEST['fundId']) > 0 ? $_REQUEST['fundId'] : 'x';	
	$departementId = isset($_REQUEST['departementId']) ? $_REQUEST['departementId'] : 'x';
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	$dateBuy = $_REQUEST['dateBuy'];	

    if(isset($_REQUEST['condition'])) {
		if(is_array($_REQUEST['condition'])) {
			$condition = implode(',',$_REQUEST['condition']); 	
		} else {
			$condition =  explode(',',$_REQUEST['condition']);
			$tmp = array();	
			foreach($condition as $val) {
				$tmp[] = "'".$val."'";				
			}						
			$condition = implode(',',$tmp);	
			$condition ;
		}
	}  else {
		$_REQUEST['condition'] = array(0,1,2);
		$condition = implode(',',$_REQUEST['condition']);		
	}	
	
	$where = '';
	$where .=  $fundId != 'x' ? " and ase.fund_id = '$fundId' ": " and ase.fund_id in ($loginAccessFund) "; 
	$where .=  $departementId  != 'x' ? " and ase.departement_id = '$departementId' ": " and ase.departement_id in ($loginAccessDepartement) "; 
	$where .=  $condition != 'x' ? " and ase.cond in ($condition) ": " "; 

	if(strlen($dateBuy) > 0) {
		$query = "select ase.id, asset_id, location_id, fund_id, no_serries, no_purchase,cond,
			   merk, price_buy, price, cond, description, 
			  (select date from asset_history as ah where ah.asset_series_id = ase.id and type = '0') as date_buy,
			  (select code from asset as a where a.id = ase.asset_id) as code,
			  (select name from asset as a where a.id = ase.asset_id) as asset_name,
			  (select name from category as c where c.id = (select category_id from asset as a where a.id =  ase.asset_id)) as category_name,		 
			  (select foto from asset as a where a.id = ase.asset_id) as foto,
			  (select name from fund as f where f.id = ase.fund_id) as fund_name
			from asset_series as ase
			inner join asset_history as ah
			  on ah.asset_series_id = ase.id	
			  and ah.date >= '$dateBuy'
			  and ah.type = '0'
			  where 1=1
				and ase.is_delete = '0'
				and ase.is_remove = '0'			
				and ase.asset_id = '$assetId'
				$where
			  order by ase.location_id, code, no_serries
			  limit $record,25";	
		$data = mysqli_query($con, $query) or die(mysqli_error($con));
	
		$query = "select count(ase.id) as total
			from asset_series as ase
			inner join asset_history as ah
			  on ah.asset_series_id = ase.id	
			  and ah.date >= '$dateBuy'
			  and ah.type = '0'			
			  where 1=1
				and ase.is_delete = '0'
				and ase.is_remove = '0'
				and ase.asset_id = '$assetId'
				$where";	

		$dataTotal = mysqli_query($con, $query)  or die(mysql_error());				
	} else {
		$query = "select id, asset_id, location_id, fund_id, no_serries, no_purchase,cond,
			   merk, price_buy, price, cond, description, 
			  (select date from asset_history as ah where ah.asset_series_id = ase.id and type = '0') as date_buy,
			  (select code from asset as a where a.id = ase.asset_id) as code,
			  (select name from asset as a where a.id = ase.asset_id) as asset_name,
			  (select name from category as c where c.id = (select category_id from asset as a where a.id =  ase.asset_id)) as category_name,		 
			  (select foto from asset as a where a.id = ase.asset_id) as foto,
			  (select name from fund as f where f.id = ase.fund_id) as fund_name
			from asset_series as ase
			  where 1=1
				and ase.is_delete = '0'
				and ase.is_remove = '0'			
				and ase.asset_id = '$assetId'
				$where
			  order by ase.location_id, code, no_serries
			  limit $record,25";

		$data = mysqli_query($con, $query) or die(mysqli_error($con));
			  
		$query = "select count(id) as total
			from asset_series as ase
			  where 1=1
				and ase.is_delete = '0'
				and ase.is_remove = '0'
				and ase.asset_id = '$assetId'
				$where";		

		$dataTotal = mysqli_query($con, $query)  or die(mysql_error());				
	}	
			  

	$total = mysqli_fetch_array($dataTotal);

	$split = new Split('detail.php',$total['total'],25,25);

	
	$query = "select id,name,alias 
		from location
		where is_delete = '0'
		order by parent_id,name";

	$tmpLocation = mysqli_query($con, $query) or die(mysqli_error($con));
	
	$dataLocation = array();
	while($row = mysqli_fetch_array($tmpLocation)) {
	  $dataLocation[$row['id']] = getLocation($row['id'],$con);
	}

	
	function getLocation($id,$con) {		
		$query = "select id,parent_id,name,level,alias 
		  from location
		  where id = '$id'
		   and is_delete = '0'";

		$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
		$result = mysqli_fetch_array($tmp);

		$locationName = $result['name'];

		if(strlen($result['alias']) > 0) {
			$locationName =  $locationName.' <br />('.$result['alias'].' )';
		}

		if(strlen($result['parent_id']) > 0) {
			if($result['level'] > 1) {
				$locationName = getLocation($result['parent_id'],$con).'~'.$locationName;
			}
		}

		return $locationName;
	}	
			
	include '../../lib/connection-close.php';
?>
