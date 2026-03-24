<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/message.class.php';

	$id = $_REQUEST['id'];

	$query = "select id, name, alias, size, status
		from location
		where id = '$id'";

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);	

	include '../../lib/connection-close.php';
?>
