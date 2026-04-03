<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$id = $_REQUEST['id'];
$depriciationId = $id;

$query = "select id, year, description, date_format(date,'%d %M %Y') as date_name
		from asset_depriciation
		where id = '$id'";

$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$dataInfo = mysqli_fetch_array($tmp);

$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
$dataCategory = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>