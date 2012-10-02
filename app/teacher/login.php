<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();


 if($_POST)
{

	//get data from the form
	$userID = $_POST['userID'];
	$password = $_POST['password'];
	
	$_SESSION['userID'] = $userID;
	
	
	//To protect MySQL injection
	$userID = stripslashes($userID);
	$password = stripslashes($password);
	$userID = mysql_real_escape_string($userID);
	$password = mysql_real_escape_string($password);
	
	if(($userID == "admin") && ($password == "00001111")){
		$current_time = date ("Y-m-d H:i:s");
		echo $current_time;
		$sql= "UPDATE users SET loggedIn = '1', loginTime= '$current_time' where userID='admin' and password='00001111'";
		$result=mysql_query($sql);
		include("admin_menu.php");
	}
	else{
	
	$sql= "SELECT * FROM users WHERE userID='$userID' and password='$password'";
	$result=mysql_query($sql);
	
	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $userID and $mypassword, table row must be 1 row
	if($count == 1){

		$current_time = date ("Y-m-d H:i:s");
		//echo $current_time;
		$sql= "UPDATE users SET loggedIn = '1', loginTime= '$current_time' where userID='$userID' and password='$password'";
		$result=mysql_query($sql);
		include("menu_controls.php");
	}else{
	
	echo '<script type="text/javascript"> alert("userID or password is invalid, please try again!");</script>';
	echo '<script type="text/javascript"> window.location = "login.html"; </script>';
	}
	
	}

}
mysql_close($connect)


?>
