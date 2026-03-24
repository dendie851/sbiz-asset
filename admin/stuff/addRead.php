<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';

	$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());

	mysql_query($query) or die (mysql_error());

	$query = "select if(max(code)=null,0,max(code)) as code 
		from asset";

	$data = mysql_query($query) or die(mysql_error());
	$assetCode = mysql_fetch_array($data);
	$assetCodeSugest = str_pad((int) $assetCode['code'] + 1, 5, "0", STR_PAD_LEFT); 
	
	include '../../lib/connection-close.php';
?>
