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

	$sub_task_time_edit = $_POST["sub_task_time_edit"];
	//$task_id = $_POST["task_new"];
	$sub_task_id_edit = $_POST["sub_task_id_edit"];
//	$tdId = $_POST['idTd'];
	

	date_default_timezone_set('America/Los_Angeles');


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/* EXCEPTIONS */

$sql = "UPDATE sub_task
		SET sub_task_time='{$sub_task_time_edit}'
		WHERE sub_task_id='{$sub_task_id_edit}'";

$result = mysqli_query($conn, $sql);


if ($result){


echo "<script> window.location.href='../tasks'; </script>";

} else {

	echo "<br> deu merda :)";
}

?> 