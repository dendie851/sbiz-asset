<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$fundId = isset($_REQUEST['fundId']) ? $_REQUEST['fundId'] : 'x';

$where = '';
$where .= $fundId != 'x' ? " and ase.fund_id = '$fundId' " : '';

$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
$dataCategory = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";
$dataFund = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>