<?php

	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['username']))      // if there is no valid session
	{
	    header("Location: ../index.php"); // SAIR
	}

	if ($_SESSION["user_type"]<>1 && $_SESSION["user_type"]<>3){
		echo '<script> alert("You do not have permission to see this page"); window.location.href="../general"; </script>';
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

	$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail FROM user WHERE user_login = '{$username}'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result)) {
	    $row = mysqli_fetch_assoc($result);
	    $user_id = $row["user_id"];
	    $first_name = $row["user_first_name"];
	    $last_name = $row["user_last_name"];
	    $user_type_id = $row["user_type_id"];
	    $user_tel = $row["user_tel"];
	    $user_mail = $row["user_mail"];
	}

	$sql2 = "SELECT user_type_description FROM user_type WHERE user_type_id = '{$user_type_id}'";
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
	<link rel="icon" type="image/png" href="../img/favicon.png"/>



</head>
<body>			
	<nav>
		<ul>
			<li> <a href="../profile.php"> PROFILE </a> </li>
			<li> <a href="../tasks"> TASKS </a> </li>
			<li> <a href="../reports.php"> REPORTS </a> </li>
			<li> <a href="../general" class="active"> SETUP </a> </li>
			<?php if ($_SESSION['user_type']==1 || $_SESSION['user_type']==2) { ?>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<?php } ?>
			<li class="right img"> <a href="../sessionStop.php"> <img src="../img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $first_name . " " . $last_name ?> </li>
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
				<?php if ($_SESSION["user_type"] == 1) { ?>
				<tr onClick="location.href='../users'">
					<td><img src="../img/usersIcon.png" class="icon" name="Users"></td>
					<td valign="middle">Users</td>
				</tr>
				<tr onClick="location.href='../teams'">
					<td><img src="../img/teamsIcon.png" class="icon" name="Teams"></td>
					<td valign="middle">Teams</td>
				</tr>
				<?php } if ($_SESSION["user_type"] == 1 || $_SESSION["user_type"] == 3) { ?>
				<tr onClick="location.href='../setup-tasks'">
					<td><img src="../img/taskActiveIcon.png" class="icon" name="Tasks"></td>
					<td valign="middle">Tasks</td>
				</tr>
				<?php } ?>
			</table>

		</article>



		<article class="rightArt" id="Teams">

		<table id="tabela">
			<thead>
			<form action="newtask.php" method="post" id="newTask">
				<tr class="header">
					<th colspan=2><input type="text" id="team_task1" placeholder="Task Name" name="task_name"/></th>
					
					<th class="td_icon" valign="middle" onclick="document.getElementById('newTask').submit()"><i class="fa fa-plus smallIcon"></i></th>

				</tr>
			</form>
			</thead>
			<tbody>
				<?php

					$count = 1;
					if ($_SESSION["user_type"] == 1) {
						$sql = "SELECT task_id, task_name, user_id FROM task WHERE task_name <> 'Welcome' AND visibility = 1 ORDER BY task_name";
					}
					else if ($_SESSION["user_type"] == 3) {
						$sql = "SELECT t.task_id, t.task_name, t.user_id FROM task AS t RIGHT JOIN user_task AS ut ON t.task_id = ut.task_id WHERE t.task_name <> 'Welcome' AND ut.user_id = {$user_id} AND (t.visibility = 1) ORDER BY t.task_name";
					}
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0){
						while ($row=mysqli_fetch_assoc($result)){
							if (( $count % 2 )== 0){
								echo "<tr class='odd' valign='middle'>";
							} else {
								echo "<tr>";
							}
							$count++;
							$task_owner = $row["user_id"];

							echo "<td valign='middle'>";
							echo $row["task_name"];
							
							
							echo "</td> 
								<td class='td_icon' valign='middle' style='padding-right: 0;'>
									"; ?>
									<i class="fa fa-pencil-square-o fa-lg smallIcon" onClick="window.location.href='editTask.php?v=<?php echo $row["task_id"];?>'"></i>
								</td> 
							<td class="td_icon"> <i class="fa fa-times fa-lg smallIcon" style=
							
							<?php
							if ($task_owner == $user_id || $_SESSION["user_type"] == 1) {
								$task_id = $row["task_id"];  
								?> "color: red;" onClick="window.location.href='deleteTask.php?v=<?php echo $task_id; ?>'"></i>
							<?php
							} else {
								echo "'color: grey;'></i>";
							}
							?>							
							</tr> 
							<?php
						}
					} else {
					
						echo "<tr><td style='text-align: center;'>No Visible Tasks</td></tr>";
					
					} ?>
			</tbody>
		</table>
		
		<h1 style="font-weight: 300; font-size: 200%; padding-top: 10%;"> <i class="fa fa-times fa-lg" style="font-size: 100%; color: red;"></i> Deleted Tasks </h1>

		<table id="tabela2">
			<thead>
			<form action="newtask.php" method="post" id="newTask">
				<tr class="header">
					<th colspan=2><input type="text" id="team_task1" placeholder="Task Name" name="task_name"/></th>

				</tr>
			</form>
			</thead>
			<tbody>
				<?php

					$count = 1;
					if ($_SESSION["user_type"] == 1) {
						$sql = "SELECT task_id, task_name FROM task WHERE task_name <> 'Welcome' AND visibility = 0 ORDER BY task_name";
					}
					else if ($_SESSION["user_type"] == 3) {
						$sql = "SELECT t.task_id, t.task_name FROM task AS t RIGHT JOIN user_task AS ut ON t.task_id = ut.task_id WHERE t.task_name <> 'Welcome' AND ut.user_id = {$user_id} AND (t.visibility = 0 AND t.user_id = {$user_id}) ORDER BY t.task_name";
					}
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0){
						while ($row=mysqli_fetch_assoc($result)){
							if (( $count % 2 )== 0){
								echo "<tr class='odd' valign='middle'>";
							} else {
								echo "<tr>";
							}
							$count++;

							echo "<td valign='middle'>";
							echo $row["task_name"];
							echo "</td> 
								<td class='td_icon' valign='middle'>
									"; ?>
									<i class="fa fa-undo fa-lg smallIcon" onClick="window.location.href='recoverTask.php?v=<?php echo $row["task_id"];?>'"></i>
								</td> 
							
							</tr> <?php
						}
					} else {
					
						echo "<tr><td style='text-align: center;'>No Deleted Tasks</td></tr>";
					
					} ?>
			</tbody>
		</table>

		</article>

 	</content>
 </body>
 </html>