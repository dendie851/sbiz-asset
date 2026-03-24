<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../../lib/connection.php';
	include '../../lib/thumbnail.class.php';

	$id = $_POST['id'];
	$categoryId = $_POST['categoryId'];
	$name = $_POST['name'];
	$code = $_POST['code'];	
	$size = $_POST['size'];	
	$foto = $_FILES['foto'];

	$query = "update asset
		set category_id = '$categoryId',
		  name = '$name',
		  code = '$code',
		  size = '$size'
		where  
		 id = '$id'";

	mysql_query($query) or die (mysql_error());


	strlen($foto['name']) > 0 ? updateFile($id,'','',uploadFile($foto,1,$id),1) : '';

	$delete = $_POST['delete']; 

	if(count($delete)  > 0) {
		foreach($delete as $val) {
			$query = "select foto, foto_thumb 
				from asset		
				where id = '$val'";

			$tmp = mysql_query($query) or die(mysql_error());	
			$data = mysql_fetch_array($tmp);

			is_file(dirname(__FILE__).'/../asset/foto/'.$data['foto']) ? unlink(dirname(__FILE__).'/../asset/foto/'.$data['foto']) : false;
			is_file(dirname(__FILE__).'/../asset/foto/'.$data['foto_thumb']) ? unlink(dirname(__FILE__).'/../asset/foto/'.$data['foto_thumb']) : false;

			$query = "update asset
				set foto = '',
				  foto_thumb = ''
				where id = '$val'";
			
			mysql_query($query) or die(mysql_error());	
		}
	}

	function updateFile($productId,$fotoId,$title,$fotoName,$isPrimary) {
		$path = 'asset_'.$productId.'/'.$fotoName;
		$pathThumb = 'asset_'.$productId.'/thumb/'.$fotoName;

		$query = "update asset
			set foto = '$path',
			  foto_thumb = '$pathThumb'
			where id = '$productId'";
			
		mysql_query($query) or die(mysql_error());		
	}	

	function uploadFile($file,$index,$productId) {
		$pathDestination = dirname(__FILE__).'/../asset/foto/';

		$tmp = explode('.',$file['name']);		
		$ext = $tmp[count($tmp)-1];


		$pathDestinationFolder = $pathDestination.'asset_'.$productId;
		$fotoName = 'foto'.$index.'.'.$ext;

		is_dir($pathDestinationFolder) != true ? mkdir($pathDestinationFolder, 0775) : false;
		move_uploaded_file($file['tmp_name'], $pathDestinationFolder.'/'.$fotoName);

		$pathDestinationFolderThumb = $pathDestinationFolder.'/thumb';
		is_dir($pathDestinationFolderThumb) != true ? mkdir($pathDestinationFolderThumb, 0775) : false;

		//thumbnail::create($pathDestinationFolder.'/'.$fotoName, $pathDestinationFolder.'/'.$fotoName,600);
		thumbnail::create($pathDestinationFolder.'/'.$fotoName, $pathDestinationFolderThumb.'/'.$fotoName,200);

		return $fotoName;
	}

	include '../../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
