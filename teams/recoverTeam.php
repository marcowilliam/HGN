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

	$team_id  = $_GET["v"];


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlSelect = "SELECT team_manager FROM team WHERE team_id = {$team_id}";
$resultSelect = mysqli_query($conn, $sqlSelect);
$row = mysqli_fetch_assoc($resultSelect);
$team_manager = $row["team_manager"];


$sqlManager = "UPDATE user SET user_type_id = 3 WHERE user_type_id <> 1 AND user_type_id <> 2 AND user_id = {$team_manager}";
$resultManager = mysqli_query($conn, $sqlManager);

$sql2 = "UPDATE team SET visibility = 1 WHERE team_id = {$team_id}";
$result2 = mysqli_query($conn, $sql2);


header("Location: ../teams");

mysqli_close($conn);

?>