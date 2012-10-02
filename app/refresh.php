<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<HR size="3" width="100%" color="blue">

<script type="text/javascript">
	function timedMsg()
	{
		var t=setInterval("change_time();",1000);
	}
	function change_time()
	{
		var d = new Date();
		var curr_hour = d.getHours();
		var curr_min = d.getMinutes();
		var curr_sec = d.getSeconds();	
		document.getElementById('time').innerHTML =
	curr_hour+':'+curr_min+':'+curr_sec;
	}
	timedMsg();
	</script>
	<table>
			<tr>
				<td>Current time is :</td>
				<td id="time"></td>
			<tr>
	</table>
<?
	ob_start("ob_gzhandler");
	include("connection.php");
	session_start();
	$answered = mysql_real_escape_string(stripslashes($_POST['answered']));
	$userID =  mysql_real_escape_string(stripslashes($_POST['userID']));
	$quizID = mysql_real_escape_string(stripslashes($_POST['quizID']));
	$optionNo = mysql_real_escape_string(stripslashes($_POST['response']));
	$questionNo =  mysql_real_escape_string(stripslashes($_POST['questionNo']));

	if($answered == 1) {

	$current_time = date ("Y-m-d H:i:s");
	//echo $current_time;

	$recordExits = "no";
	$query  = "SELECT isAnswered, optionNo, answerTime FROM quizRecordkeeper WHERE quizID = '$quizID' and questionNo = '$questionNo' and userID = 		'$userID'";
	$qry_result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($qry_result))
			{ 
				$recordExists = "yes";
			}

	//echo $recordExists;
	if($recordExists == "yes"){

		$query = "UPDATE quizRecordkeeper SET  isAnswered = '1', optionNo = '$optionNo', answerTime = '$current_time' WHERE quizID = '$quizID' and 			questionNo = '$questionNo' and userID = '$userID'";
	$qry_result = mysql_query($query) or die(mysql_error());
 
	}//end if
	else{
		$query = "INSERT into quizRecordkeeper  (isAnswered, optionNo, answerTime,quizID, questionNo, userID) values ('1','$optionNo','$current_time','$quizID','$questionNo','$userID')"; 
		$qry_result = mysql_query($query) or die(mysql_error());
	
	}//end else

	/*$query = "SELECT correctAns, optionNo, optionText from quizOptions WHERE quizID='$quizID' and correctAns='1' and questionNo='$questionNo'"; 
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
 	$row = mysql_fetch_array($qry_result);
	$correct = $row[correctAns];
	$option = $row[optionNo];

	if($optionNo == $option){
		$query = "UPDATE quizRecordkeeper SET isCorrect = '1' WHERE quizID = '$quizID' and questionNo = '$questionNo' and userID = '$userID'";
		$qry_result = mysql_query($query) or die(mysql_error());
		
	}*/

	}//end if

	
	?>
	Please press the "Display question" button to refresh this page. Thank you!
	

