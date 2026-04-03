<?php
include dirname(__FILE__) . '/../config/config.php';

$con = mysqli_connect($config['db']['server'], $config['db']['username'], $config['db']['password'], $config['db']['database']);

#$con = mysql_connect($config['db']['server'],$config['db']['username'],$config['db']['password']);
#mysql_select_db($config['db']['database'],$con);

if (!defined('MYSQL_ASSOC')) {
    define('MYSQL_ASSOC', MYSQLI_ASSOC);
    define('MYSQL_NUM', MYSQLI_NUM);
    define('MYSQL_BOTH', MYSQLI_BOTH);
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link_identifier = null)
    {
        global $con;
        $connection = $link_identifier ?: $con;
        return mysqli_query($connection, $query);
    }
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH)
    {
        return mysqli_fetch_array($result, $result_type);
    }
    function mysql_fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }
    function mysql_fetch_object($result)
    {
        return mysqli_fetch_object($result);
    }
    function mysql_fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }
    function mysql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }
    function mysql_insert_id($link_identifier = null)
    {
        global $con;
        $connection = $link_identifier ?: $con;
        return mysqli_insert_id($connection);
    }
    function mysql_error($link_identifier = null)
    {
        global $con;
        $connection = $link_identifier ?: $con;
        return mysqli_error($connection);
    }
    function mysql_real_escape_string($string, $link_identifier = null)
    {
        global $con;
        $connection = $link_identifier ?: $con;
        return mysqli_real_escape_string($connection, $string);
    }
    function mysql_close($link_identifier = null)
    {
        global $con;
        $connection = $link_identifier ?: $con;
        return mysqli_close($connection);
    }
    function mysql_free_result($result)
    {
        return mysqli_free_result($result);
    }
}

?>