<?php
include '../login/auth.php';
include 'addValidate.php';
include '../../lib/connection.php';

$name = $_POST['name'];
$description = $_POST['description'];

$query = "insert departement
		set name = '$name',
		  description = '$description'";

mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';

header('Location:index.php?msg=addSuccess');
?>