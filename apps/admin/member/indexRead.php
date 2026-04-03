<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/message.class.php';

$query = "select m.id, m.name, m.position_id, is_enabled,
			(select p.name from position as p where p.id = m.position_id) as position_name,
			(select u.username from user as u where u.member_id = m.id) as username_name
		from member as m
		order by name";

$data = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>