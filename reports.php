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

	$user_display_id = $_POST["user_id"];


	// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

	$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail, user_dob FROM user WHERE user_login = '{$username}'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result)) {
	    $row = mysqli_fetch_assoc($result);
	    $user_id = $row["user_id"];
	    $first_name = $row["user_first_name"];
	    $last_name = $row["user_last_name"];
	    $user_type_id = $row["user_type_id"];
	    $user_tel = $row["user_tel"];
	    $user_mail = $row["user_mail"];
	    $user_dob = $row["user_dob"];
	}


	
	if ($user_display_id == "") {
		$user_display_id = $user_id;
	}
	


?>


<html>
<head>
	<title> Highest Good Network </title>
	
	<link href="styles/reports.css" rel="stylesheet">

	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	
	<link href="styles/basicStyle.css" rel="stylesheet">
	<link href="chosen/chosen.css" rel="stylesheet">
	
	<!-- CHOSEN -->
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	
	<script type="text/javascript" src="chosen/chosen.jquery.js"></script>
	<script type="text/javascript" src="chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="chosen/chosen.proto.js"></script>
	<script type="text/javascript" src="chosen/chosen.proto.min.js"></script>
	
  	<script type="text/javascript" src="scripts/jquery.autocomplete.min.js"></script>
  	
  	<script type="text/javascript" src="scripts/reports.js"></script>

</head>
<body>

<nav>
		<ul>
			<li> <a href="profile.php"> PROFILE </a> </li>
			<li> <a href="tasks"> TASKS </a> </li>
			<li> <a href="reports.php" class="active"> REPORTS </a> </li>
			<li> <a href="general"> SETUP </a> </li>
			<?php if ($_SESSION['user_type']==1 || $_SESSION['user_type']==2) { ?>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<?php } ?>
			<li class="right img"> <a href="sessionStop.php"> <img src="img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $first_name . " " . $last_name ?> </li>
		</ul>
</nav>



<form action="reports.php" id="formSubmit" method="post" style="margin:0;">
	<input type="hidden" name="team_id" id="team_id_form">
	<input type="hidden" name="user_id" id="user_id_form">
</form>
<!--
<div class="title">

	<?php
			$sql = "SELECT user_first_name, user_last_name FROM user WHERE user_id = {$user_display_id}";
		       	$result = mysqli_query($conn, $sql);
		       	
		       	if (mysqli_num_rows($result) > 0){
		        	while ($row = mysqli_fetch_assoc($result)){
		        		echo $row["user_first_name"] . " " . $row["user_last_name"] . " REPORT";
		        	}
		        }
	
	?>
	
<div class="searchBar">
	<select class="chosen" style="width:200px;" data-placeholder="Choose a country..." id="selecionado">
		<option value='' disabled selected style='display:none;'>Choose a Team or User</option>
		<optgroup label="Teams">
		        <?php
		        
		        	if ($_SESSION["user_type"]==1 || $_SESSION["user_type"]==2) {
		        		$sql = "SELECT team_id, team_description FROM team WHERE visibility=1";
		        	} else {
		        		$sql = "SELECT team_id, team_description FROM team WHERE visibility=1 AND team_id IN (SELECT team_id FROM user_team WHERE user_id =   {$user_id} AND visibility=1)";
		        	}
		  
		        	$result = mysqli_query($conn, $sql);
		        	
		        	if (mysqli_num_rows($result) > 0){
			        	while ($row = mysqli_fetch_assoc($result)){
			        		echo "<option value=" . $row["team_id"] . " onclick='submitFormTeam(" . $row["team_id"] . ")'>" . $row["team_description"] . "</option>";
			        	}
		        	} else {
		        		echo "<option disabled> No teams to show </option>";
		        	}
		        ?>
		</optgroup>
		<optgroup label="Users" title="users">
		
			<?php
		        
		        	if ($_SESSION["user_type"]==1 || $_SESSION["user_type"]==2) {
		        		$sql = "SELECT user_first_name, user_last_name, user_id FROM user WHERE visibility=1";
		        	} else {
		        		$sql = "SELECT user_first_name, user_last_name, user_id FROM user WHERE visibility=1 AND user_id IN (SELECT user_id FROM user_team WHERE visibility = 1 AND team_id IN (SELECT team_id FROM user_team WHERE user_id = {$user_id} AND visibility=1) )";
		        	}
		        	
		        	$result = mysqli_query($conn, $sql);
		        	
		        	if (mysqli_num_rows($result) > 0){
			        	while ($row = mysqli_fetch_assoc($result)){
			        		echo "<option value=" . $row["user_id"] . " onclick='$(#team_id).val()=0'>" .  $row["user_first_name"] . " " . $row["user_last_name"] . "</option>";
			        	}
		        	} else {
		        		echo "<option disabled> No users to show </option>";
		        	}
		        ?>
		
		</optgroup>
		
	</select> <i class="fa fa-search" style="font-size: 80%; cursor: hand;" onclick="submitForm()"></i>
</div>

</div>

-->
<div style='width:35%; height:35%; margin-left:30%; margin-top:2%; text-align:center;'>
<img class='underCons' src='img/construction.png' style='width:100%;'>
<h1>UNDER CONSTRUCTION</h1>
</div>

</body>
</html>

<?php
	mysqli_close($conn);
?>