<?php


	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['username']))      // if there is no valid session
	{
	    header("Location: ../index.php"); 
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

include_once '../charts/hoursChartUsers.php';

$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail, user_type_id FROM user WHERE user_login = '{$username}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];
    $user_first_name = $row["user_first_name"];
    $user_last_name = $row["user_last_name"];

}
						
$count = 0;
$sqlUserSubTasks = "SELECT sub_task_id, sub_task.sub_task_name, sub_task_type_id FROM sub_task LEFT JOIN user_task ON sub_task.user_task_id = user_task.user_task_id WHERE user_task.user_id = '{$user_id}'";
$resultUserSubTasks = mysqli_query($conn, $sqlUserSubTasks);
if(mysqli_num_rows($resultUserSubTasks)>0){
	while($rowUserSubTasks = mysqli_fetch_assoc($resultUserSubTasks)){
	
		$subTaskNames[$count] = $rowUserSubTasks["sub_task_name"];
		$subTaskIds[$count] = $rowUserSubTasks["sub_task_id"];
		$subTaskTypeId[$count] = $rowUserSubTasks["sub_task_type_id"];
		$count++;
	}
}



if (isset($_POST['u'])) {
	$user_task_id = $_POST['u'];
	$sqlName = "SELECT user_first_name, user_last_name FROM user WHERE user_id = {$user_task_id}";
	$resultName = mysqli_query($conn, $sqlName);
	$row = mysqli_fetch_assoc($resultName);
	$user_task_first_name = $row["user_first_name"];
	$user_task_last_name = $row["user_last_name"];
} else {
	$user_task_id = $_SESSION["user_id"];
	$user_task_first_name = $user_first_name;
	$user_task_last_name = $user_last_name;
}

function calculaHoras($user_id, $task_id, $yearweek, $conn) {
	$sql = "SELECT SUM(sub_task_time) AS total_horas
			FROM task LEFT JOIN user_task ON user_task.task_id = task.task_id LEFT JOIN sub_task ON user_task.user_task_id = sub_task.user_task_id 
			WHERE task.task_id = '{$task_id}' AND user_task.user_id = '{$user_id}' AND YEARWEEK(sub_task.sub_task_date) = '{$yearweek}'
			GROUP BY task.task_id 
			ORDER BY sub_task_date DESC";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		return $row["total_horas"];
	}
}

function getName($id, $table, $conn) {
	$sql = "SELECT {$table}_description AS name FROM {$table} WHERE {$table}_id = {$id}";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$sql = "SELECT {$table}_name AS name FROM {$table} WHERE {$table}_id = {$id}";
		$result = mysqli_query($conn, $sql);
	}
	if (!$result) {
		$sql = "SELECT {$table}_title AS name FROM {$table} WHERE {$table}_id = '{$id}";
		$result = mysqli_query($conn, $sql);
	}
	if (mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		return $row["name"];
	}
}




?>


<html>
<head>
	<title> Highest Good Network </title>
	<link href="../styles/tasks.css" rel="stylesheet">
	<link href="../styles/basicStyle.css" rel="stylesheet">
	<link href="../chosen/chosen.css" rel="stylesheet">
	<link href="../chosen/chosen.min.css" rel="stylesheet">
	<link href="../chosen/docsupport/prism.css" rel="stylesheet">
	<link href="../styles/sugestions.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	<script type= "text/javascript" src="../scripts/tasks.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	
	<script type="text/javascript" src="../chosen/chosen.jquery.js"></script>
	<script type="text/javascript" src="../chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="../chosen/chosen.proto.js"></script>
	<script type="text/javascript" src="../chosen/chosen.proto.min.js"></script>
	
  	<script type="text/javascript" src="../scripts/jquery.autocomplete.min.js"></script>
  	<script type="text/javascript" src="../scripts/script.js"></script>
	
	<link rel="icon" type="image/png" href="../img/favicon.png"/> 

	
