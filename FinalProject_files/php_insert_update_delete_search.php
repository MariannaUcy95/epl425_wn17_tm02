<?php
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epl425";

	if(isset($_POST['question_title']))
		$title = $_POST['question_title'];
	if(isset($_POST['lcode']))
		$Lcode = $_POST['lcode'];
	if(isset($_POST['course']))
		$key =  $_POST['course'];
	if(isset($_POST['teacherID']))
		$teacherID = $_POST['teacherID'];
	if(isset($_POST['questions']))
		$qcode = $_POST['questions'];
	if(isset($_POST['time']))
		$time = $_POST['time'];
	

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// Create connection
         $connect = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($connect->connect_error) {
             die("Connection failed: " . $connect->connect_error);
          }
	

	//INSERT!!!
	if(isset($_POST['insert']))
	{
		$insert_Query="INSERT INTO  question(Question, LCode, Time, TeacherID) VALUES ('$title','$Lcode', '$time', '$teacherID')";
		$insert_Result = mysqli_query($connect, $insert_Query);
		header("Location: select_question.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode);		
	}



	//EDIT!!!
	if(isset($_POST['edit']))
	{	
		header("Location: select_question.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&question=".$qcode);	
	}
	if(isset($_POST['edit2']))
	{
		echo $title." ".$time." ".$qcode;
		$edit_Query="UPDATE question SET Question='$title', Time='$time' WHERE QCode='$qcode'";
		$edit_Result = mysqli_query($connect, $edit_Query);
		header("Location: select_question.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode);
	}

	//STATISTICS!!!
	if(isset($_POST['statistics']))
	{	
		header("Location: select_question.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&questionStat=".$qcode);	
	}



	//NEXT!
	if(isset($_POST['next'])) { 
		if (isset($_POST['questions'])) {
			if(isset($_SESSION['type']))
	 			header("Location: select_answer.php?lecture=".$Lcode."&course=".$key."&id=".$teacherID."&question=".$qcode);
 					else
	 			header("Location: select_answer.php?lecture=".$Lcode."&course=".$key."&question=".$qcode);
			} else { 
			if(isset($_SESSION['type']))
	 			header("Location: select_question.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&next=error");
 					else
	 			header("Location: select_question.php?course=".$key."&lecture=".$Lcode."&next=error");
			}
		}



	//DELETE!
	if(isset($_POST['delete']))
	{
			$delete_Query = "DELETE FROM  question  WHERE QCode='$qcode' " ;
			$delete_Result = mysqli_query($connect, $delete_Query);
		 	header("Location: select_question.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode); 
	}
mysqli_close($connect);
?>



