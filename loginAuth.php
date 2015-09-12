<?php

	/* SO VAMOS USAR QUANDO TIVER PAGINA PARA LOGIN :) */
	$username = $_POST["username"];
	$password = md5($_POST["password"]);


	$servername = "localhost";
	//put here your access to your database
	$user_db = "";
	$password_db = "";
	$dbname = "";


// Create connection

$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_type_id, user_password, user_id, user_first_name, user_last_name FROM user WHERE user_login = '{$username}' AND visibility = 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row["user_password"] <> $password) {
    	echo '<script> alert("Username and password do not match"); window.location.href="index.php"; </script>';
    } else {
    	$user_type = $row["user_type_id"];
    	session_start();

    	$_SESSION['user_id'] = $row['user_id'];
    	$user_id = $row['user_id'];
    
	    $_SESSION['username'] = $username;
	    $_SESSION['user_type'] = $user_type;

		$_SESSION['servername'] = $servername;
		$_SESSION['user_db'] = $user_db;
		$_SESSION['password_db'] = $password_db;
		$_SESSION['dbname'] = $dbname;

		$sql2 = "SELECT team_id FROM user_team WHERE user_id = {$user_id}";
		$result2 = mysqli_query($conn, $sql2);

		$_SESSION['user_team'] = $result2;
		$_SESSION['user_team_query'] = $sql2;
		
		$_SESSION["user_first_name"] = $row["user_first_name"];
		$_SESSION["user_last_name"] = $row["user_last_name"];

	    header("Location:profile.php");
    }
} else {
	echo '<script> alert("Username does not exist in our database"); window.location.href="index.php"; </script>';
}



?>