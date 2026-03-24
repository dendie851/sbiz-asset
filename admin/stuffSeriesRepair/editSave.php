<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../../lib/connection.php';

	$keyword = $_POST['keyword'];
	$id = $_POST['id'];	
	$description = $_POST['description'];	

	$tmp = explode('/',$_POST['dateRepair']);
	$dateRepair  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];	

	
	if(count($id) > 0 ) {
		$i=0;
		foreach($id as $val) {			
			$query = "insert asset_history
				   set date = '$dateRepair',
					  type = '1',
					  asset_series_id = '$val',
					  decription = '<b>Di Perbaiki</b><br />$description'";	
					  
			mysql_query($query) or die (mysql_error());	

			$i++;
		}
	}

	include '../../lib/connection-close.php';

	header('Location:index.php?id='.$assetId.'&msg=addSuccess&keyword='.$keyword);
?>
