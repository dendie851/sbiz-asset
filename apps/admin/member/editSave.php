<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../../lib/connection.php';

	$id = $_POST['id'];
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


	$query = "update member
		set name = '$name',
		  position_id = '$positionId',
		  access_departement_id = '$accessDepartement',	
		  access_fund_id = '$accessFund',
		  is_enabled = '$aktif'
		where id='$id'";

	mysqli_query($con, $query) or die(mysqli_error($con));

	$usernameHidden = $_POST['usernameHidden'];
	$username = $_POST['username'];
	$pwd = $_POST['pwd'];

	if($usernameHidden != $username) {
		$query = "update user
			set username = '$username'
			where member_id='$id'";

		mysqli_query($con, $query) or die(mysqli_error($con));
	}

	if(strlen($pwd) > 0) {
		$query = "update user
			set password = md5('$pwd')
			where member_id='$id'";

		mysqli_query($con, $query) or die(mysqli_error($con));
	}

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&type=4');
?>
