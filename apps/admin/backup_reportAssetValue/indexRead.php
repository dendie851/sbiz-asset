<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/split.class.php';
include '../../lib/message.class.php';

$fundId = isset($_REQUEST['fundId']) ? $_REQUEST['fundId'] : 'x';
$departementId = isset($_REQUEST['departementId']) ? $_REQUEST['departementId'] : 'x';
$referencePrice = isset($_REQUEST['referencePrice']) ? $_REQUEST['referencePrice'] : 0;
$categoryAssetId = isset($_REQUEST['categoryAssetId']) ? $_REQUEST['categoryAssetId'] : array();
$dataCategoryInfo = null;

if (isset($_POST['dateBuy'])) {
	$tmp = explode('/', $_POST['dateBuy']);
	if (count($tmp) > 0) {
		$dateBuy = $tmp[2] . '-' . $tmp[1] . '-' . $tmp[0];
	} else {
		$dateBuy = '';
	}
} else {
	if (strlen($_REQUEST['dateBuy']) > 0) {
		$dateBuy = $_REQUEST['dateBuy'];
	} else {
		$dateBuy = '--';
	}
}

if (isset($_REQUEST['condition'])) {
	if (is_array($_REQUEST['condition'])) {
		$condition = implode(',', $_REQUEST['condition']);
	} else {
		$condition = explode(',', $_REQUEST['condition']);
		$tmp = array();
		foreach ($condition as $val) {
			$tmp[] = "'" . $val . "'";
		}
		$condition = implode(',', $tmp);
		$condition;
	}
} else {
	$_REQUEST['condition'] = array(0, 1, 2);
	$condition = implode(',', $_REQUEST['condition']);
}

$where = '';
$where .= $fundId != 'x' ? " and ase.fund_id = '$fundId' " : " and ase.fund_id in ($loginAccessFund) ";
$where .= $departementId != 'x' ? " and ase.departement_id = '$departementId' " : " and ase.departement_id in ($loginAccessDepartement) ";
$where .= $condition != 'x' ? " and ase.cond in ($condition) " : " ";


if (!empty($categoryAssetId)) {
	if (is_array($categoryAssetId)) {
		$categoryAssetIdValue = implode(',', $categoryAssetId);
	} else {
		$categoryAssetIdValue = $categoryAssetId;
	}

	if (strlen($categoryAssetIdValue) > 0) {
		$query = "select id,name 
				from category
				where is_delete = '0'
				and id  in ($categoryAssetIdValue)
				order by name";
	} else {
		$query = "select id,name 
				from category
				where is_delete = '0'
				order by name";
	}
	$dataCategory = mysql_query($query) or die(mysql_error());
	$dataCategoryInfo = mysql_query($query) or die(mysql_error());
} else {

	$query = "select id,name 
			from category
			where is_delete = '0'
			order by name";
	$dataCategory = mysql_query($query) or die(mysql_error());
}


$query = "select id,name 
		from category
		where is_delete = '0'
		order by name";
$dataCategoryAsset = mysql_query($query) or die(mysql_error());


$query = "select id,name
		from fund
		where is_delete = '0'
		  and id in ($loginAccessFund)		   	
		order by name";
$dataFund = mysql_query($query) or die(mysql_error());

$query = "select id,name
		from departement
		where id in ($loginAccessDepartement)
		order by name";

$dataDepartement = mysql_query($query) or die(mysql_error());

$query = "select id,name
		from fund
		where id = '$fundId'
		order by name";
$tmp = mysql_query($query) or die(mysql_error());
$printDataFund = mysql_fetch_array($tmp);

$query = "select id,name
		from departement
		where id = '$departementId'
		order by name";
$tmp = mysql_query($query) or die(mysql_error());
$printDataDepartement = mysql_fetch_array($tmp);

include '../../lib/connection-close.php';
?>