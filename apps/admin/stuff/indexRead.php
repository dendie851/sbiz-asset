<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';


$keyword = $_REQUEST['keyword'];
$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';
$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : "";

$query = "select id, category_id,code,name, size, foto, foto_thumb,
		  (select c.name from category as c where c.id = asset.category_id ) as category_name
		from asset		
		where is_delete = '0'
		and name like '%$keyword%'
		  $where
		order by code, name
		limit $record,25";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select count(id) as total
		from asset		
		where is_delete = '0'
		and name like '%$keyword%'
		  $where
		order by name";

$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
$total = mysqli_fetch_array($dataTotal);

$split = new Split('index.php', $total['total'], 25, 25);

$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
$dataCategory = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>