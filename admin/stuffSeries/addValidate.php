<?php 	
	include '../../lib/connection.php';
	
	$status = true;
	$msgError = array();
	
	$assetId = $_POST['assetId'];	
	$noSeries = $_POST['noSeries'];

	if(strlen($noSeries) < 4) {
		$status = false;
		$msgError['noSeries'] = 'Nomor seri harus 4 digit';	
	}
		
	if(strlen($noSeries) < 1) {
		$status = false;
		$msgError['noSeries'] = 'Silakan mengisikan nomor seri';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
	
	include '../../lib/connection-close.php';	
?>
