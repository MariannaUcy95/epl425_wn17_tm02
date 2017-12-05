<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="styling.css" />
    
</head>

<body>

<span title="HOME PAGE"><img src="logoW.png" height="90" width="122" id="logo"></span>

<header class="w3-container w3-teal">
    <br/>
   <a href="index.php" class="button buttonTop">Back</a>
    <?php
    session_start();
    if(isset($_SESSION['type'])) { ?>
        <a href="logout.php" class="button buttonTop buttonHead">Log out</a></center>
    <?php } ?>
</header>

<img src="logoW.png" height="90" width="122" id="logo"> 
<div class="titleBox"><h1>Select a course</h1></div>

<table class="tableone">
    <thead>
        <tr>
          <th class="codeElement" scope="col">CODE</th> 
          <th class="textElement" scope="col">COURSE</th>
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
                        if(isset($_SESSION['type'])) { 
                            $teacherID = $_GET['id'];
                            $sql = "SELECT * FROM course WHERE course.TeacherID='$teacherID'";
                        } else {
                            $sql = "SELECT * FROM course";
                        }
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)==true){
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
 				if(isset($_SESSION['type'])) { 
                                	echo "<tr><td><a href='select_lecture.php?course=".$row["Course_key"]."&id=".$teacherID."'>".$row["CCode"]."</a></td><td><a href='select_lecture.php?course=".$row["Course_key"]."&id=".$teacherID."'>".$row["Title"]."</a></td></tr>";
                        	} else {
echo "<tr><td><a href='enter_key_form.php'>".$row["CCode"]."</a></td><td><a href='enter_key_form.php'>".$row["Title"]."</a></td></tr>";
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
