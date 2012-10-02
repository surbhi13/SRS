<?
ob_start("ob_gzhandler"); 
include ("connection.php");
session_start();

	$userID = $_SESSION['userID'];
	
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Teacher Menu</title>
	
    
    
</head>

<body>


