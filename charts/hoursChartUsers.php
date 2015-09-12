<?php



// Execute query and get the variables from the database
$counter = 0;  
//$currentWeek = date("W", strtotime("D")-1) ;
//$currentYear = date("Y", strtotime("D"));

$currentWeek1 = date("W", strtotime("D")); 
$currentYear = date("Y", strtotime("D"));

$currentWeek = $currentWeek1 - 1 ;



$sql_team = $_SESSION['user_team_query'];
$user_id = $_SESSION['user_id'];

$today = date("y-m-d");
//WHERE u.visibility = 1 AND DATEPART(yyyy, '8-3-2015') = '{$currentYear}'
						
$sqlSelectTeam = "SELECT * FROM user_team WHERE visibility = 1 AND user_id = '{$user_id}'" ;
$resultSqlSelectTeam = mysqli_query($conn, $sqlSelectTeam);


if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2){
    $sql5 = "SELECT u.user_id, u.user_type_id, u.user_first_name, u.user_last_name, u.user_week_hrs, u.user_type_id, SUM(s.sub_task_time) FROM user AS u
    	LEFT JOIN user_task AS t ON u.user_id = t.user_id
    	LEFT JOIN sub_task AS s ON t.user_task_id = s.user_task_id
    	WHERE u.visibility = 1 AND week(s.sub_task_date) ='{$currentWeek}' AND year(s.sub_task_date) = '{$currentYear}'
    	
    GROUP BY u.user_id
    ORDER BY user_type_id ASC, SUM(s.sub_task_time) DESC";
    

    
} 
else{
	if (mysqli_num_rows($resultSqlSelectTeam) > 0){
	    $sql5 = "SELECT u.user_id, u.user_type_id, u.user_first_name, u.user_last_name, u.user_week_hrs, u.user_type_id, SUM(s.sub_task_time) FROM user AS u	    
	    	LEFT JOIN user_team AS te ON u.user_id = te.user_id	    	
	    	LEFT JOIN user_task AS t ON u.user_id = t.user_id	    	
	    	LEFT JOIN sub_task AS s ON t.user_task_id = s.user_task_id	    	
	    WHERE te.visibility=1 AND te.team_id IN ({$sql_team}) AND u.visibility = 1 AND week(s.sub_task_date) = '{$currentWeek}' AND year(s.sub_task_date) = '{$currentYear}'
	    GROUP BY u.user_id
	     ORDER BY u.user_type_id ASC, SUM(s.sub_task_time) DESC";
	     
	
	     
	     
	} 
	else {
	   $sql5 = "SELECT u.user_id, u.user_type_id, u.user_first_name, u.user_last_name, u.user_week_hrs, u.user_type_id, SUM(s.sub_task_time) FROM user AS u
	    	LEFT JOIN user_task AS t ON u.user_id = t.user_id
	    	LEFT JOIN sub_task AS s ON t.user_task_id = s.user_task_id
	    WHERE u.user_id = '{$user_id}' AND week(s.sub_task_date) = '{$currentWeek}' AND year(s.sub_task_date) = '{$currentYear}'

	    
	    GROUP BY u.user_id
	    ORDER BY u.user_type_id ASC, SUM(s.sub_task_time) DESC";
	   
	}
}



$result5 = mysqli_query($conn, $sql5);
if (mysqli_num_rows($result5) > 0) {

    while ($row = mysqli_fetch_assoc($result5)) { //run while the lines are not empty
        $task_time_temp = 0;
        $sum_tangible_hours_temp = 0;
        $user_id_temp[$counter] = $row["user_id"];
        $user_name_temp[$counter] = $row["user_first_name"] . " " . $row["user_last_name"][0];
        $user_week_hrs_temp[$counter] = $row["user_week_hrs"];
        $user_type_temp[$counter] = $row["user_type_id"];

        $sql6 = "SELECT task_id FROM user_task WHERE user_id = '{$user_id_temp[$counter]}'";
     
        $result6 = mysqli_query($conn, $sql6);
        if (mysqli_num_rows($result6) > 0) {
            while ($row = mysqli_fetch_assoc($result6)) {
                $task_id_temp = $row["task_id"];

                $sqlSub0 = "SELECT sub_task_time, sub_task_type_id FROM sub_task LEFT JOIN user_task ON sub_task.user_task_id = user_task.user_task_id WHERE user_task.task_id = '{$task_id_temp}' AND week(sub_task_date) = '{$currentWeek}' AND year(sub_task_date) = '{$currentYear}' AND user_task.user_id = '{$user_id_temp[$counter]}'";
                
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


function getPercentType2($current){
    
    if($current < 50){
        $percent2 = round((($current)/50)*100);
    }

    if($current >= 50){
        $percent2 = 100;
    }

    return $percent2;

}

function colorType2($current) {

        if(($current > 0) && ($current < 5)){//red
            return "rgb(255, 0, 0)";
        }

        if(($current >= 5) && ($current < 10)){//orange
            return "rgb(255, 153, 51)";
        }

        if(($current >= 10) && ($current < 20)){//green
            return "rgb(51, 204, 102)";
        }

        if(($current >= 20) && ($current < 40)){//blue
            return "rgb(51, 0, 153)";
        }

        if(($current >= 40) && ($current < 50)){//purple
            return "rgb(153, 0, 204)";
        }

        if($current >= 50){//magenta
            return "rgb(255, 0, 255)";
        }

} 


function getColorType2($current){
	
	$color2 = colorType2($current);
	return $color2;
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