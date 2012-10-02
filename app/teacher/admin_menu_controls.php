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
include("connection.php");
session_start();

	$addteacher = mysql_real_escape_string($_POST['addteacher']);
	$addcourse = mysql_real_escape_string($_POST['addcourse']);
	$assigncourse = mysql_real_escape_string($_POST['assigncourse']);

if(isset($_POST['addteacher'])){
?>

<p><b>Add teacher(s)</p></b>
	 	  <ul>
		  <li>Add new teachers here.</li>
		  <li>Remember that you can add a teacher only <u>once</u>!
		  </ul>
			
		  <form action="admin_menu_controls.php" method="POST">
		  <input type="hidden" name="userID" value="<?=$userID?>" />
		  <input type="hidden" name="addteacher" value="1" />
		  <p>
		  Last name: <input type="text" size="20" name="lastName" value="" onkeyup="if (this.value.length > 20) { alert('Last names are atmost 20 characters');}"/>
		  <br /><br />
		  First name: <input type="text" size="20" name="firstName" value="" onkeyup="if (this.value.length > 20){ alert('First names are atmost 20 characters');}"  />
		  <br /><br />
		  Password: <input type="password" name="passwordTeacher" value="" onkeyup="if (this.value.length > 8) { alert('Passwords are atmost 8 characters'); this.value = this.value.substr(0,8); }" />
		  <br /><br />
		  Email: <input type="email" name="email" size="30" value=""/><br /><br />
		  <input type="submit" name="submit" value="Add teacher" />
		  </p>
		  <br /><br />
		  </form>
		  <?
if($addteacher == 1)
		  {
		     $lastName = trim(mysql_real_escape_string(stripslashes($_POST['lastName'])));
		     $firstName = trim(mysql_real_escape_string(stripslashes($_POST['firstName'])));
		     $passwordTeacher = trim(mysql_real_escape_string($_POST['passwordTeacher']));
		     $email = trim(mysql_real_escape_string($_POST['email']));

		     
		     $split = substr("$firstName", 0,1);  
		     $usernameTeacher = $split.$lastName;
		     $usernameTeacher = strtolower($usernameTeacher);
		    //echo $usernameTeacher;
		     
		    //Check if the email ID is valid
		    function checkEmail( $email ){
    			return filter_var( $email, FILTER_VALIDATE_EMAIL );
		     }		
		     // see if password exists
		     $pwexists = "no";
		     $query = "select id from users
					where userID='".$usernameTeacher."'
					and password='".$passwordTeacher."'
					limit 1";
			$qry_result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($qry_result))
			{ 
				$pwexists = "yes";
			}
			
		     //See if ID exists
		     $IDexists = "no";
		     $query = "select id from users
					where userID='".$usernameTeacher."'
					limit 1";
			$qry_result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($qry_result))
			{ 
				$IDexists = "yes";
			}

		     $isValid = checkEmail($email);
		     if(!isValid){
			?>
			<h2>Error!</h2>
			<p> Invalid email ID, please enter a valid email ID. </p>
			<?
		     }
		     elseif(($lastName=="") || ($firstName=="") || ($passwordTeacher==""))
		     {
			  ?>   
			<h2>Missing Data!</h2>
			<p>The teacher was not added. Please ensure that all information is filled in.</p>
			   <? 
		     }
		     elseif(((strlen($firstName) < 5) || (!ctype_alpha($firstName))) || ((strlen($lastName) < 5) || (!ctype_alpha($lastName))))
		     {
			  ?>   
			<h2>Error!</h2>
			<p>Names should have at least 5 characters. Only alphabets should be used. The teacher was not added.</p>
			   <? 			     
		     }
		     elseif(strlen($passwordTeacher) < 6)
		     {
			  ?>   
			<h2>Error!</h2>
			<p>Passwords should have at least 6 characters. The teacher was not added.</p>
			   <? 			     
		     }
		     elseif(strlen($passwordTeacher) > 8) //Already accounted for by onkey up while entering password
		     {
			?>
			<h2>Error!</h2>
			<p>Passwords should have atlmost 8 characters. The teacher was not added.</p>
			<?
		     }
		     elseif(!ctype_alnum($passwordTeacher))  
		     {
			?>
			<h2>Error!</h2>
			<p>Passwords need to be alphanumeric characters only.</p>
			   <? 
		     }
		     elseif($pwexists=="yes")
		     {
			  ?>   
			<h2>Error</h2>
			<p>That userID / password combination exists already. The teacher was not added.</p>
			   <? 
		     }
		    elseif($IDexists=="yes")
		     {
			  ?>   
			<h2>Error</h2>
			<p>User exists already. Please try a different combination.</p>
			   <? 
		     }
		     else
		     {
		     $query = "INSERT into users
			(accessLevel,
			 firstName,
			 lastName,
			 password, userID, emailID)
			values
			('2',
			 '$firstName',
			 '$lastName',
			 '$passwordTeacher','$usernameTeacher', '$email')";
			$qry_result = mysql_query($query) or die(mysql_error());
			$to = $email;
 			$subject = "Your SRS login details";
			$body = "Hello,\n\nGreetings from SRS. Here are your details:\n\nUsername: ".$usernameTeacher."\nPassword: ".$passwordTeacher."\nThank you!";
 			if (mail($to, $subject, $body)) {
   				echo("<p>Message successfully sent!</p>");
  			} else {
   				echo("<p>Message delivery failed...</p>");
  			}
			?>
		<b>Teacher added.</b> Email sent to respective teacher with all details.</div>
			<?
		     }
		  }
	
		  ?>
		  <hr color="blue"/>
