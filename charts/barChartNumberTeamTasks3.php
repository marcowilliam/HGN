<?php
/**
 * Charts 4 PHP
 *
 * @author Shani <support@chartphp.com> - http://www.chartphp.com
 * @version 1.2.1
 * @license: see license.txt included in package
 */

include("chartphp_dist.php");

if(!isset($_POST['currency'])){

	$teamName = $_SESSION['team_name'];
}
else{

	$teamName = $_POST['currency'];

}

$tasks_count = 0;
$task_count_total = 0;
$total_teams = 0;
$team_id_temp;
$user_id_temp;

$sql1 = "SELECT team_id FROM Team WHERE team_description = '{$teamName}'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
	while ($row = mysqli_fetch_assoc($result1)) {
		$team_id_temp = $row["team_id"];

		$sql2 = "SELECT user_id FROM user_team WHERE team_id = '{$team_id_temp}'";
		$result2 = mysqli_query($conn, $sql2);
		if (mysqli_num_rows($result2) > 0) {
			while ($row = mysqli_fetch_assoc($result2)) {
				$user_id_temp = $row["user_id"];
				$sql3 = "SELECT task_id, task_status_id FROM Task WHERE user_id = '{$user_id_temp}'";
				$result3 = mysqli_query($conn, $sql3);
				if (mysqli_num_rows($result3) > 0) {
					while ($row = mysqli_fetch_assoc($result3)) {
						$tasks_count++;
						
					}
				}
			}
		}
	}		
}

$sql4 = "SELECT team_id FROM Team";
$result4 = mysqli_query($conn, $sql4);
if (mysqli_num_rows($result4) > 0) {
	while ($row = mysqli_fetch_assoc($result4)) {
		$team_id_temp = $row["team_id"];
		$total_teams++;
		$sql5 = "SELECT user_id FROM user_team WHERE team_id = '{$team_id_temp}'";
		$result5 = mysqli_query($conn, $sql5);
		if (mysqli_num_rows($result5) > 0) {
			while ($row = mysqli_fetch_assoc($result5)) {
				$user_id_temp = $row["user_id"];
				$sql6 = "SELECT task_id, task_status_id FROM Task WHERE user_id = '{$user_id_temp}'";
				$result6 = mysqli_query($conn, $sql6);
				if (mysqli_num_rows($result6) > 0) {
					while ($row = mysqli_fetch_assoc($result6)) {
						$task_count_total++;
						
					}
				}
			}
		}
	}		
}


$name_team[0] = $teamName;
$team_ntasks[0] = $tasks_count;
$name_team[1] = "Mean";
$team_ntasks[1] = $task_count_total/$total_teams;



$p2 = new chartphp();

$arrlength3 = count($name_team);
// creating the arrays
for($x = 0; $x < $arrlength3; $x++){

$arrays[$x] = array($name_team[$x], (float)$team_ntasks[$x]);

}

$p2->data = array($arrays); // Set the arrays as the data to print the graph


$p2->chart_type = "bar";

// Common Options
$p2->title = "Team x Number of Tasks";
$p2->xlabel = "";
$p2->ylabel = "Tasks";

$outBarChartNumberTeamTasks = $p2->render('c2');

?>
