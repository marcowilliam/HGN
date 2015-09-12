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
$counter = 0;


$sql5 = "SELECT category_id, category_description FROM Category";
$result5 = mysqli_query($conn, $sql5);
if (mysqli_num_rows($result5) > 0) {
	while ($row = mysqli_fetch_assoc($result5)) { //run while the lines are not empty
		$task_time_temp = 0;
		$category_id_temp = $row["category_id"];
		$category_name_task[$counter] = $row["category_description"];

		$sql6 = "SELECT task_id FROM Task WHERE category_id = '{$category_id_temp}'";
		$result6 = mysqli_query($conn, $sql6);
		if (mysqli_num_rows($result6) > 0) {
			while ($row = mysqli_fetch_assoc($result6)) {
				$task_id_temp = $row["task_id"];

				$sql7 = "SELECT sub_task_time FROM Sub_task WHERE task_id = '{$task_id_temp}'";
				$result7 = mysqli_query($conn, $sql7);
				if (mysqli_num_rows($result7) > 0) {
					while ($row = mysqli_fetch_assoc($result7)) {
						$task_time_temp = $task_time_temp + $row["sub_task_time"];
					}
					$time_task[$counter] = $task_time_temp;
					
				}
				else{
					$time_task[$counter] = 0;
				}
				$counter++;
			}
			
			//$time_task[$counter] = $task_time_temp;
		}
	}
}


$p1 = new chartphp();

$arrlength = count($category_name_task);
// creating the arrays
for($x = 0; $x < $arrlength; $x++){

$arrays[$x] = array($category_name_task[$x], (int)$time_task[$x]);

}

$p1->data = array($arrays); // Set the arrays as the data to print the graph

$p1->chart_type = "bar";


// Common Options
$p1->title = "Categories x Hours";
$p1->xlabel = "";
$p1->ylabel = "Hours";

$out = $p1->render('c1');

?>