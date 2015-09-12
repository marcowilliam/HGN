<?php


// Execute query and get the variables from the database
$counter = 0;
$currentWeek_temp = date("W", strtotime("D")); 
$currentWeek = $currentWeek_temp - 1;
$currentYear = date("Y", strtotime("D"));

$sql_team = $_SESSION['user_team_query'];
$user_id = $_SESSION['user_id'];


if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2){
    $sql5 = "SELECT DISTINCT(u.user_id), u.user_first_name, u.user_last_name, u.user_week_hrs, SUM(s.sub_task_time) AS sum FROM user as u LEFT JOIN task AS t ON u.user_id = t.user_id LEFT JOIN sub_task AS s ON t.task_id = s.task_id GROUP BY u.user_id ORDER BY sum DESC";
} else {
    $user_team_query = $_SESSION["user_team_query"];
    $sql5 = "SELECT DISTINCT(u.user_id), u.user_first_name, u.user_last_name, u.user_week_hrs, t.team_id FROM user as u INNER JOIN user_team as t ON u.user_id = t.user_id WHERE t.team_id IN ( {$user_team_query} ) ORDER BY user_last_name";
    if (mysqli_num_rows(mysqli_query($conn, $sql5)) == 0) {
        $sql5 = "SELECT DISTINCT(u.user_id), u.user_first_name, u.user_last_name, u.user_week_hrs FROM user as u WHERE u.user_id = {$user_id}";
    } 
}


$result5 = mysqli_query($conn, $sql5);
if (mysqli_num_rows($result5) > 0) {
    while ($row = mysqli_fetch_assoc($result5)) { //run while the lines are not empty
        $task_time_temp = 0;
        $sum_tangible_hours_temp = 0;
        $user_id_temp[$counter] = $row["user_id"];
        $user_name_temp[$counter] = $row["user_first_name"][0] . " " . $row["user_last_name"];
        $user_week_hrs_temp[$counter] = $row["user_week_hrs"];

        $sql6 = "SELECT task_id FROM task WHERE user_id = '{$user_id_temp[$counter]}'";
        $result6 = mysqli_query($conn, $sql6);
        if (mysqli_num_rows($result6) > 0) {
            while ($row = mysqli_fetch_assoc($result6)) {
                $task_id_temp = $row["task_id"];

                $sqlSub0 = "SELECT sub_task_time, sub_task_type_id FROM sub_task WHERE task_id = '{$task_id_temp}' AND week(sub_task_date) = '{$currentWeek}' AND year(sub_task_date) = '{$currentYear}'";
                $resultSub0 = mysqli_query($conn, $sqlSub0);
                if (mysqli_num_rows($resultSub0) > 0) {
                    while ($row = mysqli_fetch_assoc($resultSub0)) {
                        $task_time_temp = $task_time_temp + $row["sub_task_time"];
                      $sub_task_type_id_temp = $row["sub_task_type_id"];

                            $sqlSub = "SELECT sub_task_type_description FROM sub_task_type WHERE sub_task_type_id = '{$sub_task_type_id_temp}'";
                            $resultSub = mysqli_query($conn, $sqlSub);
                                if (mysqli_num_rows($resultSub) > 0) {
                                    while ($row2 = mysqli_fetch_assoc($resultSub)) {
                                        if(strcasecmp($row2["sub_task_type_description"], "tangible") == 0){
                                            $sum_tangible_hours_temp = $sum_tangible_hours_temp + $row["sub_task_time"];
                                        }

                                    }
                                }

                    }
                    
                    }
                else{
                    $sum_tangible_hours_temp = $sum_tangible_hours_temp + 0;
                    $task_time_temp = $task_time_temp + 0;
                }
                $time_task[$counter] = $task_time_temp;
                $sum_tangible_hours[$counter] = $sum_tangible_hours_temp;

            }

           // $time_task[$counter] = $task_time_temp;
        }
        $counter++;
    }
}



function getPercent($current, $max){
    $percent = round(($current/$max)*100);
    return $percent;
}

function getColor($current, $max){
    $color = color($current,$max);
    return $color;
}


// set the colors based on % of the bar
function color($current, $max) {
    $percent = getPercent($current,$max);

    $green = round(($percent*255)/100);
    $red = 255-$green;
    if (($percent > 0) && ($current <= $max)) {
	//$rgb = "rgb(255, 0, 00)";
   
    return "rgb(" . $red . ", " . $green . ", 00)";
    } else {
        if(($percent > 0) && ($current > $max)){
            return "rgb(105, 73, 166)";
        }
    }

} 



