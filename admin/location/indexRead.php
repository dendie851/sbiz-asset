<?php 
	include '../login/auth.php';
	include '../../lib/connection.php';
	include '../../lib/message.class.php';
	
	$level = isset($_REQUEST['level']) ? $_REQUEST['level'] : '1';
	$parentId = isset($_REQUEST['parentId']) ? $_REQUEST['parentId'] : '0';	

	$dataBreadcums = array();	
	$tmpParentId = $parentId;

	for($i=2; $i <= $level; $i++) {   
		$query = "select id, parent_id, name, alias,level
			from location
			where id = '$tmpParentId'";

		$tmp = mysql_query($query) or die(mysql_error());

		if(mysql_num_rows($tmp) > 0) {
			$data = mysql_fetch_array($tmp);	

			$tmpParentId = $data['parent_id'];
			$dataBreadcums[] = array($data['id'],$data['name']);
		}
	}

	$query = "select id, parent_id, name, alias, level, size, status
		from location
		where parent_id = '$parentId'
		and is_delete = '0'
		order by name";

	$data = mysql_query($query) or die(mysql_error());

	include '../../lib/connection-close.php';
?>
