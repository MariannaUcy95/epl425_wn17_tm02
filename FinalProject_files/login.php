<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "epl425");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Username = $_POST['Username'];
$Password = $_POST['Password'];

$sql =  "SELECT * FROM teacher WHERE Username='$Username' AND Password='$Password'";
$result = mysqli_query($conn, $sql); 

if(!$row=mysqli_fetch_assoc($result)) {
	$_SESSION['error'] = "Your username or password is incorrect!";
	mysqli_close($conn);
	header("Location: index.php");
} else {
	$_SESSION['type'] = "Teacher";
	mysqli_close($conn);
	header("Location: select_course.php?id=".$row['TeacherID']);
}
?>
