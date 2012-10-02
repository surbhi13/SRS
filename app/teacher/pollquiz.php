<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>

<HR size="3" width="100%" color="blue">


<?php 
ob_start("ob_gzhandler");
include("connection.php");
include("timer.php");
session_start();

$quizID = $_SESSION['quizID'];
$questionNo = $_SESSION['questionNo'];


	$quizID = mysql_real_escape_string(stripslashes($_POST['quizID']));
	$getOption = mysql_real_escape_string(stripslashes($_POST['getOption']));
	$questionNo = 1;
	$userID = mysql_real_escape_string($_POST['userID']);

	$query = "SELECT totalQuestions,title,description from quizAssignments WHERE quizID='$quizID'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	$totalQuestions = $row[totalQuestions];
	
	?>
 
	<h1><?=$row[title]?></h1>
	
	<?
	
	while($questionNo <= $totalQuestions){

	$query = "SELECT questionText,questionNo from quizQuestions WHERE quizID='$quizID' and questionNo='$questionNo'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	?>

	<h2><?=$row[questionNo]?>. <?=$row[questionText]?></h2>

	<?
	$query = "SELECT * from quizOptions WHERE quizID='$quizID' and questionNo='$questionNo'"; //To get 5 options only!
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($qry_result)){
	?>
	
	<?=$row[optionText]?><br><br>
	<?
	}//end while
	
	$query = "INSERT into questionTemp (quizID) values ('$quizID')"; //add Access Level and teacherID add 2
	$qry_result = mysql_query($query) or die(mysql_error());
	?>
	<form action="poller.php" method="POST">
	<input type="submit" name="submit" value="Poll this question"/>
	<input type="hidden" name="quizID" value="<?=$quizID?>"/>
	<input type="hidden" name="questionNo" value="<?=$questionNo?>"/>
	</form>
	<hr color="blue">
	<?
	$questionNo++;
	} //end while
	?>

	<br><br><br>
			

