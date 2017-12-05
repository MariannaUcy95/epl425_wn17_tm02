<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styling.css" />
    
</head>

<body>

<span title="HOME PAGE"><img src="logoW.png" height="90" width="122" id="logo"></span>

<header>
    <?php
    session_start();
    $courseKey = $_GET['course'];
    $lcode = $_GET['lecture'];
   if(isset($_SESSION['type'])) { 
        $teacherID = $_GET['id'];?>
        <br/>
        <a href="select_lecture.php?course=<?= $courseKey ?>&id=<?= $teacherID ?>" class="button buttonTop buttonTop">Back</a>
        <?php }
        else {?>
        <br/>
        <a href="select_lecture.php?course=<?= $courseKey ?>" class="button buttonTop buttonTop">Back</a>
    <?php
    } 
    if(isset($_SESSION['type'])) { ?>
        <center><a href="logout.php" class="button buttonTop buttonHead">Log out</a></center>
    <?php } ?>
</header>

<img src="logoW.png" height="90" width="122" id="logo"> 
<div class="titleBox"><h1>Select a question</h1></div>

<table class="tableone">
    <thead>
        <tr>
          <th class="codeElement" scope="col">CODE</th> 
          <th class="textElement" scope="col">QUESTION</th>
        </tr>
    </thead>
    <tbody>
    <tr><td colspan="2">
        <div class="wrapper">
        <form method="post" action="php_insert_update_delete_search.php">
            <select name="questions" class="selection" multiple>
            
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
                        $sql = "SELECT * FROM question WHERE question.LCode='$lcode'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)==true){
                            // output data of each row
                            $i=1;
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row["QCode"]."'>".$i."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row["Question"]."</option>";
                                $i++;
                            }
                        }
            
                    ?> 
            </select>
        <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" placeholder="Lecture_Code">
        <input type="hidden" name= "course" value="<?php echo $courseKey; ?>" placeholder="Course_key" >
        <input type="hidden" name= "teacherID" value="<?php echo $teacherID; ?>" placeholder="Teacher id" >
        <input type="submit" id="button_submit" name="next" value="Next" class="button">
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

<?php if(isset($_GET['question'])) {
        $qcode = $_GET['question']; 
    }
?>

<!-- Add Modal -->
<div id="add" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom">
         <div class="w3-container w3-teal">
            <span onclick="document.getElementById('add').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
            <h3 style="font-weight:bold";>Add new Question</h3>
        </div>
        <div class="w3-container">
            
                <form method="post" action="php_insert_update_delete_search.php">
                    <center><input type="text" id="in_text" name="question_title" placeholder="Title" required></center>
                    <center><input type="text" id="cor_text" name="time" placeholder="Timer" required></center>
                    <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" placeholder="Lecture_Code">
                    <input type="hidden" name= "course" value="<?php echo $courseKey; ?>" placeholder="Course_key" >
                    <input type="hidden" name= "teacherID" value="<?php echo $teacherID; ?>" placeholder="Teacher id" >
		    <br>
                    <center><button type="submit" id="modal" name="insert" value="Add" >Add question</button></center>
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
            <h3 style="font-weight:bold";>Edit Question</h3>
        </div>
        <div class="w3-container">
            
                <form method="post" action="php_insert_update_delete_search.php">
                    <?php 
                    $sql = "SELECT * FROM question WHERE QCode='$qcode'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <p><center>Question :<input type="text" id="in_text" name="question_title" value="<?= $row['Question'] ?>" required></center></p>
                    <p><center>Time to answer :<input type="text" id="cor_text" name="time" value="<?= $row['Time'] ?>" required>seconds</center></p>
                    <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" placeholder="Lecture_Code">
                    <input type="hidden" name= "course" value="<?php echo $courseKey; ?>" placeholder="Course_key" >
                    <input type="hidden" name= "teacherID" value="<?php echo $teacherID; ?>" placeholder="Teacher id">
                    <input type="hidden" name= "questions" value="<?php echo $qcode; ?>" placeholder="QCode">
		    <br>
                    <center><button type="submit" id="modal" name="edit2" value="Edit" >Edit question</button></center>
		    <br>
                </form>
            
      
        </div>
    </div>
</div>

<?php if(isset($_GET['question'])) {?>
        <script>
        document.getElementById('edit').style.display='block';
        </script>
  <?php } ?>

</body>

</html>
