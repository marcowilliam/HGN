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

	$user_task_id_new_subtask = $_POST["task_new"];
	$subtaskname = $_POST["currency"];
	$subtaskdescription0 = $_POST["subtaskdescription"];
	$subtasktype = $_POST["subtasktype"];
	$subtasktime = $_POST["subtasktime"];

	
	$text = $subtaskdescription0;

	$rexProtocol = '(https?://)?';
	$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
	$rexPort     = '(:[0-9]{1,5})?';
	$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
	$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
	$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
		
	/*	
	function callback($match)
		{
		    // Prepend http:// if no protocol specified
		    $completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";
		
		    return '<a class="inside_link"  target="_blank" href="' . $completeUrl . '">'
		        . $match[2] . $match[3] . $match[4] . '</a>';
		}
		
	
	$subtaskdescription = preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&",
		    'callback', htmlspecialchars($text));
		    */
		    
	$subtaskdescription = $subtaskdescription0;
		
	$subtaskdescription = nl2br($subtaskdescription);
					
	
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


	if ($user_task_id_new_subtask == "" || $subtaskname == "" || $subtaskdescription0 == ""){
		die("<script> alert('One or more fields are empty.'); window.location.href='../tasks'; </script>");
	}

$today = date("Y-m-d");


$sql = "INSERT INTO sub_task (user_task_id, sub_task_name, sub_task_description, sub_task_type_id, sub_task_time, sub_task_date) 
VALUES ('{$user_task_id_new_subtask}', '{$subtaskname}', '{$subtaskdescription}', '{$subtasktype}', '{$subtasktime}', '{$today}') ";
$result = mysqli_query($conn, $sql);


if ($result){




} else {

	echo "<script> alert('Error: only use accepted characters'); </script>";
	echo "<script> window.location.href='../tasks'; </script>";
	
	
}

?> 