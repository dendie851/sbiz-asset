<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../../lib/connection.php';

	$name = $_POST['name'];
	$positionId = $_POST['positionId'];
	$aktif = $_POST['aktif'];
	$departementId = isset($_POST['departementId']) ? $_POST['departementId'] : array()	;
	$fundId = isset($_POST['fundId']) ? $_POST['fundId'] : array();

	$accessDepartement = '';
	foreach($departementId as $val) {
		$accessDepartement .= $val.'~';
	}	

	$accessFund = '';
	foreach($fundId as $val) {
		$accessFund .= $val.'~';
	}	

	$query = "insert member
		set name = '$name',
		  position_id = '$positionId',
		  access_departement_id = '$accessDepartement',	
		  access_fund_id = '$accessFund',
		  is_enabled = '$aktif'";		

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id
		from member";		

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$memberId = $data['id'];

	$username = $_POST['username'];
	$pwd = $_POST['pwd'];

	$query = "insert user
		set username = '$username',
		  password = md5('$pwd'), 	
		  member_id = '$memberId'";

	mysql_query($query) or die (mysql_error());

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
