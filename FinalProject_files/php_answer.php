<?php
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "epl425";


	if(isset($_POST['description']))
		$title = $_POST['description'];
	if(isset($_POST['correct'])) {
		if($_POST['correct'] == "yes"){
			$correct = 1;
		}
		else{
			$correct=0;
		}	
	}
	if(isset($_POST['lcode']))
		$Lcode = $_POST['lcode'];
	if(isset($_POST['course']))
		$key =  $_POST['course'];
	if(isset($_POST['teacherID']))
		$teacherID = $_POST['teacherID'];
	if(isset($_POST['QCode']))
		$qcode = $_POST['QCode'];

	if(isset($_POST['answers']))
		$answer = $_POST['answers'];

	
	

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
		
		$insert_Query = "INSERT INTO  possible_answer (TeacherID, QCode, Description, Correct) VALUES ('$teacherID', '$qcode', '$title', $correct)";
		
			$insert_Result = mysqli_query($connect, $insert_Query);
		header("Location: select_answer.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&question=".$qcode);
			
	}



	//EDIT!!!
	if(isset($_POST['edit']))
	{
		header("Location: select_answer.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&question=".$qcode."&answer=".$answer);	
	}
	if(isset($_POST['edit2']))
	{
		if($_POST['correct'] == "yes"){
			$correct = 1;}
		else{
			$correct=0;}
		$edit_Query="UPDATE possible_answer SET Description='$title', Correct=$correct WHERE AnswerNo=$answer AND QCode=$qcode";
		$edit_Result = mysqli_query($connect, $edit_Query);
		header("Location: select_answer.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&question=".$qcode);
	
	}



	//DELETE!
	if(isset($_POST['delete']))
	{
		$delete_Query = "DELETE FROM  possible_answer  WHERE AnswerNo='$answer' " ;
		
		$delete_Result = mysqli_query($connect, $delete_Query);
		 header("Location: select_answer.php?course=".$key."&id=".$teacherID."&lecture=".$Lcode."&question=".$qcode);
	}

	//SUBMIT!
	if(isset($_POST['submit'])) {
		$submit_Query = "UPDATE question SET Total=(Total+1) WHERE QCode=$qcode";
		$submit_Result = mysqli_query($connect, $submit_Query);
		$submit_Query = "UPDATE question,possible_answer SET question.Total_Correct=(question.Total_Correct+1) WHERE question.QCode=$qcode AND possible_answer.QCode=$qcode AND possible_answer.AnswerNo=$answer AND possible_answer.Correct=1";
		$submit_Result = mysqli_query($connect, $submit_Query);
		 header("Location: select_answer.php?course=".$key."&lecture=".$Lcode."&question=".$qcode."&submit=true");
	}


mysqli_close($connect);
//header("Location: select_lecture.php?course=".$key."&id=".$teacherID);
?>



