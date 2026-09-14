<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/split.class.php';
	include '../../lib/message.class.php';

	
	$query = "select id, year, description, date_format(date,'%d %M %Y') as date_name
		from asset_depriciation		
		order by year desc ,date desc, date
		limit 0,100";

	$data = mysqli_query($con, $query)  or die(mysql_error());
		
	$split = new Split('index.php',$total['total'],25,25);

	include '../../lib/connection-close.php';
?>
