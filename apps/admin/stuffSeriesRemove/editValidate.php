<?php 	
	include '../../lib/connection.php';

	$status = true;
	$msgError = array();
	
	$id = $_POST['id'];	

	if(count($id) < 1) {
		$status = false;
		$msgError['id'] = 'Tidak ada data yang dipilih';	
	}

	if($status == false) {
		include 'index.php';
		exit;
	}	
	
	include '../../lib/connection-close.php';	
?>
