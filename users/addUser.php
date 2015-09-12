<?php



// Create connection



	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['username']))      // if there is no valid session
	{
	    header("Location: ../index.php"); // get out
	}

	$username = $_SESSION['username'];
	$servername = $_SESSION['servername'];
	$user_db = $_SESSION['user_db'];
	$password_db = $_SESSION['password_db'];
	$dbname = $_SESSION['dbname'];

// POSTS ;)

	$user_first_name = $_POST["first_name_new"];
	$user_last_name = $_POST["last_name_new"];
	$user_login = $_POST["login_new"];
	$user_email = $_POST["email_new"];
	$user_tel = $_POST["tel_new"];
	$user_type = $_POST["type_new"];
	$user_dob = $_POST["dob_new"];
	$user_hours = $_POST["hours_new"];


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


	$password = "";
	function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

	$email = $user_email;

	$password_new = random_password();
	$password_encrypted = md5($password_new);


/* EXCEPTIONS */


	function look($looktable, $value, $conn){

		$sqllook = "SELECT * FROM user WHERE {$looktable} = '{$value}' ";
		$resultlook = mysqli_query($conn, $sqllook);

		if (mysqli_num_rows($resultlook) == 0) {
			return false;
		}
		return true; 
	}


	if ($user_first_name == "" || $user_last_name == "" || $user_login == "" || $user_email == "" || $user_tel == "" || $user_hours == ""){
		die("<script> alert('One or more fields is empty.'); window.location.href='../users'; </script>");
	} else
	

	if (look("user_login", $user_login, $conn)){
		die("<script> alert('Login already exists on the system.'); window.location.href='../users'; </script>");
	}
	
	else

	if (look("user_mail", $user_email, $conn)){
		die("<script> alert('Email already exists on the system.'); window.location.href='../users'; </script>");
	}




$sqltype = "SELECT user_type_id FROM user_type WHERE user_type_description = '{$user_type}' ";
$resulttype = mysqli_query($conn, $sqltype);
if ($resulttype){
	$row = mysqli_fetch_assoc($resulttype);
	$user_type_id = $row["user_type_id"];
}


$sql = "INSERT INTO user (user_type_id, user_login, user_first_name, user_last_name, user_DOB, user_week_hrs, user_tel, user_mail, user_password, visibility) 
VALUES ('{$user_type}', '{$user_login}', '{$user_first_name}', '{$user_last_name}', '{$user_dob}', '{$user_hours}', '{$user_tel}', '{$user_email}', '{$password_encrypted}', 1) ";
$result = mysqli_query($conn, $sql);

$userc_id = mysqli_insert_id($conn);

$today = date("Y-m-d");



$sql2 = "INSERT INTO user_task (user_id, task_id, visibility) VALUES ({$userc_id}, 91, 0)";
$result2 = mysqli_query($conn, $sql2);
$user_task_id = mysqli_insert_id($conn);

$description_subtask = "Welcome to the Highest Good Network!  This application will help you manage your hours and projects for One Community Global. Here is a guide for a quick understanding of what is going on: http://www.onecommunityglobal.org/hgn-tutorial/";


$sql3 = "INSERT INTO sub_task (sub_task_name, sub_task_description, user_task_id, sub_task_type_id, sub_task_time, sub_task_date) VALUES ('', '{$description_subtask}', {$user_task_id}, 2, 0, '{$today}')";
$result3 = mysqli_query($conn, $sql3);



if ($result && $result2 && $result3){

	$to = $email;
	$subject = "Password - Highest Good Network Application";
	$message = "Welcome to the Highest Good Network. Your login is " . $user_login . ". Your password is " . $password_new . " . You can enter the application on http://highestgoodnetwork.com";
	include("../sendEmail.php");
	echo "<script> window.location.href='../users'; </script>";

} else {

	echo "<br> Sign in again! :)";
}

mysqli_close($conn);

?> 