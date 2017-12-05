<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "epl425");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Name = $_POST['Name'];
$Username = $_POST['Username'];
$Password = $_POST['Password'];

$sql =  "SELECT * FROM teacher WHERE Username ='$Username'";
$result = mysqli_query($conn, $sql); 

if(!$row=mysqli_fetch_assoc($result)) {
	$sql2 =  "INSERT INTO teacher (TeacherName, Username, Password) VALUES ('$Name', '$Username', '$Password')";
	$result2 = mysqli_query($conn, $sql2); 
	mysqli_close($conn);
	$_SESSION['message'] = "You've successfully signed up!";
	header("Location: index.php");
} else {
	mysqli_close($conn);
	$_SESSION['error2'] = "Username already used!";
	header("Location: index.php");
	
}
?>
