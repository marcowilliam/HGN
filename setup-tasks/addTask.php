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

	$task_name = $_POST["task_name"];
	$task_category = $_POST["task_type"];
	$task_description = $_POST["task_description"];
	$checked_users = $_POST["checked"];
	$task_visibility = $_POST["task_visibility"];
	$task_category = $_POST["task_category"];
	
	$task_description = nl2br($task_description);


	function look($looktable, $value, $conn){

		$sqllook = "SELECT * FROM task WHERE {$looktable} = '{$value}' ";
		$resultlook = mysqli_query($conn, $sqllook);

		if (mysqli_num_rows($resultlook) == 0) {
			return false;
		}
		return true; 
		
	}

	


	if ($task_name == ""){
		die("<script> alert('Task name is empty.'); window.location.href='../setup-tasks'; </script>");
	}
	
	else

	if (look("task_name", $task_name , $conn)){
		die("<script> alert('Task already exists on the system.'); window.location.href='../setup-tasks'; </script>");
	}

// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userc_id = $_SESSION["user_id"];
$today = date("Y-m-d");

$sql = "INSERT INTO task (task_name, task_description, category_id, user_id, visibility, task_beginning_date) VALUES ('{$task_name}', '{$task_description}', '{$task_category}', {$userc_id}, {$task_visibility}, '{$today}') ";
$result = mysqli_query($conn, $sql);
$task_id = mysqli_insert_id($conn);

if ($_SESSION["user_type"] == 3) {
	$sql2 = "INSERT INTO user_task (user_id, task_id, visibility) VALUES ({$userc_id}, {$task_id}, 1)";
	$result2 = mysqli_query($conn, $sql2);
}

for ($i = 0; $i < count($checked_users); $i++) {
	$user_id = $checked_users[$i];
	$sql2 = "INSERT INTO user_task (user_id, task_id, visibility) VALUES ({$user_id}, {$task_id}, 1) ";
	$result = mysqli_query($conn, $sql2);
}



header("Location: ../setup-tasks");


?>