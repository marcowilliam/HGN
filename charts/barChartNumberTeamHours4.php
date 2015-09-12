<?php
/**
 * Charts 4 PHP
 *
 * @author Shani <support@chartphp.com> - http://www.chartphp.com
 * @version 1.2.1
 * @license: see license.txt included in package
 */

include("chartphp_dist.php");
// Execute query and get the variables from the database
$teamName = "team2";

$tasks_count = 0;
$sub_task_count_hours_total = 0;
$total_teams = 0;
$team_id_temp;
$user_id_temp;
$task_id_temp;


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
						$sql7 = "SELECT sub_task_hour FROM sub_task WHERE task_id = '{$task_id_temp}'";
						$result7 = mysqli_query($conn, $sql6);
						if (mysqli_num_rows($result7) > 0) {
						while ($row = mysqli_fetch_assoc($result6)) {
							$sub_task_count_hours_total+=$row["sub_task_hour"];
					}
					
					}
				}
			}
		}
	}		
}
$name_team[0] = $teamName;
$team_ntasks[0] = $sub_task_count_hours_total;
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

$outBarChartNumberTeamTasks2 = $p2->render('c2');

?>
