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

	$user_id_delete  = $_GET["v"];

	echo $user_id_delete;


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE user SET visibility = 0 WHERE user_id = {$user_id_delete}";
$result = mysqli_query($conn, $sql);

$sql2 = "UPDATE user SET user_type_id = 4 WHERE user_id = {$user_id_delete} AND user_type_id = 3";
$result2 = mysqli_query($conn, $sql2);

$sql3 = "UPDATE team SET team_manager = 0 WHERE team_manager = {$user_id_delete}";
$result3 = mysqli_query($conn, $sql3);

header("Location: ../users");

mysqli_close($conn);


?>