<?
}


if(isset($_POST['assigncourse'])){
?>
<p><b>Assign a teacher to course</p></b>
	 	  <ul>
		  <li>All of your teachers and courses are listed in their respective pull-down menus. </li>
		  <li>If not listed there, then before you assign teachers to courses, you need to complete the <i>Add teacher(s)</i> section and or <i>Add course(s)</i> section.</li>
		  </ul>
		  <form action="admin_menu_controls.php" method="POST">
		  <input type="hidden" name="userID" value="<?=$userID?>" />
		  <input type="hidden" name="assigncourse" value="1" />
		  <p>
		  Course Title:
		  <select name="coursetitle">
		  <option value="" selected>Select a course</option>
		  <?
		  // get the courses
		$query = "SELECT courseTitle, courseDescription, courseID
			from courses 
			order by courseTitle asc";
		$qry_result = mysql_query($query) or die(mysql_error());
		while($row = mysql_fetch_array($qry_result))
		{
			?>
			<option value="<?=$row[courseTitle]?>"><?=$row[courseTitle]?></option>
			<?
		}		  
		  ?>
		  </select>
		  <br /><br/>
		  Assigned teacher:
		  <select name="teacher_id">
		  <option value="" selected>Select a teacher</option>
		  <?
		  // get the teachers
		$query = "SELECT userID, firstName, lastName
			from users 
			where accessLevel = '2'
			order by lastName asc";
		$qry_result = mysql_query($query) or die(mysql_error());
		while($row = mysql_fetch_array($qry_result))
		{
			?>
			<option value="<?=$row[userID]?>"><?=$row[firstName]?> <?=$row[lastName]?></option>
			<?
		}
				  
		  ?>
		  </select>
		  <br /><br />
		  Semester:
		  <select name="semester">
		  <option value="" selected>Select a semester</option>
		  <option>Fall</option>
		  <option>Winter</option>
		  <option>Summer</option>
		  </select>
		  <br /><br />
		  Year: 
		  <select name="year">
		  <?
			$currYr = date("Y");
			$nextYr = date("Y") + 1;
		  ?>
		  <option selected><?=$currYr?></option>
		  <option><?=$nextYr?></option>
		  </select>
		  </br><br />
		  Section:
		  <select name="section">
		  <option value="" selected>Select a section</option>
		  <option>1</option>
		  <option>2</option>
		  <option>3</option>
		  <option>4</option>
		  <option>5</option>
		  <option>6</option>
		  <option>7</option>
		  <option>8</option>
		  </select>
		  <br /><br />
		  <input type="submit" name="submit" value="Assign" />
		  </p>
		  </form>
<?
if($assigncourse == 1)
		  {
		     //echo "hello";
		     $teacher_id = trim(mysql_real_escape_string($_POST['teacher_id']));
		     //echo $teacher_id;
		     $coursetitle = trim(mysql_real_escape_string($_POST['coursetitle']));
		     $year = trim(mysql_real_escape_string($_POST['year']));
		     $semester = trim(mysql_real_escape_string($_POST['semester']));
		     $section = trim(mysql_real_escape_string($_POST['section']));
		     

		     //See if teacher course assignment already exists (same section, year, semester)
		     $assignExists = "no";
		     $query = "select section, year, semester from courseAssignments
					where teacherID='".$teacher_id."' and section='".$section."' and year='".$year."' and semester='".$semester."'
					limit 1";
			$qry_result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($qry_result))
			{ 
				$assignExists = "yes";
			}

		   
		  //See if teacher is already assigned to 1 section in that semester, year----APPLICABLE
		     /*$sectionExists = "no";
		     $query = "select section, year, semester from courseAssignments
					where teacherID='".$teacher_id."' and year='".$year."' and semester='".$semester."'
					limit 1";
			$qry_result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($qry_result))
			{ 
				$sectionExists = "yes";
				$exSection = $row[section];
			}*/
		
		     
		     if($coursetitle=="")
		     {
			  ?>   
			<h2>Missing Data</h2>
			<p>No course title was chosen. Please choose a course title.</p>
			   <? 
		     }
			 elseif($assignExists=="yes")
		     {
			  ?>   
			<h2>Error!</h2>
			<p><?=$teacher_id?> is already assigned to the course <?=$coursetitle?>, section <?=$section?> for the term <?=$semester?> <?=$year?>.</p>
			   <? 
		     }
			/*elseif($sectionExists=="yes")
		     {
			  ?>   
			<h2>Error!</h2>
			<p><?=$teacher_id?> is already assigned to section <?=$exSection?> for the course <?=$coursetitle?> during the term <?=$semester?> <?=$year?>. A teacher can only be assigned to a single section of a course in a particular term.</p>
			   <? 
		     }*/
		     elseif($teacher_id=="")
		     {
			  ?>   
			<h2>Missing Data</h2>
			<p>No teacher was chosen. Please assign a teacher to the chosen course.</p>
			   <? 
		     }
		      elseif($semester=="")
		     {
			  ?>   
			<h2>Missing Data</h2>
			<p>No semester was chosen. Please select a semester for the chosen course.</p>
			   <? 
		     }
		     elseif($section=="")
		     {
			  ?>   
			<h2>Missing Data</h2>
			<p>No section was chosen. Please select a section for the chosen course.</p>
			   <? 
		     }
		     elseif($year=="")
		     {
		      ?>
		      <h2>Missing Data</h2>
		      <p>Please select a year.</p>
			<?
		     }
		     else
		     {

		    // echo $teacher_id;
		     $query = "SELECT courseID from courses WHERE courseTitle= '$coursetitle' ";
		     $qry_result = mysql_query($query) or die(mysql_error());
		     $row = mysql_fetch_array($qry_result);
		     $courseID= $row[courseID];
		     
		     $queryAdd = "INSERT into courseAssignments
			(teacherID, courseID, semester, year, section)
			values
			('$teacher_id','$courseID', '$semester', '$year', '$section');";
		$qry_resultAdd = mysql_query($queryAdd) or die(mysql_error());
		$courseTitle = strtoupper($coursetitle);

		$query = "SELECT userID, firstName, lastName
			from users 
			where accessLevel = '2' and userID ='$teacher_id'";
		$qry_result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($qry_result);

		$lastName = $row[lastName];
		$firstName = $row[firstName];
			
		?>
	<b>Congratulations!<br></b> <?=$firstName?> <?=$lastName?> is now assigned to <?=$coursetitle?> section <?=$section?>, for the term <?=$semester?> <?=$year?>.<br>
		<?
		     }
}
?>
<hr color="blue"/>
<?
}

