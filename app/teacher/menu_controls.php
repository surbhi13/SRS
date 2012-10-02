<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<?php 
date_default_timezone_set('America/New_York');
$date = date('m/d/Y h:i:s a', time());
//echo "Logged in since:".$date;
ob_start("ob_gzhandler");
include("connection.php");
session_start();
	
$userID = mysql_real_escape_string($_POST['userID']);
?>
<h1 align="center">Student Response System- Teacher Menu</h1>
<form action="logout.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>">
<input align="right" type="image" id="signOutButton" src="images/signOutButton.png" name="submit" onmouseover="this.src='images/signOutButton_glow.png'" onmouseout="this.src='images/signOutButton.png'"/>
</form>
<form action="menu_controls.php" method="POST">
<input type="submit" name="submit" value="Main Menu"/>
<input type="hidden" name="userID" value="<?=$userID?>"/>
</form>
<HR size="3" width="100%" color="blue">

<?
//Select appropriate record from the table
	$query = "select accessLevel, firstName, lastName 
			from users 
			where userID = '$userID'"; //using username as key, username is not changeable
	$qry_result = mysql_query($query) or die(mysql_error());

	$row = mysql_fetch_array($qry_result);

	$last = $row[lastName];
	$first = $row[firstName];
?>
<br>
Welcome <?=$first?> <?=$last?>,
<div align="center"><iframe src="mycourses.php" width="1000" height="1000" frameBorder="0"></iframe></div>

