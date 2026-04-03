<?php
include '../login/auth.php';
include '../../lib/connection.php';

$id = $_GET['id'];

$query = "delete from departement
		where id='$id'";

mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';

header('Location:index.php?msg=deleteSuccess');
?>