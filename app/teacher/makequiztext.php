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
ob_start("ob_gzhandler");
include("connection.php");
session_start();
$userID = $_SESSION['userID']; 
$courseID = mysql_real_escape_string($_POST['courseID']);
$section = mysql_real_escape_string($_POST['section']);
?>
Copy paste from an Excel file and enter in the following format:
<ul>
<li>Teacher userID</li>
<li>Course title (eg. MGCR 331)</li>
<li>Section</li>
<li>Semester</li>
<li>Year</li>
</ul>

<form action="makequiztext.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>" />
<input type="hidden" name="validate" value="1" />
Enter professor & course details:<br> <textarea name="validation" id="validation" rows="10" cols="50"></textarea>
<input type="submit" name="submit" value="Validate">

<?
$validate = mysql_real_escape_string($_POST['validate']);

if($validate == 1){
$text = trim(mysql_real_escape_string($_POST['validation']));

echo $text;

$arr = preg_split("/\r?\n/",$text);
print_r($arr[0]);

}
