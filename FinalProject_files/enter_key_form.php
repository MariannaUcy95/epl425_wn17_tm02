<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="styling.css" />

<script>
function showErrorMessage3() {
    alert("Wrong key!");
    
}
</script>
    
</head>

<body>

	<?php
    session_start();
    $course = $_GET['course'];
    if(isset($_SESSION['error3'])) { ?>
        <script type='text/javascript'>
            showErrorMessage3();
        </script>
        <?php 
        unset($_SESSION['error3']);
    } ?>

<span title="HOME PAGE"><img src="logoW.png" height="90" width="122" id="logo"></span>

<header class="w3-container w3-teal">
    <br/>
   <a href="select_course.php" class="button buttonTop">Back</a>
</header>

<img src="logoW.png" height="90" width="122" id="logo"> 
<br/>
<div class="titleBox"><h1>Enter the course key</h1></div>
<form method="post" action="enter_key.php?course=<?= $course ?>">
    <center><p><input type="text" name="Course_key" required></center></p>
	<br/>
	<center><button style="position: absolute; left: -9999px; width: 1px; height: 1px;" tabindex="-1" class="button buttonBottom" type="submit"></button></center>
	<center><button class="button" id="button_sub2" type="submit">Submit</button></center>
</form>

</body>

</html>