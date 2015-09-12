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

// POSTS ;)

	$task_id = $_POST["task_new"];
	$subtaskname = $_POST["subtaskname"];
	$subtaskdescription = $_POST["subtaskdescription"];
	$subtasktype = $_POST["subtasktype"];
	$subtasktime = $_POST["subtasktime"];

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


	if ($subtaskname == "" || $subtaskdescription == ""){
		die("<script> alert('One or more fields are empty.'); window.location.href='../tasks'; </script>");
	}

$today = date("Y-m-d");


$sql = "INSERT INTO sub_task (task_id, sub_task_name, sub_task_description, sub_task_type_id, sub_task_time, sub_task_date) 
VALUES ('{$task_id}', '{$subtaskname}', '{$subtaskdescription}', '{$subtasktype}', '{$subtasktime}', '{$today}') ";
$result = mysqli_query($conn, $sql);


if ($result){


echo "<script> window.location.href='../tasks'; </script>";

} else {

	echo "<br> deu merda :)";
}

?> 