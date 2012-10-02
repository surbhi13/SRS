<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'root'; //Change local password here
$db_name = 'mydb';

$connect = @mysql_connect("$db_host", "$db_user", "$db_pass");

if (!$connect) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("mydb") or die(mysql_error());

?>
