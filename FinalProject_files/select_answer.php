<?php
 session_start();
 $courseKey = $_GET['course'];
 $lcode = $_GET['lecture'];
 $qcode = $_GET['question'];
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
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styling.css" />

<script>
function showDiv(div) {
    var y = document.getElementById(div);
    y.style.display = "block";
}
function hideDiv(div) {
    var y = document.getElementById(div);
    y.style.display = "none";
}
</script>

<script>
function setTimer(time) {
    var seconds_left = parseInt(time);
    var interval = setInterval(function() {
    document.getElementById('timer_div').innerHTML = seconds_left--;

    if (seconds_left < -1)
    {
       document.getElementById('timer_div').innerHTML = "Please submit your answer!";
       clearInterval(interval);
       showDiv('button_div');
       setTimer2();
    }
}, 1000);

}
</script>
<script>
function setTimer2() {
    var seconds_left2 = 5;
    var interval = setInterval(function() {
    seconds_left2--;
   <?php
   if (isset($_GET['submit'])) { ?>
    document.getElementById('timer_div').innerHTML = "Please wait...";
    <?php } ?>
    if (seconds_left2 < -1) {
    	hideDiv('button_sub');
    	document.getElementById('correctAnswer').style.border="thick solid teal";
    	<?php 
    	$sql = "SELECT Total, Total_Correct FROM question WHERE QCode=$qcode";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $total = (int)$row['Total'];
        $total_corrrect = (int)$row['Total_Correct'];
        if ($total==0 && $total_corrrect==0)
        	$success_rate = 0;
        else
        	$success_rate = ($total_corrrect/$total)*100;
        $success_rate = number_format((float)$success_rate, 2, '.', '');
        $sql = "UPDATE question SET Statistics=$success_rate WHERE QCode=$qcode";
        $result = mysqli_query($conn, $sql);
    	?>
       document.getElementById('timer_div').innerHTML = "Statistics:<br/>Total answers: <?= $row['Total'] ?> Success Rate: <?= $success_rate ?>%";
       clearInterval(interval);
    }
}, 1000);

}
</script>
    
</head>

<body>

<span title="HOME PAGE"><img src="logoW.png" height="90" width="122" id="logo"></span>

<header>
     <?php
   if(isset($_SESSION['type'])) { 
        $teacherID = $_GET['id'];?>
        <br/>
        <a href="select_question.php?course=<?= $courseKey ?>&id=<?= $teacherID ?>&lecture=<?= $lcode ?>" class="button buttonTop buttonTop">Back</a>
        <?php }
        else {?>
        <br/>
        <a href="select_question.php?course=<?= $courseKey ?>&lecture=<?= $lcode ?>" class="button buttonTop buttonTop">Back</a>
    <?php
    }
    if(isset($_SESSION['type'])) { ?>
        <center><a href="logout.php" class="button buttonTop buttonHead">Log out</a></center>
    <?php } ?>
</header>

<img src="logoW.png" height="90" width="122" id="logo">
<?php 
	$sql = "SELECT Question FROM question WHERE QCode=$qcode";
   	$result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>
<div class="titleBox"><h2><?= $row['Question'] ?></h2></div>

<table class="tableone">
    <thead>
        <tr>
          <th class="codeElement" scope="col">CODE</th> 
          <th class="textElement" scope="col">ANSWER</th>
        </tr>
    </thead>
    <tbody>
    <tr><td colspan="2">
			<div class="wrapper">
        <form method="post" action="php_answer.php">
            <select name="answers" class="selection" multiple>
            
                    <?php
                        mysqli_query($conn,"SET NAMES utf8");
						$sql = "SELECT Time FROM question WHERE QCode='$qcode'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $timer = $row['Time'];
                        $sql = "SELECT * FROM possible_answer WHERE QCode='$qcode'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)==true){
                            // output data of each row
                            $i=1;
                            while($row = mysqli_fetch_assoc($result)) {
                            	if ($row['Correct']==1){
                                	echo "<option id='correctAnswer' value='".$row["AnswerNo"]."'>".$i."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row["Description"]."</option>";
                                } else {
                                	echo "<option value='".$row["AnswerNo"]."'>".$i."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row["Description"]."</option>";
                                }
                                $i++;
                            }
                        }
            
                    ?> 
            </select>
        <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" placeholder="Lecture_Code">
        <input type="hidden" name= "course" value="<?php echo $courseKey; ?>" placeholder="Course_key" >
        <input type="hidden" name= "teacherID" value="<?php echo $teacherID; ?>" placeholder="Teacher id" >
	<input type="hidden" name= "QCode" value="<?php echo $qcode; ?>" placeholder="QCode" >
	 <div id="button_div" style="display: none;">
    <center><input type="submit" id="button_sub" name="submit" value="Submit" class="button"></center>
