<?php
include '../login/auth.php';
include '../../lib/connection.php';

$id = $_GET['id'];

$query = "delete from member
		where id='$id'";

mysqli_query($con, $query) or die(mysqli_error($con));

$query = "delete from user
		where member_id='$id'";

mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';

header('Location:index.php?msg=deleteSuccess&type=4');
?>