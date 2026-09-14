<?php 
include dirname(__FILE__).'/../config/config.php';

$con = mysqli_connect($config['db']['server'], $config['db']['username'], $config['db']['password'], $config['db']['database']);

#$con = mysql_connect($config['db']['server'],$config['db']['username'],$config['db']['password']);
#mysql_select_db($config['db']['database'],$con);
 
?>