</div>
        <?php if(isset($_SESSION['type'])) { ?>
        <input type="submit" id="button_delete" name="delete" value="Delete" class="button">
        <input type="submit" id="button_edit" name="edit" value="Edit" class="button">
        <?php } ?>
    
        </form>      
            
        </div>
        </td></tr>
    </tbody>
</table>

<?php if(isset($_SESSION['type'])) { ?>
<button onclick="document.getElementById('add').style.display='block'" class="button buttonAdd">Add</button>
<?php }?>

<?php if(isset($_GET['answer'])) {
        $answer = $_GET['answer']; 
    }
?>

<?php if(!isset($_SESSION['type']) && !isset($_GET['submit'])) { ?>
<script>
    setTimer(<?= $timer ?>);
</script>
<?php }?>

<?php if (isset($_GET['submit'])) { ?>
<script>
	setTimer2();
</script>
<?php } ?>


<h1><center><div id="timer_div"></div></center></h1>



<!-- Add Modal -->
<div id="add" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom">
         <div class="w3-container w3-teal">
            <span onclick="document.getElementById('add').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
            <h3 style="font-weight:bold";>Add new Answer</h3>
        </div>
        <div class="w3-container">

                <form method="post" action="php_answer.php">
                    <center><input type="text" id="in_text" name="description" placeholder="Answer" required></center>
		    <center><input type="text" id="in_text" name="correct" placeholder="Is the correct answer (yes/no)?" required></center>
                    <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" placeholder="Lecture_Code">
                    <input type="hidden" name= "course" value="<?php echo $courseKey; ?>" placeholder="Course_key" >
                    <input type="hidden" name= "teacherID" value="<?php echo $teacherID; ?>" placeholder="Teacher id" >
                    <input type="hidden" name= "QCode" value="<?php echo $qcode ?>" placeholder="QCode" >
		    <br>
                    <center><button type="submit" id="modal" name="insert" value="Add" >Add answer</button></center>
		    <br>
                </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom">
         <div class="w3-container w3-teal">
            <span onclick="document.getElementById('edit').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
           <h3 style="font-weight:bold";>Edit Answer</h3>
        </div>
        <div class="w3-container">
                <form method="post" action="php_answer.php">
                    <?php 
                    $sql = "SELECT * FROM possible_answer WHERE AnswerNo ='$answer'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if($row['Correct'] == 1){
                        $row['Correct'] = "yes";}
                     else{
                        $row['Correct']="no";}
                    ?>
                    <p><center>Answer :<input type="text" id="in_text" name="description" value="<?= $row['Description'] ?>" required></center></p>
                    <p><center>Correct? (yes/no)<input type="text" name="correct" id="cor_text" value="<?= $row['Correct'] ?>" required></center></p>
                    <input type="hidden" name= "teacherID" value="<?php echo $teacherID; ?>" placeholder="Teacher id">
                    <input type="hidden" name= "QCode" value="<?php echo $qcode; ?>" placeholder="QCode">
                     <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" placeholder="Lecture_Code">
                    <input type="hidden" name= "course" value="<?php echo $courseKey; ?>" placeholder="Course_key" >
                    <input type="hidden" name= "answers" value="<?php echo $answer; ?>" placeholder="Answer" >
		    <br>
                    <center><button type="submit" id="modal" name="edit2" value="Edit" >Edit answer</button></center>
		    <br>
                </form>

        </div>
    </div>
</div>


<?php if(isset($_GET['answer'])) {?>
        <script>
        document.getElementById('edit').style.display='block';
        </script>
  <?php } ?>

</body>

</html>
