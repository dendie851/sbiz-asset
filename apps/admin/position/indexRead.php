<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/message.class.php';

$type = $_REQUEST['type'];

$query = "select id,name
		from position
		where is_delete = '0'
		order by name";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>