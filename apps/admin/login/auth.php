<?php 
	@session_start();

	if(!$_SESSION['login']) {
		header('Location:../login/index.php');
	} else {
		if($_SESSION['loginApp'] != 'simpleAsset') {
			header('Location:../login/index.php');
		}
	}	

	$loginAccessDepartement =  substr(str_replace('~',',',$_SESSION['loginAccessDepartement']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessDepartement']))) ).'9999';
	$loginAccessFund =  substr(str_replace('~',',',$_SESSION['loginAccessFund']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessFund']))) ).'9999';
?>
