<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/message.class.php';

$query = "select id,name
		from fund
		where is_delete = '0'
		order by name";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>