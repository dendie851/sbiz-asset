<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../../lib/connection.php';

	$keyword = $_POST['keyword'];
	$id = $_POST['id'];	
	$description = $_POST['description'];	

	$tmp = explode('/',$_POST['dateRemove']);
	$dateRemove  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];	
	
	if(count($id) > 0 ) {
		$i=0;
		foreach($id as $val) {	
			$query = "update asset_series
				set is_remove = '0'	
				where id = '$val'";
			mysqli_query($con, $query) or die(mysqli_error($con));
			
			$query = "insert asset_history
				   set date = '$dateRemove',
					  type = '3',
					  asset_series_id = '$val',
					  decription = '<b>Di Aktifkan Kembali Setelah dimusnahkan</b><br />$description'";	
					  
			mysqli_query($con, $query) or die(mysqli_error($con));	

			$i++;
		}
	}

	include '../../lib/connection-close.php';

	header('Location:index.php?id='.$assetId.'&msg=addSuccess&keyword='.$keyword);
?>
