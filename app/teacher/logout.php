<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

<body>
<h1 align="center">Student Response System</h1>

<HR size="3" width="100%" color="blue">
<?
ob_start("ob_gzhandler");

include("connection.php");
session_start();

$userID = mysql_real_escape_string($_POST['userID']);


$time = date ("Y-m-d H:i:s");

$query="UPDATE users SET loggedIn = '0', logoutTime='$time' WHERE userID = '$userID'";
$qry_result = mysql_query($query) or die(mysql_error());

?>
Thank you for using Student Response System. See you next time!
<meta http-equiv="refresh" content="3; URL=login.html">
