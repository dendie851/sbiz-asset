<?php 	
	$status = true;
	$msgError = array();

	$year = $_REQUEST['year'];


	if(strlen(trim($year)) != '4') {
		$status = false;
		$msgError['year'] = 'Silakan isi tahun dengan empat digit';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
