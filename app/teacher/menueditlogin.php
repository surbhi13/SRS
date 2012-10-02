<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<h1>Student Response System- Teacher Menu</h1>

<HR size="3" width="100%" color="blue">

<p>&nbsp;</p>
<p>&nbsp; </p>
<?
ob_start("ob_gzhandler");
include("connection.php");
session_start();

	$lastName = mysql_real_escape_string(stripslashes($_POST['lastName']));
	$firstName = mysql_real_escape_string(stripslashes($_POST['firstName']));
	$password = mysql_real_escape_string($_POST['password']);
	$passwordRe = mysql_real_escape_string($_POST['passwordRe']);

	echo $password;
	echo $lastName;
	echo $firstName;
	echo $userID;

	$query = "update users 
		  set firstName='$firstName',
		  lastName='$lastName',
		  password = '$password'
		where userID='$userID'";

		$qry_result = mysql_query($query) or die(mysql_error());
		
	?>
	<h2> Information edited, thank you. </h2>
