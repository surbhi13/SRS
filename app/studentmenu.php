<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<h1 align="center">Student Response System- Student Menu</h1>
<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();
$userID = mysql_real_escape_string($_POST['userID']);
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

<?
$loginedit = mysql_real_escape_string($_POST['loginedit']);
$current_time = date ("Y-m-d H:i:s");
//echo "Logged in since: ".$current_time;
?>
	
Welcome Student! What would you like to do today?<br><br>
		
 <b>View/Edit login information</b><br>
<ul>
	<li>Please note that you may not change your userID. 
	<li>You can however change your password, first name and last name registered with us using this menu.
	<li>Your userID will remain as assigned by admin.
</ul>
	
 <?
	//echo $userID;
	
	//Select appropriate record from the table
	$query = "select accessLevel, firstName, lastName, 
			userID, password 
			from users 
			where userID = '$userID'"; //using username as key, username is not changeable

	$qry_result = mysql_query($query) or die(mysql_error());

	while($row = mysql_fetch_array($qry_result)){

?>
	<form action="studentmenu.php" method="POST">
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
	
	$query = "UPDATE users 
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
		
<br><hr color="blue">

<b>Take a quiz</b><br><br>

<form action="takequiz.php" method="POST">
	<input type="hidden" name="userID" value="<?=$userID?>"/>
Enter quiz ID : <input type="text" size="8" name="quizID" value=""/></p>
<input type="submit" name="submit" value="Start Quiz!" /><br>
	</form>
<br><hr color="blue">
