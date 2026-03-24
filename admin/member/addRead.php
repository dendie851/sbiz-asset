<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';	
	
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

	include '../../lib/connection-close.php';	
?>
