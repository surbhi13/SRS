<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Response System</title>
	<link rel="stylesheet" href="styles.css" media="screen" />

 <script src="validator.js" type="text/javascript"></script>
</head>

<body>
<h1 align = "centre">Quiz Menu</h1>

<HR size="3" width="100%" color="blue">
<?php 
ob_start("ob_gzhandler");
include("connection.php");
$_SESSION['userID'] = $userID;
session_start();	


	$questions = mysql_real_escape_string($_POST['questionsQuiz']);
	$courseID = mysql_real_escape_string($_POST['courseID']);
	$section = mysql_real_escape_string($_POST['section']);
	$sem = mysql_real_escape_string($_POST['sem']);
	$yr = mysql_real_escape_string($_POST['year']);

	//echo $courseID;
	?>
	  <form action="inputquiz.php" method="POST">
	  <input type="hidden" name="userID" value="<?=$userID?>" />
	  <input type="hidden" name="courseID" value="<?=$courseID?>" />
	  <input type="hidden" name="questions" value="<?=$questions?>" />
	  <input type="hidden" name="section" value="<?=$section?>"/>
	  <input type="hidden" name="sem" value="<?=$sem?>"/>
	  <input type="hidden" name="year" value="<?=$yr?>"/>
	  <input type="hidden" name="makeQuiz" value="1" />

	  <p><strong>How to create a quiz:</strong></p>
	  <ul>
	  <li>These quizzes are simple muliple-choice quizzes. Each must have a choice for options 1 and 2. Blank items for options 3, 4, 5 will not be shown on the screen. Only one answer can be correct.</li>
	  <li>If you choose to write a question and answers, that is fine. Just <b>replace</b> the current questions and answers.</li>
	  <li>Random answers have been selected below. You can of course change these. </li>
	  <li>If you leave a question blank, that question and all after it will not be added to this quiz in the database.</li>
	  </ul>
	  <p>
	  Quiz Title
	  <input type="text" name="title" value="Quiz" size="30" onkeyup="if (this.value.length > 99) { alert('Character limit has been reached!'); this.value = this.value.substr(0,99); }" />
	  </p>
	  <p>
	  Quiz notes (for teachers only)</br>
	  <textarea name="description" rows="5" cols="50">Read the questions to the students, or show them the questions on a screen.</textarea>
	  </p>
  
	  Create your Quiz Questions
	  <table summary="question form">
	  <thead>
	  <tr>
	  	<th scope="col">Question<br />Number</th>
		<th scope="col">Choice<br />Letter</th>
		<th scope="col">Correct<br />Answer</th>
		<th scope="col">Choice Text<br />on screen</th>
	  </th>
	  </thead>
	  <tbody>
	  <?
	  
	  for($i=1; $i<=$questions; $i++)
	  {
          // a random answer
	  	$correctChoice[1]="";
		$correctChoice[2]="";
		$correctChoice[3]="";
		$correctChoice[4]="";
		$correctChoice[5]="";	
		
	  	if($makeTrueFalse != "1")
		{  
		  $randAnswer = mt_rand(1, 5);
		  $inputValue[1] = "A";		  
		  $inputValue[2] = "B";		  
		  $inputValue[3] = "C";		  
		  $inputValue[4] = "D";		  
		  $inputValue[5] = "E";		  
		  
		}
		else
		{
		  $randAnswer = mt_rand(1, 2);
		  $inputValue[1] = "True";		  
		  $inputValue[2] = "False";		  
		  $inputValue[3] = "";		  
		  $inputValue[4] = "";		  
		  $inputValue[5] = "";							
		}
	  $correctChoice[$randAnswer]=" checked";
	  ?>

	  
	  <tr>
	  <td colspan="4">
	  Question <?=$i?>: <input type="text" name="questionText[<?=$i?>]" size="60" value="Insert question here:" onkeyup="if (this.value.length > 199) { alert('Character limit has been reached!'); this.value = this.value.substr(0,199); }">
	  </td>
	  </tr>
	  <tr<?=$bgColor?>>
	  <td align="center"><?=$i?></td>
	  <td>A</td>
	  <td><input type="radio" name="correct[<?=$i?>]" value="1"<?=$correctChoice[1]?> />
	  </td>
	  <td>
	  <input type="text" name="choiceOne[<?=$i?>]" value="<?=$inputValue[1]?>" size="30" onkeyup="if (this.value.length > 99) { alert('Character limit has been reached!'); this.value = this.value.substr(0,99); }" />
	  </td>
	  </tr>
	  <tr<?=$bgColor?>>
	  <td align="center"><?=$i?></td>
	  <td>B</td>
	  <td><input type="radio" name="correct[<?=$i?>]" value="2"<?=$correctChoice[2]?> />
	  </td>
	  <td>
	  <input type="text" name="choiceTwo[<?=$i?>]" value="<?=$inputValue[2]?>" size="30" onkeyup="if (this.value.length > 99) { alert('Character limit has been reached!'); this.value = this.value.substr(0,99); }" />
	  </td>
	  </tr>
	  <tr<?=$bgColor?>>
	  <td align="center"><?=$i?></td>
	  <td>C</td>
	  <td><input type="radio" name="correct[<?=$i?>]" value="3"<?=$correctChoice[3]?> />
	  </td>
	  <td>
	  <input type="text" name="choiceThree[<?=$i?>]" value="<?=$inputValue[3]?>" size="30" onkeyup="if (this.value.length > 99) { alert('Character limit has been reached!'); this.value = this.value.substr(0,99); }" />
	  </td>
	  </tr>
	  <tr<?=$bgColor?>>
	  <td align="center"><?=$i?></td>
	  <td>D</td>
	  <td><input type="radio" name="correct[<?=$i?>]" value="4"<?=$correctChoice[4]?> />
	  </td>
	  <td>
	  <input type="text" name="choiceFour[<?=$i?>]" value="<?=$inputValue[4]?>" size="30" onkeyup="if (this.value.length > 99) { alert('Character limit has been reached!'); this.value = this.value.substr(0,99); }" />
	  </td>
	  </tr>
	  <tr<?=$bgColor?>>
	  <td align="center"><?=$i?></td>
	  <td>E</td>
	  <td><input type="radio" name="correct[<?=$i?>]" value="5"<?=$correctChoice[5]?> />
	  </td>
	  <td>
	  <input type="text" name="choiceFive[<?=$i?>]" value="<?=$inputValue[5]?>" size="30" onkeyup="if (this.value.length > 99) { alert('Character limit has been reached!'); this.value = this.value.substr(0,99); }" />
	  </td>
	  </tr>	  
	  <?
	  } // end foreach
	  
	  ?>
	  </tbody>
	  <tfoot>
	  <tr>
	   <td colspan="4">
	   <input type="submit" name="submit" value="Create this quiz" onClick="return confirmIt('Ready to submit this quiz?')" />
	   <input type="reset" value="Reset" onClick="return confirmIt('Reset will erase all your changes. Are you sure?')" />
	   </td>
	 </tr>
	 </tfoot>
	 </table>
	 </form>
	</p>



	

