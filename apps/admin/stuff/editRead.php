<?php
include '../login/auth.php';
include '../../lib/connection.php';

$id = $_REQUEST['id'];

$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
$dataCategory = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select id, code, category_id, name, size, foto, foto_thumb 
		from asset
		where id = '$id'";

$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$data = mysqli_fetch_array($tmp);


include '../../lib/connection-close.php';
?>