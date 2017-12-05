<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html" charset="ISO-8859-1" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="styling.css" />

<script>
function hideShowDivs(hideDiv, showDiv) {
    var x = document.getElementById(hideDiv);
    x.style.display = "none"; 
    var y = document.getElementById(showDiv);
    y.style.display = "block";
}
</script>

<script>
function showErrorMessage() {
	alert("Your username or password is incorrect!");
	
}
function showErrorMessage2() {
	alert("Username already used!");
	
}
function showMessage() {
	alert("You've successfully signed up!");
	
}
</script>

</head>

<body>

<?php
	session_start();
	if(isset($_SESSION['error'])) { ?>
		<script type='text/javascript'>
			showErrorMessage();
		</script>
		<?php 
	}
	if(isset($_SESSION['error2'])) { ?>
		<script type='text/javascript'>
			showErrorMessage2();
		</script>
		<?php 
	}
	if(isset($_SESSION['message'])) { ?>
		<script type='text/javascript'>
			showMessage();
		</script>
		<?php 
	}
?>

<div id="div_1">
	<img src="logoB.png" id="logoPrincipal"> 
	<center><button class="button buttonBottom" style="bottom:5%; left:38%;" onclick="hideShowDivs('div_1', 'div_2')">ENTER THE WEBSITE</button></center>
</div>

<?php
	if(isset($_SESSION['error']) || isset($_SESSION['error2']) || isset($_SESSION['message'])) { ?>
		<script type='text/javascript'>
			hideShowDivs('div_1', '');
		</script>
		<?php
	}
?>

<div id="div_2" style="display: none;">
	<br/>
	<a href="#" onclick="hideShowDivs('div_2', 'div_1')" class="button buttonTop">Back</a>
	<div class="titleBox"><h1>What are you?</h1></div>
	<br/>
	<br/>
	<center><a href="select_course.php" class="button buttonTop">Student</a></center>
	<br>
	<center><button class="button buttonTop" onclick="hideShowDivs('div_2', 'div_3')">Teacher</button></center>
</div>

<?php
	if(isset($_SESSION['error']) || isset($_SESSION['error2']) || isset($_SESSION['message'])) { ?>
		<script type='text/javascript'>
			hideShowDivs('div_2', '');
		</script>
		<?php
	}
?>

<div id="div_3" style="display: none;">
	<img src="logoW.png" height="90" width="122" id="logo"> 
	<br/>
	<a href="#" onclick="hideShowDivs('div_3', 'div_1')" class="button buttonTop">Back</a>
	<div class="titleBox"><h1>Identify yourself</h1></div>
	<form method="post" action="login.php">
    	<center><p>Username  <input type="text" name="Username" required></center></p>
    	<center><p>Password  <input type="password" name="Password" required></center></p> 
		<br/>
		<center><button style="position: absolute; left: -9999px; width: 1px; height: 1px;" tabindex="-1" class="button buttonBottom" type="submit"></button></center>
		<center><button class="button buttonBottom" type="submit" style="left:50%; bottom:20%;">Log In</button></center>
	</form>
	<center><button onclick="document.getElementById('signUp').style.display='block'" class="button buttonBottom" type="submit" style="left:35%; bottom:20%;">Sign Up</button></center>
</div>

<!-- Sign Up Modal -->
<div id="signUp" class="w3-modal">
  	<div class="w3-modal-content w3-animate-zoom">
   		<div class="w3-container w3-teal">
      		<span onclick="document.getElementById('signUp').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
      		<h3>Create an account</h3>
    	</div>
    	<div class="w3-container">
     		<pre>
				<form method="post" action="signUp.php">
					<input type="text" name="Name" placeholder="Name" required>
					<input type="text" name= "Username" placeholder="Username" required>
					<input type="password" name= "Password" placeholder="Password" required>
					<center><button type="submit" name="signUp" value="Sign Up" >Sign Up</button></center>
				</form>
			</pre>
      
    	</div>
  	</div>
</div>

<?php
	if(isset($_SESSION['error']) || isset($_SESSION['error2']) || isset($_SESSION['message'])) { ?>
		<script type='text/javascript'>
			hideShowDivs('div_1', 'div_3');
		</script>
		<?php
		unset($_SESSION['error']);
		unset($_SESSION['error2']);
		unset($_SESSION['message']);
	}
?>

</body>

</html>
