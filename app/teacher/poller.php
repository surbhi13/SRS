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
	$questionNo = mysql_real_escape_string($_POST['questionNo']);
	$quizID =  mysql_real_escape_string($_POST['quizID']);

	//Updates the table with the question that is being currently polled
	$query = "UPDATE questionTemp set currentQNo = '$questionNo' where quizID = '$quizID'";
	$qry_result = mysql_query($query) or die(mysql_error());
?>
<hr>
Please press "Set time" to initiate the timer for your question.
<form action="pollready.php" method="POST">
<input type="hidden" name="questionNo" value="<?=$questionNo?>">
<input type="hidden" name="quizID" value="<?=$quizID?>">
Minutes: <input type="text" id="mns" name="mns" value="00" size="3" maxlength="3" /> &nbsp; &nbsp; Seconds: <input type="text" id="scs" name="scs" value="00" size="2" maxlength="2" /><br/>
<input type="submit" name="set_time" value="Set time"/>







