<?php
include '../login/auth.php';
include 'addValidate.php';
include '../../lib/connection.php';
include '../../lib/thumbnail.class.php';

$categoryId = $_POST['categoryId'];
$name = $_POST['name'];
$code = $_POST['code'];
$size = $_POST['size'];
$foto = $_FILES['foto'];

$query = "insert asset
		set category_id = '$categoryId',
		  name = '$name',
		  code = '$code',
		  size = '$size'";

mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select if(max(id)=null,0,max(id)) as id 
		from asset";

$data = mysqli_query($con, $query) or die(mysqli_error($con));
$assetId = mysqli_fetch_array($data);

strlen($foto['name']) > 0 ? saveFile($assetId['id'], '', uploadFile($foto, 1, $assetId['id']), 1) : false;

function saveFile($assetId, $title, $fotoName, $isPrimary)
{
	$path = 'asset_' . $assetId . '/' . $fotoName;
	$pathThumb = 'asset_' . $assetId . '/thumb/' . $fotoName;

	$query = "update asset
			set foto_thumb = '$pathThumb',
			  foto = '$path'
			where
			  id = '$assetId'";

	mysql_query($query) or die(mysql_error());
}

function uploadFile($file, $index, $productId)
{
	$pathDestination = dirname(__FILE__) . '/../asset/foto/';

	$tmp = explode('.', $file['name']);
	$ext = $tmp[count($tmp) - 1];

	$pathDestinationFolder = $pathDestination . 'asset_' . $productId;
	$fotoName = 'foto' . $index . '.' . $ext;

	is_dir($pathDestinationFolder) != true ? mkdir($pathDestinationFolder, 0775) : false;
	move_uploaded_file($file['tmp_name'], $pathDestinationFolder . '/' . $fotoName);

	$pathDestinationFolderThumb = $pathDestinationFolder . '/thumb';
	is_dir($pathDestinationFolderThumb) != true ? mkdir($pathDestinationFolderThumb, 0775) : false;

	//thumbnail::create($pathDestinationFolder.'/'.$fotoName, $pathDestinationFolder.'/'.$fotoName,600);
	thumbnail::create($pathDestinationFolder . '/' . $fotoName, $pathDestinationFolderThumb . '/' . $fotoName, 200);

	return $fotoName;
}

include '../../lib/connection-close.php';

header('Location:index.php?msg=addSuccess');
?>