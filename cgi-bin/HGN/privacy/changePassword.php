<?php

	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['username']))      // if there is no valid session
	{
	    header("Location: ../index.php"); // SAIR
	}

	$username = $_SESSION['username'];
	$servername = $_SESSION['servername'];
	$user_db = $_SESSION['user_db'];
	$password_db = $_SESSION['password_db'];
	$dbname = $_SESSION['dbname'];

// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$password_new = md5($_POST["password_new"]);
$password_old = md5($_POST["password_old"]);

$sql = "SELECT user_password, user_id FROM user WHERE user_login = '{$username}' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$user_password_old = $row["user_password"];
$user_id = $row["user_id"];

if ($user_password_old == $password_old) {
	$sql2 = "UPDATE user SET user_password = '{$password_new}' WHERE user_id = '{$user_id}' ";
	$result2 = mysqli_query($conn, $sql2);
	if (mysqli_affected_rows($conn)>0){
		echo '<script> alert("Password successfully changed!") ; window.location.href="../privacy" ;</script>';
	}
} else {
	echo '<script> alert("Wrong Password"); window.location.href="../privacy"; </script>';
}


?>