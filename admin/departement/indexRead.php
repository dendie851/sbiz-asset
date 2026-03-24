<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/message.class.php';

	$query = "select id,name,description,is_fix 
		from departement
		order by name";

	$data = mysql_query($query) or die (mysql_error());

	include '../../lib/connection-close.php';
?>