if(isset($_POST['addcourse'])){
?>
<p><b>Add a course</p></b>

		  <form action="admin_menu_controls.php" method="POST">
		  <input type="hidden" name="userID" value="<?=$userID?>" />
		  <input type="hidden" name="addcourse" value="1" />
		  <p>
		  Course Title:<input type="text" size="4" name="coursetitle" value="" /> 
		  <br /><br />
		  Course Number:<input type="text" size="4" name="coursenumber" value="" /> 
		  <br/><br />
		  Course Description:<br> <textarea name="coursedescription" id="coursedescription" data-maxlen="200" cols=40 rows=10>
		  <? echo "Enter a brief description of the course here. Thank you!"; ?>
		  </textarea>
		   <br/><br />
		 <input type="submit" name="submit" value="Add course" />
<?

if($addcourse == 1)
		  {
		     //$teacher_id = trim(mysql_real_escape_string($_POST['teacher_id']));
		     $coursedescription = trim(mysql_real_escape_string($_POST['coursedescription']));
		     $coursetitle = trim(mysql_real_escape_string($_POST['coursetitle']));
		     $coursenumber = trim(mysql_real_escape_string($_POST['coursenumber']));
		     $space = " ";
		     $coursename = strtoupper($coursetitle).$space;
		     $coursename = $coursename.$coursenumber;
		     function make_courseID()
			{
			$courseID = mt_rand(100000,999999);
			return $courseID;	
		
			}
	
			$courseID = make_courseID();

		     $courseexists = "no";
		     $query = "select courseTitle from courses
					where courseTitle='".$coursename."'
					limit 1";
	
			$qry_result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($qry_result))
			{ 
				$courseexists = "yes";
				}

		     if($coursetitle=="" || $coursenumber == "")
		     {
			  ?>   
			<h2>Missing Data</h2>
			<p>There was no course name or number. No new course was added.</p>
			   <? 
		     }
		      elseif(is_numeric($coursetitle) || ctype_alpha($coursenumber))
			{
			?>   
			<h2>Error!</h2>
			<p> Course title must be alphabets only and course number must be numbers only! </p>
			<?
			}
			elseif(strlen($coursetitle)!=4 || strlen($coursenumber)!=3)
			{
			?>
			 <h2>Error!</h2>
				<p>Course title must be 4 characters and course numbers must be 3 characters only. </p>
				<?		
		     }
			elseif($courseexists=="yes")
		     {
			  ?>   
			<h2>Error!</h2>
			<p>This course already exists. Course not added.</p>
			   <? 
		     }
		     else
		     {
		     $queryAdd = "INSERT into courses
			(courseTitle, courseDescription, courseID)
			values
			('$coursename', '$coursedescription', '$courseID');";
		$qry_resultAdd = mysql_query($queryAdd) or die(mysql_error());
			
		?>
	<b>New course added!<br></b> <?=$coursename?> was added to the system. Course ID: <?=$courseID?>.<br>
		<?
		     }
}
?>
<hr color="blue"/>
<?
}



