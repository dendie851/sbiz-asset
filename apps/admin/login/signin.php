<?php
session_start();

include '../../lib/connection.php';

$username = trim($_POST['username']);
$password = md5(trim($_POST['password']));

$query = "select count(username) as jml
		from user
		where username ='$username'
		  and password = '$password'";

$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$data = mysqli_fetch_array($tmp);


include '../../lib/connection-close.php';

if ($data['jml'] == 1) {
	include '../../lib/connection.php';

	$query = "select member_id 
			from user
			where username ='$username'";

	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$dataDetail = mysqli_fetch_array($tmp);

	$memberId = $dataDetail['member_id'];

	$query = "select id, is_enabled, position_id, access_departement_id, access_fund_id,
				(select privilage from position as p where p.id = m.position_id) as privilage 
			from member as m
			where id ='$memberId'";

	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$dataMember = mysqli_fetch_array($tmp);

	include '../../lib/connection-close.php';
	$memberIsEnabled = $dataMember['is_enabled'];
	$memberPrivilage = $dataMember['privilage'];
	$memberId = $dataMember['id'];
	$positionId = $dataMember['position_id'];
	$memberAccessDepartement = $dataMember['access_departement_id'];
	$memberAccessFund = $dataMember['access_fund_id'];

	if ($memberIsEnabled == '1') {
		$_SESSION['login'] = $username;
		$_SESSION['loginPrivilage'] = $memberPrivilage;
		$_SESSION['loginMemberId'] = $memberId;
		$_SESSION['positionId'] = $positionId;
		$_SESSION['loginAccessDepartement'] = $memberAccessDepartement;
		$_SESSION['loginAccessFund'] = $memberAccessFund;
		$_SESSION['loginApp'] = 'simpleAsset';

		header('Location:../home/index.php');
	} else {
		header('Location:../login/index.php?msg=loginFailed');
	}
} else {
	header('Location:../login/index.php?msg=loginFailed');
}
?>