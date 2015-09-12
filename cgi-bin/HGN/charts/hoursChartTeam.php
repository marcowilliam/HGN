<?php
/*
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ocAppDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully <br>";

*/
// Execute query and get the variables from the database
$counter = 0;


$sqlBar0 = "SELECT user_id FROM User_team WHERE team_id = '{$teamId}'";
$resultBar0 = mysqli_query($conn, $sqlBar0);
if (mysqli_num_rows($resultBar0) > 0) {
    while ($row = mysqli_fetch_assoc($resultBar0)) {

        $user_id_temp = $row["user_id"];

        $sqlBar = "SELECT user_first_name, user_week_hrs FROM User WHERE user_id = '{$user_id_temp}'";
        $resultBar = mysqli_query($conn, $sqlBar);
        if (mysqli_num_rows($resultBar) > 0) {
            while ($row = mysqli_fetch_assoc($resultBar)) { //run while the lines are not empty
                $task_time_temp = 0;
                $user_name_temp[$counter] = $row["user_first_name"];
                $user_week_hrs_temp[$counter] = $row["user_week_hrs"];

                $sqlBar1 = "SELECT task_id FROM task WHERE user_id = '{$user_id_temp}'";
                $resultBar1 = mysqli_query($conn, $sqlBar1);
                if (mysqli_num_rows($resultBar1) > 0) {
                    while ($row = mysqli_fetch_assoc($resultBar1)) {
                        $task_id_temp = $row["task_id"];

                        $sqlBar2 = "SELECT sub_task_time FROM sub_task WHERE task_id = '{$task_id_temp}'";
                        $resultBar2 = mysqli_query($conn, $sqlBar2);
                        if (mysqli_num_rows($resultBar2) > 0) {
                            while ($row = mysqli_fetch_assoc($resultBar2)) {
                                $task_time_temp = $task_time_temp + $row["sub_task_time"];
                            }
                            $time_task[$counter] = $task_time_temp;
                            
                        }
                        else{
                            $time_task[$counter] = 0;
                        }
                        
                    }

                   // $time_task[$counter] = $task_time_temp;
                }
                $counter++;
            }
        }
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


function printColor($num_h, $num_len){


    if($num_h <= $num_len){
        echo hpbar($num_h, $num_len);
    } else {
        $num_h = $num_len+0.000001;
        echo hpbar($num_h, $num_len);

    }


}



?>
