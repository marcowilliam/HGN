<?php

	$password = "";
	function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

	$email = $_POST["email"];

	$servername = "localhost";
	$user_db = "ethosolu_ocApp";
	$password_db = "8888Thisawesomepassword!!";
	$dbname = "ethosolu_ocApp";
	$password_new = random_password();
	$password_encrypted = md5($password_new);


// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

	$sql2 = "UPDATE user SET user_password='{$password_encrypted}' WHERE user_mail = '{$email}'";
	$result2 = mysqli_query($conn, $sql2);
	if (mysqli_affected_rows($conn)>0){
		$to = $email;
		$subject = "Password - Highest Good Network Application";
		$message = "Password changed. Your new password is " . $password_new . " . You can access the application on http://highestgoodnetwork.com . Enjoy! /o/";
		include("sendEmail.php");

		echo "<script> window.location.href='index.php' </script>";

		//header("Location: index.php");
	} else {
		echo "<script> alert('This email does not exist in our records, try again.'); window.location.href='forgotPassword.php'</script>";
	}
	
	mysqli_close($conn);

?>