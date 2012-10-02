<?php 
ob_start("ob_gzhandler");
include("connection.php");
session_start();
$tbl_name = "mydb.users";


 if($_POST)
{

	//get data from the form
	$userID = $_POST['userID'];
	$password = $_POST['password'];
	
	
	//To protect MySQL injection
	$userID = stripslashes($userID);
	$password = stripslashes($password);
	$userID = mysql_real_escape_string($userID);
	$password = mysql_real_escape_string($password);
	
	
	$sql= "SELECT id FROM mydb.users WHERE userID='$userID' and password='$password'";
	$result=mysql_query($sql);
	
	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $userID and $mypassword, table row must be 1 row
	if($count == 1){
		$current_time = date ("Y-m-d H:i:s");
		//echo $current_time;
		$query = "UPDATE users SET loggedIn = '1', loginTime = '$current_time' WHERE userID='$userID' AND accessLevel = '1'"; //Assign courseID while adding students
		//Execute query
	 	$qry_result = mysql_query($query) or die(mysql_error());
			include("studentmenu.php");
	}else{
	
	echo '<script type="text/javascript"> alert("userID or password is invalid, please try again!");</script>';
	echo '<script type="text/javascript"> window.location = "login.html"; </script>';
	}
	

}
mysql_close($connect)


?>
