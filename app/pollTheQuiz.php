<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>

<HR size="3" width="100%" color="blue">

<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();

	if(isset($_POST['submit'])){
	$userID =  mysql_real_escape_string($_POST['userID']);
	$quizID = mysql_real_escape_string($_POST['quizID']);

	$current_time = date ("Y-m-d H:i:s");
	$query = "SELECT currentQNo from questionTemp where quizID = '$quizID'";
	$qry_result = mysql_query($query) or die(mysql_error());

	$row = mysql_fetch_array($qry_result);
	
	$questionToPoll = $row[currentQNo];
	//echo $questionToPoll;

	//Get the start and end time of the question currently being polled
	$query = "SELECT startTime, endTime from quizQuestions WHERE questionNo= '$questionToPoll' AND quizID ='$quizID'";
	$qry_result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($qry_result);
	
	$start = $row[startTime];
	$end = $row[endTime];
	
	//Synchronize with start and end time
	if(($current_time >= $start) && ($current_time <= $end)){

	$query = "SELECT minutes, seconds from quizQuestions WHERE questionNo= '$questionToPoll' AND quizID ='$quizID'";
	$qry_result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($qry_result);
	$m= $row[minutes];
	$s = $row[seconds];

	if($m == '0' && $s == '0'){
	echo "Error! Polling for this question has not begun yet, please wait for instructions from your professor.Thank you for your patience.";
	}//end if
	else {
	/*if(isset($_POST['submit'])){
		
	$query = "INSERT into quizRecordKeeper (questionNo, quizID, userID) values ('$questionToPoll', '$quizID','$userID')";
	$qry_result = mysql_query($query) or die(mysql_error());
	}*/

	$query = "SELECT endTime from quizQuestions WHERE questionNo= '$questionToPoll' AND quizID ='$quizID'";
	$qry_result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($qry_result);
	$endTime= $row[endTime];
	
	$loginTimeEx = strtotime($loginTime);
	$endTimeEx = strtotime($endTime);

	$query = "SELECT totalQuestions,title,description from quizAssignments WHERE quizID='$quizID'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	$totalQuestions = $row[totalQuestions];
	
	?>
 
	<h1><?=$row[title]?></h1>
	
	<?

	$query = "SELECT questionText,questionNo from quizQuestions WHERE quizID='$quizID' and questionNo='$questionToPoll'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	?>

	<h2><?=$row[questionNo]?>. <?=$row[questionText]?></h2>

	<?
	$query = "SELECT * from quizOptions WHERE quizID='$quizID' and questionNo='$questionToPoll'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($qry_result)){
	$optionNo = $row[optionNo];
	?>
	
	<?=$row[optionText]?><br><br>
	<?
	}//end while

	$current = date ("Y-m-d H:i:s");
	if($loginTimeEx < $endTimeEx){	
	?>
	
	<script type="text/javascript">
	function recordAnswer()
	{
	alert("Thank You! Your response " + document.forms["form"]["response"].value + " was recorded.")
	}
	</script>
	
	<form name="form" action="refresh.php" method="POST" onsubmit="recordAnswer()">
	<input type="hidden" name="quizID" value="<?=$quizID?>">
	<input type="hidden" name="userID" value="<?=$userID?>">
	<input type="hidden" name="questionNo" value="<?=$questionToPoll?>">
	<input type="hidden" name="answered" value="1">
	Please enter a response in terms of a single corresponding to the option.<br>
	Your response:<input type="text" name="response" id="response" maxlength="1" size="3"/>
	<input type="submit" value="Submit"/>
	</form>
	<?
		//Make provision for adding stuff when the countdown reaches zero- display that the poll has ended, and refresh.php
	}
	else{
	$query = "SELECT correctAns, optionNo, optionText from quizOptions WHERE quizID='$quizID' and correctAns='1' and questionNo='$questionToPoll'"; 
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
 	$row = mysql_fetch_array($qry_result);
	$correct = $row[correctAns];
	//echo "$correct";
	$optionNo = $row[optionNo];
	$optionText = $row[optionText];
	echo "Sorry! The time for this question has passed. The poll ended at ".$endTime.". ";
	?>
	<br>
	<?
	echo "Correct answer : Option number ".$optionNo." : ".$optionText;
	}//end if else
	}// end the first big loop
	}
	else{
	echo "Please wait until professor starts polling a question. Thank you for your patience.";	
	?>
	<script type="text/javascript">
	setTimeout(function () {
  	window.location.href= 'refresh.php'; // the redirect goes here
	},3000);
	</script>
	<?
	}

	}//end first if
	?>
	
