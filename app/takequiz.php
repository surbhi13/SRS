<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<h1 align="Center">Student Response System- Student Menu</h1>
<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();
$userID = mysql_real_escape_string($_POST['userID']);
$quizID = mysql_real_escape_string(stripslashes($_POST['quizID']));
?>
<form action="logout.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>">
<input align="right" type="image" id="signOutButton" src="images/signOutButton.png" name="submit" onmouseover="this.src='images/signOutButton_glow.png'" onmouseout="this.src='images/signOutButton.png'"/>
</form>
<form action="studentmenu.php" method="POST">
<input type="submit" name="submit" value="Main Menu"/>
<input type="hidden" name="userID" value="<?=$userID?>"/>
</form>
<HR size="3" width="100%" color="blue">


<?php 

	//$userID =  mysql_real_escape_string(stripslashes($_POST['userID']));
	
	$optionNo = mysql_real_escape_string(stripslashes($_POST['response']));
	$questionNo =  mysql_real_escape_string(stripslashes($_POST['questionNo']));
	
	$query = "SELECT * from quizAssignments WHERE quizID='$quizID'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	$courseID = $row[courseID];


	$query = "SELECT * from courses WHERE courseID='$courseID'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	$courseTitle = $row[courseTitle];

	?>
	Hello <?=$userID?>! <br> Welcome to <?=$courseTitle?>, quiz # <?=$quizID?>.<br>Please press the <b> Display Question </b> button periodically, to refresh this page. Thank you.<br><br>
	
	<?
	  $time = date ("Y-m-d H:i:s");
	  $query = "INSERT into logIns (loggedIn, userID, quizID, loginTime) values ('1', '$userID', '$quizID', '$time')"; 
		//Execute query
	  $qry_result = mysql_query($query) or die(mysql_error());
	
	?>
	<form action="pollTheQuiz.php" target="myform" method="POST">
	<input type="hidden" name="quizID" value="<?=$quizID?>">
	<input type="hidden" name="userID" value="<?=$userID?>">
	<input type="submit" name="submit" value="Display question">
	</form>

	<div align="center"><iframe name="myform" id="myform" src="pollTheQuiz.php" width="1000" height="1000" frameBorder="0"></iframe></div>
	
	
