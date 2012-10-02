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

//echo $courseID;
//echo $section;

$query = "SELECT semester, year from courseAssignments WHERE courseID='$courseID'";
$result=mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);

$sem = $row[semester];
$yr = $row[year];

$query = "SELECT courseTitle from courses WHERE courseID='$courseID'";
$result=mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);

$title = $row[courseTitle];

?>
<h2 align = "center">Quiz Menu</h2>
You are now viewing: <b><? echo $title." SEC ".$section.", ".$sem." ".$yr?></b>
<hr color="blue">

What would you like to do today?<br><br>
<?
 /*<b>View/Edit login information</b><br>
<ul>
	<li>Please note that you may not change your userID. 
	<li>You can however change your password, first name and last name registered with us using this menu.
	<li>Your userID will remain as assigned by admin.
</ul>
	
 <?
	//Select appropriate record from the table
	$query = "select accessLevel, firstName, lastName, 
			userID, password 
			from users 
			where userID = '$userID'"; //using username as key, username is not changeable

	$qry_result = mysql_query($query) or die(mysql_error());

	while($row = mysql_fetch_array($qry_result)){
?>
	<form action="menu.php" method="POST">
	<input type="hidden" name="userID" value="<?=$userID?>"/>
	<input type="hidden" name="loginedit" value="1" />
	<p>Last name: <input type="text" size="20" name="lastName" value="<?=$row[lastName]?>"/></p>
	<p>First name: <input type="text" size="20" name="firstName" value="<?=$row[firstName]?>"/></p>
	<p>Old Password: <?=$row[password]?></p>
	<p>New Password: <input type="password" size="8" name="password" value="" onkeyup="if (this.value.length > 8) { alert('Passwords are atmost 8 characters'); this.value = this.value.substr(0,8); }" /></p>
	<p>Retype New Password: <input type="password" size="8" name="passwordRe" value=""/></p>
	<input type="submit" name="submit" value="Edit login" /><br>
	</form>
<?	
	}
if($loginedit == 1){
	$lastName = mysql_real_escape_string(stripslashes($_POST['lastName']));
	$firstName = mysql_real_escape_string(stripslashes($_POST['firstName']));
	$password = mysql_real_escape_string($_POST['password']);
	$passwordRe = mysql_real_escape_string($_POST['passwordRe']);

	$userID=$_SESSION['userID'];
	
		if($passwordRe!= $password){
		?>
			<h2>Error!</h2>
			<p>Both passwords do not match, kindly re try the password</p>
			<?		
		
		}
		elseif(((strlen($firstName) < 5) || (!ctype_alpha($firstName))) || ((strlen($lastName) < 5) || (!ctype_alpha($lastName))))
		     {
			  ?>   
			<h2>Error!</h2>
			<p>Names should have at least 5 characters. Only alphabets should be used. The teacher was not added.</p>
			   <? 			     
		     }
		     elseif(strlen($password) < 6)
		     {
			  ?>   
			<h2>Error!</h2>
			<p>Passwords should have at least 6 characters. The teacher was not added.</p>
			   <? 			     
		     }
		     elseif(strlen($password) > 8) //Already accounted for by onkey up while entering password
		     {
			?>
			<h2>Error!</h2>
			<p>Passwords should have atlmost 8 characters. The teacher was not added.</p>
			<?
		     }
		     elseif(!ctype_alnum($password))  
		     {
			?>
			<h2>Error!</h2>
			<p>Passwords need to be alphanumeric characters only.</p>
			   <? 
		     }
		    else{
	
	$query = "UPDATE mydb.users 
		  SET firstName='$firstName',
		  lastName='$lastName',
		  password = '$password'
		WHERE userID='$userID'";

		$qry_result = mysql_query($query) or die(mysql_error());
		?>
		<b>Login information updated, thank you!</b>
			<?
		     }
		}
		?>
		
<br><hr color="blue">*/
?>
<b>List of saved quizzes</b>
<ul>
<li>Click to view a list of saved quizzes along with their quiz ID#, title and description</li>
<li>To poll a particular quiz, scroll down to the "<b>Poll a quiz</b>" section  and enter the desired quiz ID#</li>
</ul>
<form action="menu.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>"/>
<input type="hidden" name="courseID" value="<?=$courseID?>"/>
<input type="hidden" name="section" value="<?=$section?>"/>
<input type="hidden" name="sem" value="<?=$sem?>"/>
<input type="hidden" name="year" value="<?=$yr?>"/>
<input type="hidden" name="getList" value="1">
<input type="submit" name="submit" value="View all">
<br>
</form>
<?
$getList = mysql_real_escape_string($_POST['getList']);
if($getList == 1){

/*echo $courseID;
echo $sem;
echo $section;
echo $userID;
$query = "SELECT quizID from quizAssignments WHERE courseID='$courseID' and section='$section'and year='$yr' and semester='$sem' and teacherID='$userID'";
$result=mysql_query($query) or die(mysql_error());

$row = mysql_fetch_array($result);
$quizid = $row[quizID];

echo $quizid;*/

$query = "SELECT quizID,title,description from quizAssignments WHERE courseID='$courseID' and section='$section'and year='$yr' and semester='$sem' and teacherID='$userID'";
$result=mysql_query($query) or die(mysql_error());
$result_array = array();
while($row = mysql_fetch_assoc($result))
{
	$quizID[] = $row[quizID];
	$name[] = $row[title];
	$desc[] = $row[description];
}

for($i = 0; $i < sizeof($quizID); $i++) {

	echo ($i+1).". ".$quizID[$i]." ".$name[$i]." (".$desc[$i].")<br/>";
		
}
}
?>
<br><hr color="blue">
<b>Create a quiz</b>
<ul>
<li>From the drop down menu, choose the number of questions you would like in your quiz</li>
<li>Once you are done, click on Go! to begin making your quiz</li><br><br>
</ul>
<form action="makequiz.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>"/>
<input type="hidden" name="courseID" value="<?=$courseID?>"/>
<input type="hidden" name="section" value="<?=$section?>"/>
<input type="hidden" name="sem" value="<?=$sem?>"/>
<input type="hidden" name="year" value="<?=$yr?>"/>
	Number of questions:
	  <select name="questionsQuiz">
		<option value="1">1 question</option>
		<?
		for($i=2;$i<=36;$i++)
		{
			if($i==8)
			{
				$selected = " selected";
			}
			else
			{
				$selected = "";
			}
			?>	
		<option value="<?=$i?>"<?=$selected?>><?=$i?></option>
			<?
		}
		?>
<input type="submit" name="submit" value="Go!" /><br>
</form>
<?
/*</form>
<form action="makequiztext.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>"/>
<input type="hidden" name="courseID" value="<?=$courseID?>"/>
<input type="hidden" name="section" value="<?=$section?>"/>
<input type="hidden" name="sem" value="<?=$sem?>"/>
<input type="hidden" name="year" value="<?=$yr?>"/>
<input type="submit" name="submit" value="From text file" /><br>
<br>
</form>*/
?>
<hr color="blue">
<b>Poll a quiz</b>
<ul>
<li>Use this option to poll a quiz in the classroom</li>
<li>Enter the quiz ID# to begin polling the quiz</li><br><br>
</ul>
<form action="pollquiz.php" method="POST">
<input type="hidden" name="userID" value="<?=$userID?>"/>
<input type="hidden" name="courseID" value="<?=$courseID?>"/>
<input type="hidden" name="section" value="<?=$section?>"/>
<input type="hidden" name="sem" value="<?=$sem?>"/>
<input type="hidden" name="year" value="<?=$yr?>"/>
Enter quiz ID : <input type="text" size="8" name="quizID" value=""/>
<input type="submit" name="submit" value="Start Poll!" /><br>
</form>
<br><hr color="blue">





	
