<?php

/* trocar a a associacao da tabela user com a tabela task;
associar a tabela task com a quantidade de hora da subtask
associar datas iguais e somar horas
passar variaveis pro js
criar for para criacao de vetor no grafico
*/
// Create connection




if(!isset($_POST['currency'])){

	$team = $_SESSION['team_name'];
}
else{

	$team = $_POST['currency'];

}

$sql1 = "SELECT team_id FROM team WHERE team_description = '{$team}'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
	while ($row = mysqli_fetch_assoc($result1)) { //run while the lines are not empty
		$teamId = $row["team_id"];
	}
}


$usersCount = 0;

$sql2 = "SELECT user_id FROM user_team WHERE team_id = '{$teamId}'";
$result2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($result2) > 0){
	while($row = mysqli_fetch_assoc($result2)){

		$userId[$usersCount] = $row["user_id"];
		$usersCount++;

	}
}

$usersNameCount = 0;
$listUsersId = implode(',', $userId);

$sql3 = "SELECT user_first_name FROM user WHERE user_id IN ($listUsersId)";
$result3 = mysqli_query($conn, $sql3);
if(mysqli_num_rows($result3) > 0){
	while($row = mysqli_fetch_assoc($result3)){
		$userNames[$usersNameCount] = $row["user_first_name"];
		$usersNameCount++;
	}
}
 
//fazedno uma matriz para pegar todas as tarefas de cada usuario

//variavel que controla os usuarios
$countUsers = 0;

//variavel que controla as tarefas
$countTasks = 0;

//query
for($x = 0; $x<count($userId); $x++){

	$sql4 = "SELECT task_id FROM task WHERE user_id = '{$userId[$x]}'";
	$result4 = mysqli_query($conn, $sql4);
	if(mysqli_num_rows($result4) > 0){
		while($row = mysqli_fetch_assoc($result4)){									//associamos user_task ao user para pegar a task
			$userTasks[$countUsers][$countTasks] = $row["task_id"];
			$countTasks++;
		}
	}
	$countUsers++;
	$countTasks = 0;

}

$countUsers = 0;
$countSubTasks =0;
$hours_sub_tasks[] = 0;
$datesCount = 0;

for($x = 0; $x < count($userTasks); $x++){
	for($y = 0; $y < count($userTasks[$x]); $y++){
			$sql5 = "SELECT sub_task_date, sub_task_time FROM sub_task WHERE task_id = '{$userTasks[$x][$y]}'";
			$result5 = mysqli_query($conn, $sql5);
			if (mysqli_num_rows($result5) > 0) {
				while ($row = mysqli_fetch_assoc($result5)) {
					$user_sub_tasks_date[$countUsers][$countSubTasks] = $row["sub_task_date"];
					$countSubTasks++;
					$dates_hours[$countUsers][$datesCount] =  $row["sub_task_time"];
					$datesCount++;
				}
			}	
	}
		$datesCount = 0;
		$countSubTasks = 0;
		$countUsers++;
}

//echo $user_sub_tasks_date[1][3];
//echo $dates_hours[1][3];
/*$datesCount = 0;

for($x = 0; $x < count($user_sub_tasks_date); $x++){
	
	for($y = 0; $y < count($user_sub_tasks_date[$x]); $y++){
		
				$sql6 = "SELECT sub_task_time FROM Sub_task WHERE task_id = '{$userTasks[$x][$y]}'";
				$result6 = mysqli_query($conn, $sql6);
				if (mysqli_num_rows($result6) > 0) {
					echo count($user_sub_tasks_date[$x]);
					while ($row = mysqli_fetch_assoc($result6)) {
						
					}
				}
				break;
	}
	
	$datesCount = 0;
}	
*/

//echo $dates_hours[0][1];

/*for($x = 0; $x < count($user_sub_tasks_date); $x++){
	
		for($y = 0; $y < count($user_sub_tasks_date[$x]); $y++){
			$finalDates[$x][$y] = NULL;
		}
	}
	*/

for($x = 0; $x<count($user_sub_tasks_date); $x++){
	$y=0;
	$finalDates[$x][0] = $user_sub_tasks_date[$x][0];
	$finalHours[$x][0] = 0;
	//echo $finalDates[$x][0];
	//echo "<br>";
	//echo $user_sub_tasks_date[$x][0];

		for($z = 0; $z<count($user_sub_tasks_date[$x]); $z++){

				if($finalDates[$x][$y]==$user_sub_tasks_date[$x][$z]){
					$finalHours[$x][$y] =  $finalHours[$x][$y] + $dates_hours[$x][$z];
				}
				else{
					$y++;
					$finalDates[$x][$y]=$user_sub_tasks_date[$x][$z];
					$finalHours[$x][$y]=$dates_hours[$x][$z];
					
				}
		}

}


/*for($x = 0; $x < count($user_sub_tasks_date); $x++){

	$finalDates[$x][0] = $user_sub_tasks_date[$x][0];
	$finalHours[$x][0] = $dates_hours[$x][0];

	for($z = 0; $z < count($finalDates[$x]) ; $z++){

		for($y = 0; $y < count($user_sub_tasks_date[$x]); $y++){

				if($finalDates[$x][$z] <> $user_sub_tasks_date[$x][$y]){
				 	$finalDates[$x][$z] = $user_sub_tasks_date[$x][$y];
				 	$finalHours[$x][$z] = $dates_hours[$x][$y];
				 }
				 else{

				 	$finalHours[$x][$z] += $dates_hours[$x][$y];

				 }
		}

	}
}
*/



for($x = 0; $x < count($finalDates); $x++){

	$quantityDatesUser[$x] = count($finalDates[$x]);

}

$currentMonth = date("m");



?>