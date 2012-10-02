
<?php

// Configure connection settings

$db = 'mydb';
$db_admin = 'root';
$db_password = 'root';

// Connect to DB

$sql = mysql_connect("localhost", $db_admin, $db_password)
or die(mysql_error());

mysql_select_db("$db", $sql);


// Fetch the data

$query = "SELECT currentQNo FROM questionTemp";
$qry_result = mysql_query($query) or die(mysql_error());

$row = mysql_fetch_array($qry_result);

// Return the results, loop through them and echo
$questionToPoll = $row[currentQNo];

$quizID = 8585;

$query = "SELECT startTime, endTime from quizQuestions WHERE questionNo= '$questionToPoll' AND quizID ='$quizID'";
$qry_result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($qry_result);
	
$start = $row[startTime];
$end = $row[endTime];

$current_time = date ("Y-m-d H:i:s");

if(($current_time >= $start) && ($current_time <= $end)){
echo "Question currently being polled: ".$questionToPoll;
echo "Display question";
}
else{
echo "Please wait until professor starts polling a question. Thank you for your patience...";
}

?>

