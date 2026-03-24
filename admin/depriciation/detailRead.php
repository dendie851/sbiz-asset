<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	$id = $_REQUEST['id'];
	$depriciationId = $id;

	$query = "select id, year, description, date_format(date,'%d %M %Y') as date_name
		from asset_depriciation
		where id = '$id'";		
		
	$tmp = mysql_query($query) or die (mysql_error());
	$dataInfo = mysql_fetch_array($tmp);

	$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());

	include '../../lib/connection-close.php';
?>
