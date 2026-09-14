<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/message.class.php';

	$type = $_REQUEST['type'];
	
	$query = "select id,name
		from category
		where is_delete = '0'
		order by name";

	$data = mysqli_query($con, $query); 

	include '../../lib/connection-close.php';
?>
