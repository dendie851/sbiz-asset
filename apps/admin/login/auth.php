<?php
@session_start();
session_write_close(); // <--- Tambahkan ini
// Menyembunyikan semua error jenis Warning, Notice, dan Deprecated
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);


if (!isset($_SESSION['login'])) {
	header('Location:../login/index.php');
} else {
	if ($_SESSION['loginApp'] != 'simpleAsset') {
		header('Location:../login/index.php');
	}
}

$loginAccessDepartement = substr(str_replace('~', ',', $_SESSION['loginAccessDepartement']), -1 * (strlen(str_replace('~', ',', $_SESSION['loginAccessDepartement'])))) . '9999';
$loginAccessFund = substr(str_replace('~', ',', $_SESSION['loginAccessFund']), -1 * (strlen(str_replace('~', ',', $_SESSION['loginAccessFund'])))) . '9999';
?>