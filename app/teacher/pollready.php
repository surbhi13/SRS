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
	$m = mysql_real_escape_string($_POST['mns']);
	$s = mysql_real_escape_string($_POST['scs']);
	

	$query = "UPDATE quizQuestions SET minutes= '$m', seconds = '$s' WHERE quizID= '$quizID' and questionNo = '$questionNo'"; 
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());

	$query = "SELECT totalQuestions,title,description from quizAssignments WHERE quizID='$quizID'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	$totalQuestions = $row[totalQuestions];
	
	?>
 
	<h1 align = "center"><?=$row[title]?></h1>
	
	<HR size="3" width="100%" color="blue">


	<?

	$query = "SELECT questionText,questionNo from quizQuestions WHERE quizID='$quizID' and questionNo='$questionNo'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	
	$row = mysql_fetch_array($qry_result);
	?>

	<h2><?=$row[questionNo]?>. <?=$row[questionText]?></h2>

	<?
	$query = "SELECT * from quizOptions WHERE quizID='$quizID' and questionNo='$questionNo'";
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($qry_result)){
	?>
	
	<?=$row[optionText]?><br><br>
	<?
	} //End of display

?> 
	
<form action="pollready.php" method="POST">
<input type="hidden" id="mns" value="<?=$m?>"/>
<input type="hidden" id="scs" value="<?=$s?>"/>
<input type="hidden" id="quizID" value="<?=$quizID?>"/>
<input type="hidden" id="start" value="1"/>
<input type="hidden" id="questionNo" value="<?=$questionNo?>"/>
<input type="submit" id="btnct" value="START" onclick="countdownTimer()"/>
</form>

<?

/*$start = mysql_real_escape_string($_POST['start']);

if($start == 1){*/

$current_time = date ("Y-m-d H:i:s");
//echo "Start Time:".$current_time;
?> <br>
<?

$query = "UPDATE quizQuestions SET startTime = '$current_time' WHERE quizID ='$quizID' AND questionNo= '$questionNo'";
$qry_result = mysql_query($query) or die('Timestamp for timer was not inserted');


$query = "SELECT startTime from quizQuestions WHERE quizID= '$quizID' and questionNo = '$questionNo'"; 
		//Execute query
	$qry_result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($qry_result);
	$startTime = $row[startTime];
	$dateinsec=strtotime($startTime);
	$endTime=$dateinsec+$s;
	$endTime= date('Y-m-d H:i:s',$endTime);	


//echo "End Time:".$endTime;
$query = "UPDATE quizQuestions SET endTime='$endTime' WHERE quizID= '$quizID' and questionNo = '$questionNo'"; 
		//Execute query
$qry_result = mysql_query($query) or die(mysql_error());


//Update the times on questionTemp as well
/*$query = "UPDATE questionTemp SET startTime = '$current_time' WHERE quizID ='$quizID' AND questionNo= '$questionNo'";
$qry_result = mysql_query($query) or die('Timestamp for timer was not inserted');*/
?> 

<h1>Countdown Timer: &nbsp; <span id="showmns">00</span>:<span id="showscs">00</span></h1>
<script type="text/javascript"><!--
    /* Function to display a Countdown timer with starting time from a form */
// sets variables for minutes and seconds
var ctmnts = 0;
var ctsecs = 0;
var startchr = 0;       // used to control when to read data from form

function countdownTimer() {

  // http://www.coursesweb.net/javascript/
  // if $startchr is 0, and form fields exists, gets data for minutes and seconds, and sets $startchr to 1
  if(startchr == 0 && document.getElementById('mns') && document.getElementById('scs')) {
    // makes sure the script uses integer numbers
    ctmnts = parseInt(document.getElementById('mns').value) + 0;
    ctsecs = parseInt(document.getElementById('scs').value) * 1;

    // if data not a number, sets the value to 0
    if(isNaN(ctmnts)) ctmnts = 0;
    if(isNaN(ctsecs)) ctsecs = 0;

    // rewrite data in form fields to be sure that the fields for minutes and seconds contain integer number
    document.getElementById('mns').value = ctmnts;
    document.getElementById('scs').value = ctsecs;
    startchr = 1;
    document.getElementById('btnct').setAttribute('disabled', 'disabled');     // disable the button
  }

  // if minutes and seconds are 0, sets $startchr to 0, and return false
  if(ctmnts==0 && ctsecs==0) {
    startchr = 0;
    document.getElementById('btnct').removeAttribute('disabled');     // remove "disabled" to enable the button

    /* HERE YOU CAN ADD TO EXECUTE A JavaScript FUNCTION WHEN COUNTDOWN TIMER REACH TO 0 */

    return false;
  }
  else {
    // decrease seconds, and decrease minutes if seconds reach to 0
    ctsecs--;
    if(ctsecs < 0) {
      if(ctmnts > 0) {
        ctsecs = 59;
        ctmnts--;
      }
      else {
        ctsecs = 0;
        ctmnts = 0;
      }
    }
  }

  // display the time in page, and auto-calls this function after 1 seccond
  document.getElementById('showmns').innerHTML = ctmnts;
  document.getElementById('showscs').innerHTML = ctsecs;
  setTimeout('countdownTimer()', 1000);
}
//-->
</script>
<?
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

$questionNo++;
?>
To poll sequentially (first to last), press the <b>"Next Question"</b> button. If you would like to poll questions of your choice press <b>"Choose question"</b> button which will redirect you to the list of questions in this quiz. <br><br>
<style>
  form { display: inline; }
</style>
<form action="poller.php" method="POST">
<input type="hidden" name="questionNo" value="<?=$questionNo?>"/>
<input type="hidden" name="quizID" value="<?=$quizID?>"/>
<input type="submit" name="submit" value="Next Question"/>
</form>
<form action="pollquiz.php" method="POST">
<input type="hidden" name="quizID" value="<?=$quizID?>"/>
<input type="submit" name="submit" value="Choose Question"/>
</form>
<form action="graph.php" target="myform" method="POST">
<input type="hidden" name="one" value="<?=$one?>"/>
<input type="hidden" name="two" value="<?=$two?>"/>
<input type="hidden" name="three" value="<?=$three?>"/>
<input type="hidden" name="four" value="<?=$four?>"/>
<input type="hidden" name="five" value="<?=$five?>"/>
<input type="hidden" name="endTime" value="<?=$endTime?>"/>
<input type="submit" name="submit" value="Compute Graph"/>
</form>
<br>
<hr color="blue">
<br>
X Axis: Option # <br>Y Axis: Responses in %
<h2 align="left">Response Graph</h2>
<div align="center"><iframe name="myform" id="myform" src="graph.php" width="1000" height="1000" frameBorder="0"></iframe></div>
