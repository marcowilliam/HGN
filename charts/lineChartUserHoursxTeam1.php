<?php

/* trocar a a associacao da tabela user com a tabela task;
associar a tabela task com a quantidade de hora da subtask
associar datas iguais e somar horas
passar variaveis pro js
criar for para criacao de vetor no grafico
*/


$usersCount = 0;

$sql2 = "SELECT user_id FROM user_team WHERE team_id = '{$team_display_id}' AND visibility = 1";
$result2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($result2) > 0){
	while($row = mysqli_fetch_assoc($result2)){

		$userId[$usersCount] = $row["user_id"];
		$usersCount++;

	}
}


for($i = 0; $i <count($userId); $i++){

$sql3 = "SELECT user_first_name FROM user WHERE user_id = '{$userId[$i]}'";
$result3 = mysqli_query($conn, $sql3);
if(mysqli_num_rows($result3) > 0){
	while($row = mysqli_fetch_assoc($result3)){
		$userNames[$i] = $row["user_first_name"];
	}
}
}
 

$countUsers = 0;
$countSubTasks =0;
$hours_sub_tasks[] = 0;
$datesCount = 0;


for($x = 0; $x < count($userNames); $x++){
			$sql5 = "SELECT sub_task_date, sub_task_time FROM sub_task LEFT JOIN user_task ON sub_task.user_task_id = user_task.user_task_id WHERE user_task.user_id = '{$userId[$x]}'";
			
			$result5 = mysqli_query($conn, $sql5);
			if (mysqli_num_rows($result5) > 0) {
				while ($row = mysqli_fetch_assoc($result5)) {
					$user_sub_tasks_date[$countUsers][$countSubTasks] = $row["sub_task_date"];
					$countSubTasks++;
					$dates_hours[$countUsers][$datesCount] =  $row["sub_task_time"];
					$datesCount++;
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
					$finalHours[$x][$y] = $finalHours[$x][$y] + $dates_hours[$x][$z];
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