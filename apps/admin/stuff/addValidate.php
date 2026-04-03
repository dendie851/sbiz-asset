<?php
include '../../lib/connection.php';

$status = true;
$msgError = array();

$code = $_POST['code'];
$query = "select count(id) as jumlah
		from asset
		where code = '$code'";

$tmp = mysqli_query($con, $query) or die(mysqli_error($con));

$data = mysqli_fetch_array($tmp);
$jml = $data['jumlah'];

if ($jml > 0) {
	$status = false;
	$msgError['code'] = 'Kode asset sudah digunakan';
}


if (strlen($code) < 5) {
	$status = false;
	$msgError['code'] = 'Kode asset harus 5 digit';
}


if (strlen(trim($_POST['code'])) < 1) {
	$status = false;
	$msgError['code'] = 'Silakan mengisikan kode asset';
}

if (strlen(trim($_POST['name'])) < 1) {
	$status = false;
	$msgError['name'] = 'Silakan mengisikan name asset';
}

if ($status == false) {
	include 'add.php';
	exit;
}

include '../../lib/connection-close.php';
?>