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

// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = "";
$user_first_name = "";
$user_type_id = "";
$user_tel = "";
$user_mail = "";

$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail, user_dob FROM user WHERE user_login = '{$username}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];
    $user_first_name = $row["user_first_name"];
    $user_last_name = $row["user_last_name"];
    $_SESSION["user_first_name"] = $user_first_name;
    $_SESSION["user_last_name"] = $user_last_name;
    $user_type_id = $row["user_type_id"];
    $user_tel = $row["user_tel"];
    $user_mail = $row["user_mail"];
    $user_dob_velho = $row["user_dob"];
    $user_dob = date("d/m/Y", strtotime($user_dob_velho));
}

$sql2 = "SELECT user_type_description FROM user_type WHERE user_type_id = '{$user_type_id}'";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2)>0) {
	$row = mysqli_fetch_assoc($result2);
	$user_type_id = $row["user_type_description"];
}

$number_teams = 0;
$sql4 = "SELECT team_description FROM team WHERE team_id IN (SELECT team_id FROM user_team WHERE user_id = '{$user_id}')";
$result4 = mysqli_query($conn, $sql4);
while ($row = mysqli_fetch_assoc($result4)) {
	$number_teams++;
}


$currentWeek_temp = date("W", strtotime("D")); 
$currentWeek = $currentWeek_temp - 1;
$currentYear = date("Y", strtotime("D"));



$number_tasks = 0;
$sql5 = "SELECT task_id FROM task WHERE user_id = '{$user_id}'";
$result5 = mysqli_query($conn, $sql5);
if ($result5) {
	while ($row = mysqli_fetch_assoc($result5)) {
		$number_tasks += 1;
	}
}


function calcHours($week, $year, $user_id, $conn) {
	$sqlCalc = "SELECT SUM(sub_task_time) AS total_horas
			FROM sub_task LEFT JOIN task ON sub_task.task_id = task.task_id
			WHERE week(sub_task_date) = '{$week}' AND user_id = '{$user_id}' AND year(sub_task_date) = '{$year}'";
	$resultCalc = mysqli_query($conn, $sqlCalc);
	if (mysqli_num_rows($resultCalc) > 0) {
		$row = mysqli_fetch_assoc($resultCalc);
		if ($row["total_horas"] == NULL){
			return 0;
		}
		return $row["total_horas"];
	}

} 

$sum_hours_week_user = calcHours($currentWeek, $currentYear, $_SESSION['user_id'] , $conn);

?>


<html>
<head>
	<title> Highest Good Network </title>
	<link href="styles/profile.css" rel="stylesheet">
	<link href="styles/basicStyle.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
</head>
<body>

	<nav>
		<ul>
			<li> <a href="profile.php" class="active"> PROFILE </a> </li>
			<li> <a href="tasks"> TASKS </a> </li>
			<li> <a href="reports.php" > REPORTS </a> </li>
			<li> <a href="general"> SETUP </a> </li>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<li class="right img"> <a href="sessionStop.php"> <img src="img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $user_first_name . " " . $user_last_name ?> </li>
		</ul>
	</nav>

	<content>

		<article class="artLeft">

			<img src="img/pictureIcon.png">

		</article>

		<article class="artRight">

			<h1> <?php echo $user_first_name . " " . $user_last_name ?> </h1> <!-- PHP AQUI FOFÍSSIMA -->


			<table>
				<tr>
					<td><img src="img/loginIcon.png" title="Login" class="icon"></td>
					<td valign="middle"><?php echo $username ?></td>
				</tr>
				<tr>
					<td><img src="img/userTypeIcon.png" title="Role" class="icon"></td>
					<td valign="middle"><?php echo $user_type_id ?></td>
				</tr>
				<tr>
					<td><img src="img/phoneIcon.png" title="Phone" class="icon"></td>
					<td valign="middle"><?php echo $user_tel ?></td>
				</tr>
				<tr>
					<td><img src="img/emailIcon.png" title="Email" class="icon"></td>
					<td valign="middle"><?php echo $user_mail ?></td>
				</tr>
				<tr>
					<td><img src="img/birthdayIcon.png" title="Date of Birth" class="icon"></td>
					<td valign="middle"><?php echo $user_dob ?></td>
				</tr>
			</table>

		</article>

	</content>


	<footer>

		<!-- PHP AQUI TAMBEM -->

		<div class="footLeft">

			<h1 class="test"> <?php echo $sum_hours_week_user ?> </h1>
			<h2 class="test"> <?php if($sum_hours_week_user == 1){echo "Hour";} else{ echo "Hours";}?> </h2>
			<h3 class="test"> this week </h3>

		</div>

		<div class="footMid">

			<h1 class="test"> <?php echo $number_teams; ?> </h1>
			<h2 class="test"> <?php if($number_teams == 1){echo "Team";} else{ echo "Teams";}?> </h2>

		</div>

		<div class="footRight">

			<h1 class="test"> <?php echo $number_tasks ?></h1>
			


			<h2 class="test"> <?php if($number_tasks == 1){echo "Task";} else{ echo "Tasks";}?> </h2>

		</div>

	</footer>

</body>
</html>