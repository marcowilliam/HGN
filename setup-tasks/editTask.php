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

$task_id = $_GET["v"];

$sql2 = "SELECT task_name, task_description, category_id, user_id, visibility FROM task WHERE task_id = '{$task_id}'";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result)) {
	$row = mysqli_fetch_assoc($result2);
	$task_description = $row["task_description"];
	$task_name = $row["task_name"];
	$task_category = $row["category_id"];
	$task_visibility = $row["visibility"];
	$task_owner = $row["user_id"];
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
	<link rel="icon" type="image/png" href="img/favicon.png"/>



</head>
<body>				
	<nav>
		<ul>
			<li> <a href="../profile.php"> PROFILE </a> </li>
			<li> <a href="../tasks"> TASKS </a> </li>
			<li> <a href="#"> REPORTS </a> </li>
			<li> <a href="#" class="active"> SETUP </a> </li>
			<?php if ($_SESSION['user_type']==1 || $_SESSION['user_type']==2) { ?>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<?php } ?>
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

		<article class="rightArt" id="addTeam">
			<form action="changeTask.php" method="post" id="changeTaskForm" name="changeTask">
			<input type="hidden" value='<?php echo $task_id; ?>' name="task_id">
			<table>
				<tr>
						<td> Task Name </td>
						<td> <input type="text" class="wrapper" name="task_name" value="<?php echo $task_name; ?>" <?php if ($task_owner <> $user_id && $_SESSION["user_type"] <> 1) { echo "disabled"; } ?>> </td>
					</tr>

					<tr>
						<td> Task Category </td>
						<td> 
							<div class="styled-select" style="font-size: 85%;" >
							<select name="task_category" <?php if ($task_owner <> $user_id && $_SESSION["user_type"] <> 1) { echo "disabled"; } ?>> 

								<?php 

								$sql3 = "SELECT category_id, category_description FROM category";
								$result3 = mysqli_query($conn, $sql3);
								if ($result3 || mysqli_num_rows($result3) ) {
									while ($row3 = mysqli_fetch_assoc($result3)){
										$task_category_id = $row3["category_id"];
										$task_category_name = $row3["category_description"];

										echo "<option value='";
										echo $task_category_id;
										echo "' ";
										if ($task_category_id == $task_category) {
											echo "selected";
										}
										echo "> ";
										echo $task_category_name;
										echo "</option>";
									}
								}


								?>


							</select>
							</div>

						</td>
					</tr>

					<tr>
						<td> Task Description </td>
						<td> <textarea class="wrapper" rows=4 name="task_description" <?php if ($task_owner <> $user_id && $_SESSION["user_type"] <> 1) { echo "disabled"; } ?>> <?php echo $task_description; ?> </textarea> </td>
					</tr>
					 <?php if ($task_owner <> $user_id && $_SESSION["user_type"] <> 1) { echo "<tr><td colspan=2 style='padding-top: 1%;'> (*) You can't edit the fields because the task was created by an Administrator.</td></tr>"; } ?>
					


					
  			</table>	

  			<table id="tabelaGeralUsers" class="high_table" style="width: 90%;">

			<thead>
				<tr class="header">
					<th><input type="text" id="user_first_name1" placeholder="First Name"/></th>
					<th><input type="text" id="user_last_name1" placeholder="Last Name"/></th>
					<th><input type="text" id="user_username1" placeholder="Login"/></th>
					<th class="td_icon_addUser" valign="middle"><i class="fa fa-user-plus"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php

					$userc_id = $_SESSION["user_id"];

					$count = 1;
					if ($_SESSION["user_type"] == 1) {
						$sql = "SELECT user_id, user_first_name, user_last_name, user_login FROM user WHERE visibility = 1";
					}
					if ($_SESSION["user_type"] == 3) {
						$sql = "SELECT u.user_id, u.user_first_name, u.user_last_name, u.user_login FROM user AS u RIGHT JOIN user_team AS ut ON u.user_id = ut.user_id LEFT JOIN team AS t ON ut.team_id = t.team_id WHERE t.team_manager = {$userc_id} AND u.user_id <> {$userc_id} AND u.visibility = 1 AND ut.visibility = 1";
					}
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0){
						while ($row=mysqli_fetch_assoc($result)){
							if (( $count % 2 )== 0){
								echo "<tr class='odd' valign='middle'> <td valign='middle'>";
							} else {
								echo "<tr> <td valign='middle'>";
							}
							$count++;
							$user_id_temp = $row["user_id"];
							echo $row["user_first_name"];
							echo "</td> 
								<td valign='middle'>";
							echo $row["user_last_name"];
							echo "</td> 
								<td valign='middle' align='center'>";
							echo $row["user_login"];
							echo "</td>
								<td class='td_icon'>
								<center>
      							<input name='checked[]' type='checkbox' value='";
							echo $row["user_id"];
							echo "' align='right'";
							
							$sql3 = "SELECT * FROM user_task WHERE user_id = {$user_id_temp} AND task_id = {$task_id} AND visibility = 1";
							$result3 = mysqli_query($conn, $sql3);
							if (mysqli_num_rows($result3) > 0) {
								echo "checked";
							}
							
							echo ">
							</td>
							</tr>";
						}
					} ?>
			</tbody>
		</table>


		<table id="tabela_submit" class="high_table">

			<tr onclick="document.getElementById('changeTaskForm').submit()">
				<td colspan=4 class="edit"> SUBMIT </td>
			</tr>
		</form>
		</table>

		</article>
	</content>
</body>
</html>