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
	$user_id = $_SESSION['user_id'];

// POSTS ;)

	$taskName = $_POST["taskName"];
	$taskCategory = $_POST["taskCategory"];
	$taskDescription = $_POST["taskDescription"];

	date_default_timezone_set('America/Los_Angeles');


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/* EXCEPTIONS */


	function look($looktable, $value, $conn){

		$sqllook = "SELECT * FROM user WHERE {$looktable} = '{$value}' ";
		$resultlook = mysqli_query($conn, $sqllook);

		if (mysqli_num_rows($resultlook) == 0) {
			return false;
		}
		return true; 
	}


	if ($taskName == "" || $taskDescription == ""){
		die("<script> alert('One or more fields are empty.'); window.location.href='../tasks'; </script>");
	}

$today = date("Y-m-d");


$sql = "INSERT INTO task (task_name, task_description, task_beginning_date, category_id, user_id) 
VALUES ('{$taskName}', '{$taskDescription}', '{$today}', '{$taskCategory}', '{$user_id}') ";
$result = mysqli_query($conn, $sql);



if ($result){


echo "<script> window.location.href='../tasks'; </script>";

} else {

	echo "<br> deu merda :)";
	echo $sql;
}

?> 