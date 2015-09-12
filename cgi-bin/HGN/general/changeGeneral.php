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

$user_id = $_SESSION["user_id"];
$firstname_new = $_POST["first_name_new"];
$lastname_new = $_POST["last_name_new"];
$email_new = $_POST["email_new"];
$tel_new = $_POST["tel_new"];
$dob_new = $_POST["dob_new"];

function look($looktable, $value, $conn, $user_id){

		$sqllook = "SELECT * FROM user WHERE {$looktable} = '{$value}' AND user_id <> '{$user_id}' ";
		$resultlook = mysqli_query($conn, $sqllook);

		if (mysqli_num_rows($resultlook) == 0) {
			return false;
		}
		return true; 
		}

	if ($firstname_new == "" || $lastname_new == "" || $email_new == "" || $email_new == "" || $tel_new == "" || $dob_new == ""){
		die("<script> alert('One or more fields is empty.'); window.location.href='../general'; </script>");
	}
	
	else

	if (look("user_mail", $email_new , $conn, $user_id)){
		die("<script> alert('Email already exists on the system.'); window.location.href='../general'; </script>");
	}


$sql = "UPDATE user SET user_first_name = '{$firstname_new}', user_last_name = '{$lastname_new}', user_mail = '{$email_new}', user_tel = '{$tel_new}', user_dob = '{$dob_new}' WHERE user_login = '{$username}' ";
$result = mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn)>0) {
	$row = mysqli_fetch_assoc($result);
	$_SESSION["user_first_name"] = $firstname_new;
	$_SESSION['user_last_name'] = $lastname_new;
	header("Location:../general");
}



?>