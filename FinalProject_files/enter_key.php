<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "epl425");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Course_key = $_POST['Course_key'];
$course = $_GET['course'];

$sql =  "SELECT * FROM course WHERE Course_key=$Course_key AND $Course_key=$course";
$result = mysqli_query($conn, $sql); 

if(!$row=mysqli_fetch_assoc($result)) {
	$_SESSION['error3'] = "Wrong key!";
	mysqli_close($conn);
	header("Location: enter_key_form.php?course=".$course);
} else {
	mysqli_close($conn);
	header("Location: select_lecture.php?course=".$row["Course_key"]);
}
?>
