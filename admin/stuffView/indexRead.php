<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';


	$keyword = $_REQUEST['keyword'];
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : "";
	
	$query = "select a.id, category_id,code,name, size, foto, foto_thumb,
		  (select c.name from category as c where c.id = a.category_id ) as category_name
		from asset as a		
		inner join asset_series as ase 
		  on ase.asset_id = a.id
		  and ase.departement_id in ($loginAccessDepartement)
		  and ase.fund_id in ($loginAccessFund)		   	
		where a.is_delete = '0'
		and name like '%$keyword%'		  	
		  $where
		group by a.id
		order by code, name
		limit $record,25";

	$data = mysql_query($query) or die(mysql_error().'s');
		
	$query = "select count(a.id) as total
		from asset as a		
		inner join asset_series as ase 
		  on ase.asset_id = a.id
		  and ase.departement_id in ($loginAccessDepartement)
		  and ase.fund_id in ($loginAccessFund)		   	
		where a.is_delete = '0'
		and name like '%$keyword%'
		  $where
		group by a.id";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);

	$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	
	include '../../lib/connection-close.php';
?>
