<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<h1>Student Response System- Admin Menu</h1>

<HR size="3" width="100%" color="blue">

<?php 
ob_start("ob_gzhandler");
//include("connection.php");
session_start();
	?>
	<h2>Welcome Admin! What would you like to do today?</h2>
		<form action="admin_menu_controls.php" method="POST">
		<input type="radio" name="addteacher" value="addteacher"> Add teacher(s)<br><br>
		<input type="radio" name="addcourse" value="addcourse"> Add course(s)<br><br>
		<input type="radio" name="assigncourse" value="assigncourse"> Assign teacher(s) to course(s)<br><br>
		<input type="submit" name="submit"/>
		</form>
	