</head>
<body>


	<nav>
		<ul>
			<li> <a href="../profile.php"> PROFILE </a> </li>
			<li> <a href="../tasks" class="active"> TASKS </a> </li>
			<li> <a href="../reports.php" > REPORTS </a> </li>
			<li> <a href="../general"> SETUP </a> </li>
			<?php if ($_SESSION['user_type']==1 || $_SESSION['user_type']==2) { ?>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<?php } ?>
			<li class="right img"> <a href="../sessionStop.php"> <img src="../img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $user_first_name . " " . $user_last_name ?> </li>
		</ul>
	</nav>


	<article class="artLeft">
	
		<form id="formProfile" action="../profile.php" method="post" style="margin: 0;">
			<input type="hidden" name="user_id" value=<?php echo $user_task_id; ?>>
		</form>
	
		
		<div class="divUserTask">
			
			<?php 
			$url = "../imageUpload/uploads/" . $user_task_id . ".jpg";
			if(file_exists($url)){
       				echo "<img class='userImg' src='" . $url . "' onclick='document.getElementById(\"formProfile\").submit()' style='cursor: hand'>";
    			} else {
    				echo "<img class='userImgBg' src='../img/pictureIcon.png' onclick='document.getElementById(\"formProfile\").submit()' style='cursor: hand;'>";
    			}
    			?>

			<h2 style="float:left; padding-left: 1%; cursor: hand;" onclick="document.getElementById('formProfile').submit()"> <?php echo $user_task_first_name . " " . $user_task_last_name; ?> </h2>
			<?php if ($user_task_id == $user_id){ ?>
			<i class="fa fa-plus-circle fa-4x" style="float: right; cursor:hand;" id="showAddSubTask" onclick="showAdd()"></i> 
			<?php } ?>
		</div>
		
		
		<div class="divAddSubtask" style="clear: both;" id="divAddSubTask">

			<form action="addNewSubTask.php" method="post" id="addSubTask">
				<table class = "tableAddSubtask" style="float: left;">
					<tr>
						<td> Task Name </td>
						<td> 
							<div class="styled-select1">
								<select data-placeholder="Choose a task..." class="taskNameSelect" id="taskNameSelect" name="task_new">
									<option value""></option>
							
			
									<?php 

									$sql3 = "SELECT task.task_id, task.task_name, user_task.user_task_id FROM task  LEFT JOIN user_task ON task.task_id = user_task.task_id WHERE user_task.user_id = {$user_id} AND task_name <> 'Welcome' AND user_task.visibility = 1 AND task.visibility = 1";
									$result3 = mysqli_query($conn, $sql3);
									if ($result3 || mysqli_num_rows($result3) ) {
										while ($row3 = mysqli_fetch_assoc($result3)){
											$task_id = $row3["task_id"];
											$user_task_id_new_sub_task = $row3["user_task_id"];
											$task_name = $row3["task_name"];

											echo "<option value='";
											echo $user_task_id_new_sub_task;
											echo "' ";
											echo "> ";
											echo $task_name;
											echo "</option>";
										}
									}


									?>


								</select>
							</div>

						</td>
						<td></td>
					</tr>

					<tr>
						<td> SubTask Type </td>
						<td> 
							<div class="styled-select">
								<select name="subtasktype"> 

									<?php 

									$sql3 = "SELECT sub_task_type_id, sub_task_type_description FROM sub_task_type";
									$result3 = mysqli_query($conn, $sql3);
									if ($result3 || mysqli_num_rows($result3) ) {
										while ($row3 = mysqli_fetch_assoc($result3)){
											$sub_task_type_id = $row3["sub_task_type_id"];
											$sub_task_type_name = $row3["sub_task_type_description"];

											echo "<option value='";
											echo $sub_task_type_id;
											echo "' ";
											if ($sub_task_type_id == 2){
												echo "selected";
											}
											echo "> ";
											echo $sub_task_type_name;
											echo "</option>";
										}
									}


									?>


								</select>
							</div>

						</td>
						<td></td>
					</tr>

					<tr>
					
					<input type="hidden" id="inputNewSubClassName"></input>
						<td> SubTask Name </td>
						
						
						<td> 
							<div id="searchfield">
								<input type="text" name="currency" class="biginput" id="autocomplete">	
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td> Subtask Description </td>
						<td> <textarea class="wrapper" rows=4 name="subtaskdescription" id="subtaskdescription"> </textarea></td>
						
					
						<td></td>
					</tr>

					<tr>
						<td> SubTask Time </td>
						<td> <input type="text" class="wrapper" name="subtasktime"> </td>
						<td></td>
					</tr>
					

				</table>
			
			</form>
			
			<i class="fa fa-arrow-circle-right fa-4x" style="float: right; cursor: hand;" onclick="document.getElementById('addSubTask').submit()"></i>

		</div>

		<div class = "divContentTasksList">
			
			<table id="tabelaTasks" class="high_table">
				<tbody>
						<?php
	
							$sub_task_count = 0;
							$sqlWeek = "SELECT DISTINCT(YEARWEEK(sub_task_date)) AS yearweek, YEAR(sub_task_date) AS year, WEEK(sub_task_date) AS week FROM sub_task AS s LEFT JOIN user_task AS t ON s.user_task_id = t.user_task_id WHERE t.user_id = '{$user_task_id}' ORDER BY week DESC";
							$resultWeek = mysqli_query($conn, $sqlWeek);
							if (mysqli_num_rows($resultWeek) > 0) {
								while ($rowWeek = mysqli_fetch_assoc($resultWeek)) {
									$yearweek = $rowWeek["yearweek"];
									$year = $rowWeek["year"];
									$week = $rowWeek["week"] + 1;

									$date = date("m/d/Y", strtotime($year . "W" . $week));
									$date = date("M d", strtotime($date . "-1 day"));
									echo "<tr> <td colspan=3 class = 'divTopTasksList'>
												" . $date . " - " .  date("M d", strtotime($date . " +6 days")) . "
											</td> </tr>";
									$sql = "SELECT task.task_id, task.task_name, task.category_id, task.task_description
											FROM task RIGHT JOIN user_task ON task.task_id = user_task.task_id RIGHT JOIN sub_task ON user_task.user_task_id = sub_task.user_task_id 
											WHERE user_task.user_id = '{$user_task_id}' AND YEARWEEK(sub_task_date) = '{$yearweek}'
											GROUP BY task.task_id 
											ORDER BY sub_task_date DESC";
									$result = mysqli_query($conn, $sql);
									$count = 1;
									if (mysqli_num_rows($result) > 0) {
										while ($row = mysqli_fetch_assoc($result)) {
											$task_id = $row["task_id"];
											if (( $count % 2 )== 0){
												echo "<tr class='odd' valign='middle' onclick='showSubTask(" . $task_id . $week . ")' style='cursor: hand;' valign='center'>";
											} else {
												echo "<tr onclick='showSubTask(" . $task_id . $week . ")' style='cursor: hand;' valign='center'>";
											}
											echo "<td class='iconHand'><i class='fa fa-hand-o-right' style='color=#000000'></i></td>";
											echo "<td class='task'>";
											echo $row["task_name"];
											echo "</td><td class='hours'>";
											echo calculaHoras($user_task_id, $task_id, $yearweek, $conn);
											echo " hrs.</td> </tr>";
											if (($count % 2) == 0){
												echo "<tr class='odd'>";
											} else {
												echo "<tr>";
											}
											echo "<td></td> <td class='category'> " . getName($row["category_id"], "category", $conn) . "</td> <td></td> </tr>";
												
											if (($count % 2) == 0) {
												echo "<tr class='odd'>";
											} else {
												echo "<tr>";
											}
											echo "<td></td> <td class='Description'> " . $row["task_description"] . "</td> <td colspan=2></td> </tr>";

											$sql2 = "SELECT sub_task_id, sub_task_name, sub_task_time, sub_task_description, sub_task_type_id FROM sub_task LEFT JOIN user_task ON sub_task.user_task_id = user_task.user_task_id WHERE user_task.task_id = '{$task_id}' AND YEARWEEK(sub_task_date) = '{$yearweek}' AND user_task.user_id = '{$user_task_id}' ORDER BY sub_task_date";
											$result2 = mysqli_query($conn, $sql2);
											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)){
													$sub_task_id = $row2["sub_task_id"];
													if ($row2["sub_task_type_id"] == 1) {
														$sub_task_type = "Tangible";
													} else {
														$sub_task_type = "Intangible";
													}
													if (( $count % 2 )== 0){
														echo "<tr class='odd hidden' valign='middle' name='" . $task_id . $week ."'>";
													} else {
														echo "<tr class='hidden' name='" . $task_id . $week ."'>";
													}
													$subTaskTimeEdit = $row2["sub_task_time"];
													echo "<td></td> <td class='sub_task_title'>" . $row2["sub_task_name"] . "</td>";
													
													echo "<td>" . "<form id='sub_task_form_edit_".$sub_task_count."' method='post' action='updateSubTaskTime.php'> <input class='input_sub_task_edit' id='sub_task_input_edit_" . $sub_task_count . "' type='text' name='sub_task_time_edit' value='$subTaskTimeEdit "."hrs"."' onclick='submitForm(this, $sub_task_count, $subTaskTimeEdit)' style='cursor:hand;'";
													if($row2["sub_task_name"] == "" || ($user_task_id<>$user_id && $_SESSION["user_type"] <> 1)){
														echo "disabled";
													}
													echo "> <input type='hidden' name='sub_task_id_edit' value='$sub_task_id'> </form>"."</td> </tr>";
													if (( $count % 2 )== 0){
														echo "<tr class='odd hidden' valign='middle' name='" . $task_id . $week ."'>";
													} else {
														echo "<tr class='hidden' name='" . $task_id . $week ."'>";
													}
													
													echo "<td> </td><td class='sub_task_description'>" . $sub_task_type . "</td></td></tr>";
													
													if (( $count % 2 )== 0){
														echo "<tr class='odd hidden' valign='middle' name='" . $task_id . $week . "'>";;
													} else {
														echo "<tr class='hidden' name='" . $task_id . $week . "'>";
													}
													$subTaskDescriptionEdit = $row2['sub_task_description'];
													echo "<td></td> <td class='sub_task_description'><form id='sub_task_description_edit_".$sub_task_count."' method='post' action='updateSubTaskDescription.php'><div";
													if(!($row2["sub_task_name"] == "" || ($user_task_id<>$user_id && $_SESSION["user_type"] <> 1))){
				echo " contenteditable = 'true'";
				
													}
													echo " class='div_sub_task_description_edit' id='sub_task_description_div_edit_" . $sub_task_count . "' type='text' name='sub_task_description_edit' onclick='submitFormDescription($sub_task_count)' style='cursor:hand;'>".$subTaskDescriptionEdit."</div><input type='hidden' name='sub_task_description_edit' id='sub_task_description_input_edit_" . $sub_task_count ."'";																																								 		
													echo "> <input type='hidden' name='sub_task_id_edit' value='$sub_task_id'> </form>"."</td>";
												
													echo "<td></td>";
													echo "</tr>";
													$sub_task_count++;
												} 
											}
											$count++;
										}	
									}
								}
							}

							?>

				</tbody>
			</table>

		</div>

	</article>

	<article class="artRight">
		
		<div class="hoursBars" id="hoursBars">
		<h1> <i class="fa fa-bars smallIcon"></i> User Hours </h1>
		
		<div style="margin-left:20%;">
			<?php
				if($_SESSION['user_type']==1 || $_SESSION['user_type']==2){
					echo "<p style='float: left; cursor:hand; font-weight:bold;' id='viewGeneral' onclick='controlBarChartDisplay2()'>General View</p>";
					echo "<p style='float: left; margin-left:5%; padding-right:5%;'> | </p>";
					echo "<p style='float: left; cursor:hand;' id='viewAdmin' onclick='controlBarChartDisplay1()'>Admin View</p>";
				}
			?>
		</div>
		
		<div>
			<form id="showTasks" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
					<input type="hidden" name="u" id="u">
			</form>
		
		   <table class="hoursBarsChart hours" id="barChart2">
		   
			<?php  
			


			
			if (mysqli_num_rows($result5) > 0){
				for($i=0; $i<count($user_name_temp); $i++){	
				
					$percentGraphType2 = getPercentType2($sum_tangible_hours[$i]);
					$colorType2 = getColorType2($sum_tangible_hours[$i]);
					$user_id_encode = $user_id_temp[$i];
					
					if($sum_tangible_hours[$i] >= $user_week_hrs_temp[$i]){
						$ballColor = "#008000";
					} else {
						$ballColor = "#FF0000";
					}
					

					

					
					echo "<tr onclick='showTasksID({$user_id_encode})' style='cursor: hand;'>";

					if($user_type_temp[$i] == 1 || $user_type_temp[$i] == 2){
						echo "<td>P</td>";
					}
					
					if($user_type_temp[$i] == 3){
						echo "<td>M</td>";
					}
					
					if($user_type_temp[$i] == 4){
						echo "<td> </td>";
					}
			
					
					echo "<td><div style='border-radius: 50%; background:" . $ballColor . "; height: 8px; width:8px;'></div></td>";
					echo "<td>" . $user_name_temp[$i] . "</td>";
	                		echo "<td style='text-align: right;'>" . $sum_tangible_hours[$i] . " tan" . "</td>";
	                		echo "<td style='width: 40%;'>" . "<div style='border-radius: 10px; border: 1px solid; background: #FFF; height: 8px;'><div style='width: " . $percentGraphType2 . "%; background-color: " . $colorType2 . "; border-radius: 10px; height: 8px;'></div></div>" . "</td>";
	                		echo "<td>" . $time_task[$i] . " tot" . "</td></tr>";
					
					

	                	}
			
	                }
	                	                						
			?>
			
		   </table>
			
		</div>

				<form id="showTasks" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
					<input type="hidden" name="u" id="u">
				</form>

			<table class="hoursBarsChart hours" id="barChart1" style="display:none;">
		            <?php 
		            



			            	
		            if (mysqli_num_rows($result5) > 0){
			            for($i=0; $i<count($user_name_temp); $i++){
			                $percent = getPercent($sum_tangible_hours[$i], $user_week_hrs_temp[$i]);
			                $color = getColor($sum_tangible_hours[$i], $user_week_hrs_temp[$i]);
	                    		$user_id_encode = $user_id_temp[$i];
					if($sum_tangible_hours[$i] > $user_week_hrs_temp[$i]){
	                    			$percent = getPercent($user_week_hrs_temp[$i]+0.01, $user_week_hrs_temp[$i]);
	                			echo "<tr onclick='showTasksID({$user_id_encode})' style='cursor: hand;'><td>" . $user_name_temp[$i] . "</td>";
	                			echo "<td style='text-align: right;'>" . $sum_tangible_hours[$i] . " tan" . "</td>";
	                			echo "<td style='width: 40%;'>" . "<div style='border-radius: 10px; border: 1px solid; background: #FFF; height: 8px;'><div style='width: " . $percent . "%; background-color: " . $color . "; border-radius: 10px; height: 8px;'></div></div>" . "</td>";
	                			echo "<td>" . $time_task[$i] . " tot" . "</td></tr>"; 
	                		} else{

	                			echo "<tr onclick='showTasksID({$user_id_encode})' style='cursor: hand;'><td>" . $user_name_temp[$i] . "</td>";
	                			echo "<td style='text-align: right;'>" . $sum_tangible_hours[$i] . " tan" . "</td>";
	                			echo "<td style='width: 40%;'>" . "<div style='border-radius: 10px; border: 1px solid; background: #FFF; height: 8px;'><div style='width: " . $percent . "%; background-color: " . $color . "; border-radius: 10px; height: 8px;'></div></div>" . "</td>";
	                			echo "<td>" . $time_task[$i] . " tot" . "</td></tr>";
			            	}
			            }
		        	} 
		            ?>
		    </table>


		</div>


		</article>
		
		<div id="connectionPhpJs" style="display:none;">
			<?php echo json_encode($subTaskNames);?>
		</div>

		<script type="text/javascript">

			var id;
			function showTasksID(id) {
				document.getElementById('u').value = id;
				document.getElementById('showTasks').submit();
			}
			function alerta() {
				alert('foi?');
			}

		</script>

</body>
</html>