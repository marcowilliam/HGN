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
	$task_description = $_POST["task_description"];
	$task_category = $_POST["task_category"];
	$checked_users = $_POST["checked"];
	$task_id  = $_POST["task_id"];
	
	$task_description = nl2br($task_description);


	function look($looktable, $value, $conn){

		$sqllook = "SELECT * FROM user WHERE {$looktable} = '{$value}' ";
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


$sql = "UPDATE task SET task_name = '{$task_name}', task_description = '{$task_description}', category_id = {$task_category} WHERE task_id = '{$task_id}'";
$result = mysqli_query($conn, $sql);

$userc_id = $_SESSION["user_id"];

$sql3 = "UPDATE user_task SET visibility = 0 WHERE task_id = '{$task_id}' AND user_id <> {$userc_id} ";
$result3 = mysqli_query($conn, $sql3);

for ($i = 0; $i < count($checked_users); $i++) {
	$user_id = $checked_users[$i];
	
	$sql = "SELECT * FROM user_task WHERE user_id = '{$user_id}' AND task_id = '{$task_id}'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) == 0) {
		$sql2 = "INSERT INTO user_task (user_id, task_id, visibility) VALUES ({$user_id}, {$task_id}, 1) ";
		$result2 = mysqli_query($conn, $sql2);
	} else {
		$sql2 = "UPDATE user_task SET visibility = 1 WHERE user_id = {$user_id} AND task_id = {$task_id}";
		$result2 = mysqli_query($conn, $sql2);
	}
}




header("Location: ../setup-tasks");



?>