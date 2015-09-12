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

	$sub_task_description_edit0 = $_POST["sub_task_description_edit"];
	//$task_id = $_POST["task_new"];
	$sub_task_id_edit = $_POST["sub_task_id_edit"];
//	$tdId = $_POST['idTd'];
	
	
	
	$text = $sub_task_description_edit0;
	
	
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
		
		
	$sub_task_description_edit = preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&",
		    'callback', htmlspecialchars($text));
	*/
	
	$sub_task_description_edit = nl2br($sub_task_description_edit0);
	
	
	
        $sub_task_description_edit = nl2br($sub_task_description_edit);
        

	
	
	date_default_timezone_set('America/Los_Angeles');


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/* EXCEPTIONS */

$sql = "UPDATE sub_task
		SET sub_task_description='{$sub_task_description_edit}'
		WHERE sub_task_id='{$sub_task_id_edit}'";

$result = mysqli_query($conn, $sql);


if ($result){


echo "<script> window.location.href='../tasks'; </script>";

} else {

	echo "<br> deu merda :)";
}

?> 