<?php

	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['username']))      // if there is no valid session
	{
	    header("Location: ../index.php"); // SAIR
	}

	if ($_SESSION["user_type"]<>1){
		echo '<script> alert("You do not have permission to see this page"); window.location.href="../general"; </script>';
	}

	$username = $_SESSION['username'];
	$servername = $_SESSION['servername'];
	$user_db = $_SESSION['user_db'];
	$password_db = $_SESSION['password_db'];
	$dbname = $_SESSION['dbname'];


	$user_first_name = $_POST["user_first_name"];
	$user_last_name = $_POST["user_last_name"];
	$user_login = $_POST["user_login"];
	$user_type = $_POST["user_type"];

	// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

	$sql2 = "SELECT user_type_description FROM user_type WHERE user_type_id = '{$user_type}'";
	$result2 = mysqli_query($conn, $sql2);
	if (mysqli_num_rows($result2)) {
		$row = mysqli_fetch_assoc($result2);
		$user_type_description = $row["user_type_description"];
	}



?>

<html>
<head>
	<title>Setup - Highest Good Network </title>

	<link href="../styles/setup.css" rel="stylesheet">
	<link href="../styles/basicStyle.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>


	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
	<script type="text/javascript" src="../scripts/script.js"></script> 	

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



	<script>
  $(function() {
    $( "#datepicker" ).datepicker({
    	dateFormat: 'yy-mm-dd'
    });
  });
  </script>

  <script type="text/javascript">
function formatar_mascara(src, mascara) {
	var campo = src.value.length;
	var saida = mascara.substring(0,1);
	var texto = mascara.substring(campo);
	if(texto.substring(0,1) != saida) {
		src.value += texto.substring(0,1);
	}
}
</script>

</head>
<body>				
	<nav>
		<ul>
			<li> <a href="../profile.php"> PROFILE </a> </li>
			<li> <a href="../tasks"> TASKS </a> </li>
			<li> <a href="#"> REPORTS </a> </li>
			<li> <a href="#" class="active"> SETUP </a> </li>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0"> PORTAL </a> </li>
			<li class="right img"> <a href="../sessionStop.php"> <img src="../img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $_SESSION["user_first_name"] . " " . $_SESSION["user_last_name"] ?> </li>
		</ul>
	</nav>

	<content>

		<article class="navLeft">


			<table>
				<tr onClick="location.href='../general'">
					<td><img src="../img/generalIcon.png" class="icon" name="General"></td>
					<td valign="middle">General</td>
				</tr>
				<tr onClick="location.href='../privacy'">
					<td><img src="../img/privacyIcon.png" class="icon" name="Privacy"></td>
					<td valign="middle">Privacy</td>
				</tr>
				<tr onClick="location.href='../users'">
					<td><img src="../img/usersActiveIcon.png" class="icon" name="Users"></td>
					<td valign="middle">Users</td>
				</tr>
				<tr onClick="location.href='../teams'">
					<td><img src="../img/teamsIcon.png" class="icon" name="Teams"></td>
					<td valign="middle">Teams</td>
				</tr>
			</table>

		</article>



		<article class="rightArt" id="General">

			<form action="addUser.php" method="post" id="addUserForm">

			<table>
				<tr>
						<td class="title"> First Name </td>
						<td class="wrapper"> 
	  						<input type="text" value="<?php echo $user_first_name ?>" name="first_name_new">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> Last Name </td>
						<td class="wrapper"> 
	  						<input type="text" value="<?php echo $user_last_name ?>" name="last_name_new">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> Login </td>
						<td class="wrapper"> 
	  						<input type="text" value="<?php echo $user_login ?>" name="login_new">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> Email Address </td>
						<td class="wrapper"> 
	  						<input type="email" name="email_new">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> Phone Number </td>
						<td class="wrapper"> 
	  						<input type="text" name="tel_new">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> Date of Birth </td>
						<td class="wrapper"> 
	  						<input type="text" id="datepicker" placeholder="YYYY-MM-DD" name="dob_new" onkeypress="formatar_mascara(this, '####-##-##')">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> Expected Weekly Hours </td>
						<td class="wrapper"> 
	  						<input type="number" name="hours_new">
	  					</td>
  				</tr>

  				<tr>
						<td class="title"> User Type </td>
						<td class="wrapper"> 
	  						<div class="styled-select">
	  						<select name="type_new">
	  						
							<?php 

							$sql3 = "SELECT user_type_id, user_type_description FROM user_type";
							$result3 = mysqli_query($conn, $sql3);
							if ($result3 || mysqli_num_rows($result3) ) {
								while ($row3 = mysqli_fetch_assoc($result3)){
									$user_type_id_s = $row3["user_type_id"];
									$user_type_description_s = $row3["user_type_description"];

									echo "<option value='";
									echo $user_type_id_s;
									echo "' ";

									if ($user_type == $user_type_id_s) {
										echo "selected";
									}

									echo "> ";
									echo $user_type_description_s;
									echo "</option>";
								}
							}


							?>
							
							</select>
							</div>
	  					</td>
  				</tr>


  			</table>

  			<table id="tabela_submit" class="high_table">

				<tr onclick="document.getElementById('addUserForm').submit()">
					<td colspan=4 class="edit"> SUBMIT </td>
				</tr>

  			</form>

			</table>

  		</article>

 	</content>
 </body>
 </html>