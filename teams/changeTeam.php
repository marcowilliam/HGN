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

	$team_name = $_POST["team_description"];
	$checked_users = $_POST["checked"];
	$team_id  = $_POST["team_id"];
	$team_manager = $_POST["manager"];


	function look($looktable, $value, $conn){

		$sqllook = "SELECT * FROM user WHERE {$looktable} = '{$value}' ";
		$resultlook = mysqli_query($conn, $sqllook);

		if (mysqli_num_rows($resultlook) == 0) {
			return false;
		}
		return true; 
		
	}

	if ($team_name == ""){
		die("<script> alert('Team name is empty.'); window.location.href='../users'; </script>");
	}
	
	else

	if (look("team_description", $team_name , $conn)){
		die("<script> alert('Team already exists on the system.'); window.location.href='../users'; </script>");
	}


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE team SET team_description = '{$team_name}', team_manager = {$team_manager} WHERE team_id = '{$team_id}'";
$result = mysqli_query($conn, $sql);

$sql3 = "UPDATE user_team SET visibility = 0 WHERE team_id = {$team_id}";
$result3 = mysqli_query($conn, $sql3);

for ($i = 0; $i < count($checked_users); $i++) {
	$user_id = $checked_users[$i];
	
	$sql = "SELECT * FROM user_team WHERE user_id = {$user_id} AND team_id = {$team_id}";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) == 0) {
		$sql2 = "INSERT INTO user_team (user_id, team_id, visibility) VALUES ('{$user_id}', '{$team_id}', 1) ";
		$result2 = mysqli_query($conn, $sql2);
	} else {
		$sql2 = "UPDATE user_team SET visibility = 1 WHERE user_id = {$user_id} AND team_id = {$team_id}";
		$result2 = mysqli_query($conn, $sql2);
	}
	
	
}

$sqlManager = "UPDATE user SET user_type_id = 3 WHERE user_type_id <> 1 AND user_type_id <> 2 AND user_id = {$team_manager}";
$resultManager = mysqli_query($conn, $sqlManager);


$sqlChange = "UPDATE user SET user_type_id = 4 WHERE user_type_id <> 1 AND user_type_id <> 2 AND user_id NOT IN (SELECT team_manager FROM team WHERE visibility=1)";
$resultChange = mysqli_query($conn, $sqlChange);



header("Location: ../teams");

mysqli_close($conn);

?>