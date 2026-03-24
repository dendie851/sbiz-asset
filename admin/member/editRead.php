<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	$id = $_REQUEST['id'];

	$query = "select id,name,position_id,is_enabled,access_departement_id,
			access_fund_id
		from member
		where id='$id'";
	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	$query = "select id,username
		from user
		where member_id = '$id'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataUser = mysql_fetch_array($tmp);

	$query = "select id,name 
		from position
		where is_delete = '0'
		order by name";
	$dataPosition = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

	$dataFund = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from departement
		order by name";

	$dataDepartement = mysql_query($query) or die (mysql_error());


	$dataExecutorFund = explode('~',$data['access_fund_id']);
	$dataExecutorDepartement = explode('~',$data['access_departement_id']);

	include '../../lib/connection-close.php';
?>
