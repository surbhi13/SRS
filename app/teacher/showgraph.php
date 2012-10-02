<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();

	$quizID = mysql_real_escape_string($_POST['quizID']);
	$questionNo = mysql_real_escape_string($_POST['questionNo']);

$query ="SELECT COUNT(optionNo) AS option1 FROM quizRecordkeeper WHERE optionNo='1' and quizID= '$quizID' and questionNo='$questionNo'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
$option1 = $row['option1']*100;

$query ="SELECT COUNT(optionNo) AS option2 FROM quizRecordkeeper WHERE optionNo='2' and quizID= '$quizID' and questionNo='$questionNo'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
$option2 = $row['option2']*100;

$query ="SELECT COUNT(optionNo) AS option3 FROM quizRecordkeeper WHERE optionNo='3' and quizID= '$quizID' and questionNo='$questionNo'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
$option3 = $row['option3']*100;

$query ="SELECT COUNT(optionNo) AS option4 FROM quizRecordkeeper WHERE optionNo='4' and quizID= '$quizID' and questionNo='$questionNo'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
$option4 = $row['option4']*100;

$query ="SELECT COUNT(optionNo) AS option5 FROM quizRecordkeeper WHERE optionNo='5' and quizID= '$quizID' and questionNo='$questionNo'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
$option5 = $row['option5']*100;

$query ="SELECT COUNT(isAnswered) AS totalNo FROM quizRecordkeeper WHERE quizID= '$quizID' and questionNo='$questionNo'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
$totalNo = $row['totalNo'];

$one = $option1/$totalNo;
$two = $option2/$totalNo;
$three = $option3/$totalNo;
$four = $option4/$totalNo;
$five = $option5/$totalNo;
?>
<form action="graph.php" method="POST">
<input type="hidden" name="one" value="<?=$one?>"/>
<input type="hidden" name="two" value="<?=$two?>"/>
<input type="hidden" name="three" value="<?=$three?>"/>
<input type="hidden" name="four" value="<?=$four?>"/>
<input type="hidden" name="five" value="<?=$five?>"/>
<input type="submit" name="submit" value="Show Graph"/>
</form>

