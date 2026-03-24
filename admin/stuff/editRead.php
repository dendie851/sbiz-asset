<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$id = $_REQUEST['id'];

	$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	
	$query = "select id, code, category_id, name, size, foto, foto_thumb 
		from asset
		where id = '$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);


	include '../../lib/connection-close.php';
?>
