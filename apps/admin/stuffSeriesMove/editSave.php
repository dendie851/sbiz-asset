<?php
include '../login/auth.php';
include 'editValidate.php';
include '../../lib/connection.php';

$keyword = $_POST['keyword'];
$id = $_POST['id'];
$locationId = $_POST['locationId'];
$description = $_POST['description'];

$tmp = explode('/', $_POST['dateMove']);
$dateMove = $tmp[2] . '-' . $tmp[1] . '-' . $tmp[0];

$query = "select name, alias
		from location
		where id = '$locationId'";
$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
$result = mysqli_fetch_array($tmp);
$locationName = $result['name'] . ' ' . $result['alias'];


if (count($id) > 0) {
	$i = 0;
	foreach ($id as $val) {
		$query = "update asset_series
				set location_id = '$locationId'	
				where id = '$val'";
		mysqli_query($con, $query) or die(mysqli_error($con));

		$query = "insert asset_history
				   set date = '$dateMove',
					  type = '2',
					  asset_series_id = '$val',
					  decription = '<b>Lokasi Pindah Ke: $locationName</b><br />$description'";

		mysqli_query($con, $query) or die(mysqli_error($con));

		$i++;
	}
}

include '../../lib/connection-close.php';

header('Location:index.php?id=' . $assetId . '&msg=addSuccess&keyword=' . $keyword);
?>