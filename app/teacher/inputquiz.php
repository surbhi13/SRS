
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

<?php 
ob_start("ob_gzhandler");
include("connection.php");
	
session_start();	

	$questions = mysql_real_escape_string($_POST['questions']);
	$title = mysql_real_escape_string($_POST['title']);
	$description = mysql_real_escape_string($_POST['description']);
	$userID= $_SESSION['userID'];
	$courseID = mysql_real_escape_string($_POST['courseID']);
	$section = mysql_real_escape_string($_POST['section']);
	$sem = mysql_real_escape_string($_POST['sem']);
	$yr = mysql_real_escape_string($_POST['year']);

	function make_quizID()
	{
	$quizID = mt_rand(1000,9999);
	return $quizID;	

	}
	
	$quiz = make_quizID();

	$quizexists = "no";
	$query = "SELECT quizID from quizAssignments where quizID= '$quiz'";
	$qry_result = mysql_query($query) or die(mysql_error());
		while($row = mysql_fetch_array($qry_result))
			{ 
				$quizexists = "yes";
			}

	//echo $quizexists;
	if($quizexists == "yes"){
	
	function make_quizIDagain()
	{
	$quizID = mt_rand(1000,9999);
	return $quizID;	

	}
	
	$quiz = make_quizIDagain();
	
	}
	$query = "INSERT into quizAssignments
		(courseID, quizID, semester, year, section, teacherID, title,totalQuestions, description)
		values
		('$courseID', '$quiz','$sem', '$yr','$section', '$userID','$title', '$questions','$description');";
	
	$qry_result = mysql_query($query) or die(mysql_error());
	

	$actualQuestions = 0;
	
	for($i=1; $i<=$questions; $i++)
	{
	    if(mysql_real_escape_string($_POST['questionText'][$i]) != "")
	    {

		//Find a more efficient way of using database options space..
		$correctOne= 0;
		$correctTwo= 0;
		$correctThree = 0;
		$correctFour =0;
		$correctFive = 0;
		$actualQuestions++;
		$questionText[$i] = mysql_real_escape_string($_POST['questionText'][$i]);
		$correct[$i] = mysql_real_escape_string($_POST['correct'][$i]);
		$choiceOne[$i] = mysql_real_escape_string($_POST['choiceOne'][$i]);
		$choiceTwo[$i] = mysql_real_escape_string($_POST['choiceTwo'][$i]);
		$choiceThree[$i] = mysql_real_escape_string($_POST['choiceThree'][$i]);
		$choiceFour[$i] = mysql_real_escape_string($_POST['choiceFour'][$i]);
		$choiceFive[$i] = mysql_real_escape_string($_POST['choiceFive'][$i]);

		//echo $correct[$i];
		switch($correct[$i]){

		case 1:
			 $correctOne = 1;
			 //$correctTwo = $correctThree = $correctFour= $correctFive = 0;
			 break;
		case 2:
			 $correctTwo = 1;
			//$correctOne = $correctThree = $correctFour= $correctFive = 0;
			 break;
		case 3:
			 $correctThree = 1;
			//$correctTwo = $correctOne = $correctFour= $correctFive = 0;
			 break;
		case 4:
			 $correctFour = 1;
			//$correctTwo = $correctThree = $correctOne= $correctFive = 0;
			 break;
		case 5:
			 $correctFive = 1;
			//$correctTwo = $correctThree = $correctFour= $correctOne = 0;
			 break;
		}
		
		$query = "INSERT into quizQuestions
			(quizID,questionNo,questionText)
			values
			('$quiz','$i','$questionText[$i]');";
		$qry_result = mysql_query($query) or die(mysql_error());

		$queryadd = "INSERT into quizOptions
			(quizID,optionNo,optionText,questionNo,correctAns)
			values
			('$quiz', 1 , '$choiceOne[$i]', '$i','$correctOne');";
		$qry_result = mysql_query($queryadd) or die(mysql_error());
	
		$queryadd = "INSERT into quizOptions
			(quizID,optionNo,optionText,questionNo, correctAns)
			values
			('$quiz', 2 , '$choiceTwo[$i]', '$i', '$correctTwo');";
		$qry_result = mysql_query($queryadd) or die(mysql_error());

		$queryadd = "INSERT into quizOptions
			(quizID,optionNo,optionText,questionNo,correctAns)
			values
			('$quiz', 3 , '$choiceThree[$i]', '$i', '$correctThree');";
		$qry_result = mysql_query($queryadd) or die(mysql_error());

		$queryadd = "INSERT into quizOptions
			(quizID,optionNo,optionText,questionNo, correctAns)
			values
			('$quiz', 4 , '$choiceFour[$i]', '$i', '$correctFour');";
		$qry_result = mysql_query($queryadd) or die(mysql_error());
		
		$queryadd = "INSERT into quizOptions
			(quizID,optionNo,optionText,questionNo, correctAns)
			values
			('$quiz', 5 , '$choiceFive[$i]', '$i', '$correctFive');";
		$qry_result = mysql_query($queryadd) or die(mysql_error());
		

	    }
	    else
	    {
		    // we've encountered a blank question
		    // bail out
		break;
	    }
		
	}
?>
<p><b>Congratulations! Your quiz has been submitted successfully.</p></b><br>
	<p>Your assigned quiz ID # <h1><?=$quiz?></h1>
<p><b>Please keep note of your quiz ID # you will require it later to access your quiz.</p></b><br>


