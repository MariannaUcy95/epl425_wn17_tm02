<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="styling.css" />  

</head>

<body>

<span title="HOME PAGE"><img src="logoW.png" height="90" width="122" id="logo"></span>

<header>
    <?php
    session_start();
    $courseKey = $_GET['course'];
   if(isset($_SESSION['type'])) { 
    	$teacherID = $_GET['id'];?>
        <br/>
        <a href="select_course.php?id=<?= $teacherID ?>" class="button buttonTop buttonTop">Home</a>
		<a href="select_course.php?id=<?= $teacherID ?>" class="button buttonTop buttonTop">Back</a>
		<?php }
		else {?>
        <br/>
        <a href="select_course.php" class="button buttonTop buttonTop">Home</a>
		<a href="select_course.php" class="button buttonTop buttonTop">Back</a>
		<?php }
     if(isset($_SESSION['type'])) { ?>
        <a href="logout.php" class="button buttonTop buttonHead">Log out</a></center>
    <?php } ?>
</header>

<img src="logoW.png" height="90" width="122" id="logo"> 
<div class="titleBox"><h1>Select a lecture</h1></div>

<table class="tableone">
    <thead>
        <tr>
          <th class="codeElement" scope="col">CODE</th> 
          <th class="textElement" scope="col">LECTURE</th>
        </tr>
    </thead>
    <tbody>
    <tr><td colspan="2">
        <div class="innerb">
  
            <table class="tabletwo">
                <thead></thead>
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "epl425";
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        mysqli_query($conn,"SET NAMES utf8");
                        $sql = "SELECT * FROM lecture WHERE lecture.Course_key='$courseKey'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)==true){
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                if(isset($_SESSION['type'])) { 
                                    echo "<tr><td><a href='select_question.php?course=".$courseKey."&id=".$teacherID."&lecture=".$row["LCode"]."'>".$row["LCode"]."</a></td><td><a href='select_question.php?course=".$courseKey."&id=".$teacherID."&lecture=".$row["LCode"]."'>".$row["Title"]."</a></td></tr>";
                                  } else {
                                    echo "<tr><td><a href='select_question.php?course=".$courseKey."&lecture=".$row["LCode"]."'>".$row["LCode"]."</a></td><td><a href='select_question.php?course=".$courseKey."&lecture=".$row["LCode"]."'>".$row["Title"]."</a></td></tr>";
                                  }
                            }
                        }
                    ?>    
            </table>
        </div>
        </td></tr>
    </tbody>
</table>

</body>

</html>
