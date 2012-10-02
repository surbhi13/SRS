<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<h1 align = "center">myCourses</h1>

<HR size="3" width="100%" color="blue">
<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();

$userID = $_SESSION['userID']; 

//echo $userID;

$query = "SELECT courseID, semester, year, section from courseAssignments WHERE teacherID='$userID'";
$result=mysql_query($query) or die(mysql_error());

$result_array = array();
while($row = mysql_fetch_assoc($result))
{
    $id[] = $row[courseID];
    $sem[] = $row[semester];
    $yr[] = $row[year];
    $sec[] = $row[section];
}

foreach($id as $courseID){
	
	$query = "SELECT courseTitle, courseDescription from courses WHERE courseID='$courseID'";
	$result=mysql_query($query) or die(mysql_error());
	
	while($row = mysql_fetch_assoc($result))
	{
		$title[] = $row[courseTitle];
		$desc[] = $row[courseDescription];
	}
}

?>
Below is a list of all the courses that you are assigned to..<br>
Press <i>Enter course</i> to enter a course and perform any of the following actions:
<ul>
<li>Add students
<li>Make/poll a quiz</li>
<li>View a quiz gradebook</li>
</ul>

<?
for($i = 0; $i < sizeof($id); $i++) {
?>
	<h2><?echo ($i+1).". ".$title[$i]. "-SEC ".$sec[$i]."-".$sem[$i]." ".$yr[$i];?></h2>
<?
	$section = $sec[$i];
	echo $desc[$i];
?>
	<form action="menu.php" method="POST">
	<input type= "hidden" name="userID" value="<?=$userID?>" />
	<input type= "hidden" name="section" value="<?=$sec[$i]?>">
	<input type= "hidden" name="courseID" value="<?=$id[$i]?>" />
	<input type= "submit" name="submit" value="Enter course" />
	</form>
<?
}
?>
