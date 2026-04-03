<?php
include '../login/auth.php';
include '../../lib/connection.php';


$id = $_REQUEST['id'];

$query = "select id,name 
		from position
		where id='$id'";

$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$data = mysqli_fetch_array($tmp);

include '../../lib/connection-close.php';
?>