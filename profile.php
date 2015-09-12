<?php

	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['username']))      // if there is no valid session
	{
	    header("Location: ../index.php"); // SAIR
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

$user_id = "";
$user_first_name = "";
$user_type_id = "";
$user_tel = "";
$user_mail = "";

	
	$user_display_id = $_POST["user_id"];
	
    
	
	if ($user_display_id == "") {
		$user_display_id = $_SESSION["user_id"];
	}




$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail, user_dob, user_login FROM user WHERE user_id = '{$user_display_id}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];
    $user_first_name = $row["user_first_name"];
    $user_last_name = $row["user_last_name"];
    $user_type_id = $row["user_type_id"];
    $user_tel = $row["user_tel"];
    $user_mail = $row["user_mail"];
    $user_dob = $row["user_dob"];
    $user_day = substr($user_dob, 0, 2);
    $user_month = substr($user_dob, 3, 4);
    $username = $row["user_login"];
    

    
    if ($user_day == date("d") && $user_month == date("m")) {
    	$birthday = true;
    } else {
    	$birthday = false;
    }
    
    switch ($user_month){
    	case "01":
    		$user_month = "Jan";
    		break;
    	case "02":
    		$user_month = "Fev";
    		break;
    	case "03":
    		$user_month = "Mar";
    		break;
    	case "04":
    		$user_month = "Apr";
    		break;
    	case "05":
    		$user_month = "May";
    		break;
    	case "06":
    		$user_month = "Jun";
    		break;
    	case "07":
    		$user_month = "Jul";
    		break;
    	case "08":
    		$user_month = "Aug";
    		break;
    	case "09":
    		$user_month = "Sep";
    		break;
    	case "10":
    		$user_month = "Oct";
    		break;
    	case "11":
    		$user_month = "Nov";
    		break;
    	case "12":
    		$user_month = "Dec";
    		break;
    
    }
}

$sql2 = "SELECT user_type_description FROM user_type WHERE user_type_id = '{$user_type_id}'";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2)>0) {
	$row = mysqli_fetch_assoc($result2);
	$user_type_id = $row["user_type_description"];
}


$number_teams = 0;

$sql4 = "SELECT COUNT(user_team.team_id) AS number_teams FROM user_team LEFT JOIN team ON user_team.team_id = team.team_id WHERE user_id = {$user_display_id} AND user_team.visibility = 1 AND team.visibility = 1";
$result4 = mysqli_query($conn, $sql4);
$row = mysqli_fetch_assoc($result4);
$number_teams = $row["number_teams"];
if (mysqli_num_rows($result4) == 0) {
	$number_teams = 0;
}



$currentWeek = date("W", strtotime("D")); 
$currentWeek = $currentWeek - 1;
$currentYear = date("Y", strtotime("D"));




$sql5 = "SELECT COUNT(ut.task_id) AS number_tasks FROM user_task AS ut LEFT JOIN task AS t ON ut.task_id = t.task_id WHERE ut.user_id = '{$user_display_id}' AND ut.visibility = 1 AND t.visibility = 1";
$result5 = mysqli_query($conn, $sql5);
$row = mysqli_fetch_assoc($result5);
$number_tasks = $row["number_tasks"];


function calcHours($week, $year, $user_id, $conn) {
	$sqlCalc = "SELECT SUM(sub_task.sub_task_time) AS total_horas
			FROM sub_task LEFT JOIN user_task ON sub_task.user_task_id = user_task.user_task_id
			WHERE WEEK(sub_task.sub_task_date) = {$week} AND user_task.user_id = '{$user_id}' AND YEAR(sub_task.sub_task_date) = {$year} AND sub_task.sub_task_type_id = 1";
	$resultCalc = mysqli_query($conn, $sqlCalc);
	if (mysqli_num_rows($resultCalc) > 0) {
		$row = mysqli_fetch_assoc($resultCalc);
		if ($row["total_horas"] == NULL){
			return 0;
		}
		return $row["total_horas"];
	} else {
		return 0;
	}
} 

$sum_hours_week_user = calcHours($currentWeek, $currentYear, $user_display_id, $conn);
$sum_hours_week_user_footer =  $sum_hours_week_user;



?>


<html>
<head>
	<title> Highest Good Network </title>
	<link href="styles/profile.css" rel="stylesheet">
	<link href="styles/basicStyle.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="img/favicon.png"/>
	<link href="chosen/chosen.css" rel="stylesheet">
	
	<!-- CHOSEN -->
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	
	<script type="text/javascript" src="chosen/chosen.jquery.js"></script>
	<script type="text/javascript" src="chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="chosen/chosen.proto.js"></script>
	<script type="text/javascript" src="chosen/chosen.proto.min.js"></script>
	
  	<script type="text/javascript" src="scripts/jquery.autocomplete.min.js"></script>
  	
  	<script type="text/javascript" src="scripts/profile.js"></script>
</head>
<body>
	<nav>
		<ul>
			<li> <a href="profile.php" class="active"> PROFILE </a> </li>
			<li> <a href="tasks"> TASKS </a> </li>
			<li> <a href="reports.php"> REPORTS </a> </li>
			<li> <a href="general"> SETUP </a> </li>
			<?php if ($_SESSION['user_type']==1 || $_SESSION['user_type']==2) { ?>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<?php } ?>
			<li class="right img"> <a href="sessionStop.php"> <img src="img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $_SESSION["user_first_name"] . " " . $_SESSION["user_last_name"] ?> </li>
			<li class="right" style="padding-right: 3%;"> 
			
				<div class="searchBar">
					<select class="chosen" style="width:200px;" id="selecionado">
						<option value='' disabled selected style='display:none;'>Choose a User</option>
						<?php
						        
						        	$sql = "SELECT user_first_name, user_last_name, user_id FROM user WHERE visibility=1";
						        	
						        	$result = mysqli_query($conn, $sql);
						        	
						        	if (mysqli_num_rows($result) > 0){
							        	while ($row = mysqli_fetch_assoc($result)){
							        		echo "<option style='color: black;' value=" . $row["user_id"] . ">" .  $row["user_first_name"] . " " . $row["user_last_name"] . "</option>";
							        	}
						        	} else {
						        		echo "<option disabled> No users to show </option>";
						        	}
						        ?>
						
					</select> <i class="fa fa-search" style="font-size: 100%; cursor: hand;" onclick="submitForm()"></i>
				</div>

			</li>
			
			
		</ul>
	</nav>
	
	<form action="profile.php" id="formSubmit" method="post" style="margin:0;">
		<input type="hidden" name="user_id" id="user_id_form">
	</form>

	<content>

		<article class="artLeft">
		
			<div class="dimensaoImg">
			<?php 
			$url = "imageUpload/uploads/" . $user_id . ".jpg";
			if(file_exists($url)){
       				echo "<img class='userImg' src='" . $url . "'>";
    			} else {
    				echo "<img class='userImgBg' src='img/pictureIcon.png'>";
    			}
    			?>
    			</div>

		</article>

		<article class="artRight">

			<h1> <?php echo $user_first_name . " " . $user_last_name ?> </h1> 


			<table>
				<tr>
					<td><img src="img/loginIcon.png" title="Login" class="icon"></td>
					<td valign="middle"><?php echo $username ?></td>
				</tr>
				<tr>
					<td><img src="img/userTypeIcon.png" title="Role" class="icon"></td>
					<td valign="middle"><?php echo $user_type_id ?></td>
				</tr>
				<tr>
					<td><img src="img/phoneIcon.png" title="Phone" class="icon"></td>
					<td valign="middle"><?php echo $user_tel ?></td>
				</tr>
				<tr>
					<td><img src="img/emailIcon.png" title="Email" class="icon"></td>
					<td valign="middle"><?php echo $user_mail ?></td>
				</tr>
				<tr>
					<td><img src="img/birthdayIcon.png" title="Date of Birth" class="icon"></td>
					<td valign="middle"><?php echo $user_day . " " . $user_month; if ($birthday) { echo " - Happy Birthday, " . $user_first_name . "!";} ?></td>
				</tr>
			</table>

		</article>
		
		
		<article class = "badges">
			<div style="width: 100%; height: 8%;  background-color: #333333; padding-top:0.7%; margin-bottom:3%;">
			<h1> Badges </h1>
			</div>
			 <table class="tableBadges">
				
				<?php

$badges = false;
$count = 1;
$yearweek_current = date("Y") . date("W");
$yearweek = $yearweek_current - 2;
$yearweek_min = date("Y") . "01";

include_once("querys.php");
/* BLUE SQUARES IN A YEAR */
/*
$yearweek_min = $yearweek - 100;
$sql = "SELECT s.sub_task_date FROM sub_task AS s LEFT JOIN user_task AS ut ON s.user_task_id = ut.user_task_id WHERE ut.user_id = {$user_display_id} AND s.sub_task_name = ''";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$yearweek_task = date("Y", strtotime($row["sub_task_date"])) . date("W", strtotime($row["sub_task_date"]));
if ($yearweek_task > $yearweek_min) {
$yearweek_min = $yearweek_task;
}
$yearweek_max = $yearweek;
$number_blue_squares = number_blue_squares($conn, $user_id, $yearweek_max, $yearweek_min);
for ($i=1; $i<=$number_blue_squares; $i++) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/blue_square.jpg'> </td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
$yearweek_threemonths =  mktime(0, 0, 0, date("m", $yearweek)-3, date("d", $yearweek), date("Y", $yearweek));
if (number_blue_squares($conn, $user_id, $yearweek, $yearweek_threemonths) == 0 && $yearweek_threemonths < $yearweek_task){
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/no_blue_squares.jpg'> </td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
*/

/* PERSONAL RECORD */

$record = 0;
$record_week = "";
$currentYearWeek = (int)$currentWeek;

while ($currentYearWeek >= 1){
	
	$personalUserHours = calcHours($currentYearWeek, $currentYear, $user_id, $conn);
	
	if ($personalUserHours > $record) {
	
		$record = $personalUserHours;
		$record_week = $currentYearWeek;
	}
	$currentYearWeek = $currentYearWeek - 1;
}


if ($record_week == $currentWeek) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/record_week.jpg' title='Wow! You beat your personal record. CONGRATS!!'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}

/*------------------------------------------------------------------------------------------------------------*/
/* MOST HOURS IN A WEEK */
$record = 0;
$sqlUsers = "SELECT user_id FROM user";
$week_most = $currentWeek;
$year_most = $currentYear;


while ($week_most >= 0){
$resultUsers = mysqli_query($conn, $sqlUsers);
while ($rowUsers = mysqli_fetch_assoc($resultUsers)){

$userHours = calcHours($week_most, $year_most, $rowUsers["user_id"], $conn);

if ($userHours > $record) {


$record = $userHours;
$record_user = $rowUsers["user_id"];
}
}


if ($record_user == $user_id && $record <> 0) {
	$count_most++;
	
}
$week_most--;
$record = 0;
}

if ($count_most<>0){
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/most_hours.jpg' title='This is A M A Z I N G ! You are a work machine, you did the most hours in a week for {$count_most} time(s)'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}


/*--------------------------------------------------------------------------------------------------------------*/
/* MIN HOURS/WEEK */
$sqlMinHr = "SELECT user_week_hrs FROM user WHERE user_id = {$user_id}";
$resultMinHr = mysqli_query($conn, $sqlMinHr);
$rowMinHr = mysqli_fetch_assoc($resultMinHr);
$minHr = $rowMinHr["user_week_hrs"];
$week = $currentWeek;
$times2 = 0;
$times3 = 0;
$times4 = 0;
$times5 = 0;

while ($week >= 0 ){ 
	$hours = calcHours($week, $currentYear, $user_id, $conn);
	$times = $hours / $minHr;
	$times = round($times, 0, PHP_ROUND_HALF_DOWN);

	if ($times > 2) {
		$times2++;
	}
	if ($times > 3) {
		$times3++;
	}
	if ($times > 4) {
		$times4++;
	}
	if ($times > 5) {
		$times5++;
	}

	$week--;
}

if ($times2 > 0) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/2x.jpg' title='Good job! You doubled your minimun hours in a week for {$times2} time(s)'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($times3 > 0) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/3x.jpg' title='Incredible! You tripled your minimun hours in a week for {$times3} time(s)'></td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($times4 > 0) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/4x.jpg' title='Awesome! You beat 4x your minimun hours in a week for {$times4} time(s)'></td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($times5 > 0) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/5x.jpg' title='Fantastic! You beat 5x your minimun hours in a week for {$times5} time(s)'></td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
/*----------------------------------------------------------------------------------------------------------------*/

$week = $currentWeek;
$badge40 = 0;
$badge50 = 0;
$badge60 = 0;
$badge70 = 0;
$badge80 = 0;
$badge90 = 0;
while ($week >= 0) {
	$sum_hours_week_user = calcHours($week, $currentYear, $user_display_id, $conn);
	
	if ($sum_hours_week_user >= 90) {
		$badge90++;
	} 
	
	if ($sum_hours_week_user >= 80) {
		$badge80++;
	}  
	
	if ($sum_hours_week_user >= 70) {
		$badge70++;
	}
	
	if ($sum_hours_week_user >= 60) {
		$badge60++;
	} 
	
	if ($sum_hours_week_user >= 50) {
		$badge50++;
	} 
	
	if ($sum_hours_week_user >= 40) {
		$badge40++;
	}
	
	
	$week--;

}

/* 40H IN THE WEEK */
if ($badge40 <> 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/40h_week.jpg' title=' Good job! You achieved 40hrs of work in a week for {$badge40} time(s)'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}

/* 50H IN THE WEEK */
if ($badge50 <> 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/50h_week.jpg' title=' That is Great! You achieved 50hrs of work in a week for {$badge50} time(s)'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}

/* 60H IN THE WEEK */
if ($badge60 <> 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/60h_week.jpg' title='This is Fenomenal! You achieved 60hrs of work in a week for {$badge60} time(s)'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}

/* 70H IN THE WEEK */
if ($badge70 <> 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/70h_week.jpg' title='Amazing! You achieved 70hrs of work in a week for {$badge70} time(s)'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}


/* 80H IN THE WEEK */
if ($badge80 <> 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/80h_week.jpg' title='Insane! You achieved 80hrs of work in a week for {$badge80} time(s)'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}

/* 90H IN THE WEEK */
if ($badge90 <> 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/90h_week.jpg' title='No way! You achieved 90hrs of work in a week for {$badge90} time(s). Go Sleep, please!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/*--------------------------------------------------------------------------------------------------------------*/

/* 10000 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 10000 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/10000_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/10000_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/10000_infrastructure.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/10000_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/10000_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 5000 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 5000 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/5000_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/5000_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/5000_infra.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/5000_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/5000_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 3000 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 3000 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/3000_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/3000_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/3000_infra.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/3000_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/3000_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 2000 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 2000 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/2000_education.png'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/2000_funding.png'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/2000_infra.png'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/2000_interviews.png'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/2000_marketing.png'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 1000 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 1000 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/1000_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/1000_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/1000_infra.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/1000_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/1000_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 600 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 600 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/600_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/600_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/600_infra.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/600_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/600_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 400 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 400 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img alt='alo' src='img/badges/400_education.jpg'  ></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/400_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/400_infra.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/400_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/400_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}

/* 200 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 200 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/200_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/200_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/200_infra.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/200_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/200_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}


/* 100 HOURS IN EACH CATEGORY */
$sqlCategory = "SELECT category_id, category_description FROM category";
$resultCat = mysqli_query($conn, $sqlCategory);
while ($rowCat = mysqli_fetch_assoc($resultCat)){
$result = get_hours_category($conn, $user_id, $rowCat["category_id"]);
$row = mysqli_fetch_assoc($result);
if ($row["hours_category"] >= 100 && $rowCat["category_id"] <> 2){
if ($count%4 == 1) {
echo "<tr>";
}
if ($rowCat["category_id"]==1) {
echo "<td> <img src='img/badges/100_education.jpg'></td>";
}
if ($rowCat["category_id"]==3) {
echo "<td> <img src='img/badges/100_funding.jpg'></td>";
}
if ($rowCat["category_id"]==4) {
echo "<td> <img src='img/badges/100_infrastructure.jpg'></td>";
}
if ($rowCat["category_id"]==5) {
echo "<td> <img src='img/badges/100_interviews.jpg'></td>";
}
if ($rowCat["category_id"]==6) {
echo "<td> <img src='img/badges/100_marketing.jpg'></td>";
}
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
}
/*--------------------------------------------------------------------------------------------------------------*/

/* Quantity of users in a team of a manager */

$managerTeamNumber = get_quant_users_manager($conn, $user_id);

if ($managerTeamNumber >= 5 && $managerTeamNumber < 10) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/5_team.jpg' title='Thanks, Facilitator! You manage a team with 5 to 9 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($managerTeamNumber >= 10 && $managerTeamNumber < 15) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/10_team.jpg' title='Thanks, Organizer! You manage a team with 10 to 14 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($managerTeamNumber >= 15 && $managerTeamNumber < 20) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/15_team.jpg' title='You are my Leader! You manage a team with 15 to 19 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($managerTeamNumber >= 20  && $managerTeamNumber < 25) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/20_team.jpg' title='Thanks, Trendsetter! You manage a team with 20 to 24 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($managerTeamNumber >= 25  && $managerTeamNumber < 30) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/25_team.jpg' title='Thanks, Torchbearer! You manage a team with 25 to 29 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($managerTeamNumber >= 30  && $managerTeamNumber < 40) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/30_team.jpg' title='Thanks, Trailblazer! You manage a team with 30 to 39 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}
if ($managerTeamNumber >= 40 && $managerTeamNumber < 50) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/40_team.jpg' title='Thanks, Chief! You manage a team with 40 to 49 team members'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}

if ($managerTeamNumber >= 50) {
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/50_team.jpg' title='Hey Cowboy! You manage a team with 50 or more team members. How can you manage it?? Thank you!'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}
}

/*----------------------------------------------------------------------------------------------------------------------*/

/* 30H STREAK EDITEI O IF DAQUI*/ 
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 30 ) {
$streak++;
}
}
if ($row["hours"] <= 30){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/30h_streak.jpg'  title='This is impressive! You are working 30hrs streak until now, thank you so much!'></td>";
 /* . $streak .  week(s), thank you so much!'></td>";*/
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}

/* 40H STREAK  EDITEI O IF DAQUI*/
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 40) {
$streak++;
}
}
if ($row["hours"] <= 40){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/40h_streak.jpg'  title='This is incredible! You are working 40hrs streak until now, thank you so much!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/* 50H STREAK */
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 50) {
$streak++;
}
}
if ($row["hours"] <= 50){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/50h_streak.jpg'  title='This is outstanding! You are working 50hrs streak until now, thank you so much!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/* 60H STREAK */
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 60) {
$streak++;
}
}
if ($row["hours"] <= 60){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/60h_streak.jpg'  title='This is sweet sweet sweet! You are working 60hrs streak until now, thank you so much!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/* 70H STREAK */
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 70) {
$streak++;
}
}
if ($row["hours"] <= 70){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/70h_streak.jpg'  title='This is totally unbelievable! You are working 70hrs streak until now, thank you so much!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/* 80H STREAK */
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 80) {
$streak++;
}
}
if ($row["hours"] <= 80){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/70h_streak.jpg'  title='This is no sense! You are working 70hrs streak until now, thank you so much!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/* 90H STREAK */
$streak = 0;
while ($yearweek >= $yearweek_min){
$result = get_hours($conn, $user_id, $yearweek);
while ($row = mysqli_fetch_assoc($result)) {
if ($row["hours"] > 90) {
$streak++;
}
}
if ($row["hours"] <= 90){
break;
}
$yearweek--;
}
if ($streak > 0) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> <img src='img/badges/90h_streak.jpg'  title='You are unstoppable! You are working 90hrs streak until now, thank you so much!'></td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}
/*----------------------------------------------------------------------------------------------------------------------------*/
/* QUANT LEAD */
/*$result = get_quant_lead($conn, $user_id);
$row = mysqli_fetch_assoc($result);
if ($row["quant_lead"] >= 5) {
if ($count%4 == 1) {
echo "<tr>";
}
echo "<td> LEADS " . $row["quant_lead"] . " people</td>";
$badges = true;
$count++;
if ($count%4 == 0) {
echo "</tr>";
$count++;
}
}*/
/*----------------------------------------------------------------------------------------------------------------------------*/
/* LOGGED TIME IN DIFFERENT CATEGORIES */

$week = $currentWeek;
$count3 = 0;
$count4 = 0;
$count5 = 0;
$count6 = 0;

while ($week >= 0){
	$result = get_quant_cat($currentYear, $week, $conn, $user_id);
	if (mysqli_num_rows($result) >= 3) {
		$count3++;
	}
	if (mysqli_num_rows($result) >= 4) {
		$count4++;
	}
	
	if (mysqli_num_rows($result) >= 5) {
		$count5++;
	}
	if (mysqli_num_rows($result) >= 6) {
		$count6++;
	}
	
	$week--;
}

if ($count3 > 0){
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/3_categories.jpg' title='Well Done! You logged your time in 3 different categories for {$count3} time(s)'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}	
}
if ($count4 > 0){
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/4_categories.jpg' title='Great diversity! You logged your time in 4 different categories for {$count4} time(s)'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}	
}
if ($count5 > 0){
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/5_categories.jpg' title='This is a category party! You logged your time in 5 different categories for {$count5} time(s)'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}	
}
if ($count6 > 0){
	if ($count%4 == 1) {
		echo "<tr>";
	}
	echo "<td> <img src='img/badges/6_categories.jpg' title='You are a Multitasking person! You logged your time in 6 different categories for {$count6} time(s)'> </td>";
	$badges = true;
	$count++;
	if ($count%4 == 0) {
		echo "</tr>";
		$count++;
	}	
}


/*----------------------------------------------------------------------------------------------------------------------------*/

if ($count == 2) {
echo "<td style='background-image: none;'></td><td style='background-image: none;'></td></tr>";
}
if ($count == 3) {
echo "<td style='background-image: none;'></td></tr>";
}
if (!$badges){
echo "<td></td> <td> <img src='img/badges/no_badges.jpg'> </td><td></td>";
}

mysqli_close($conn);


?>	
				
				
				
				
			</table> 
		
		</article>
		

	</content>


	<footer>

		<!-- PHP HERE -->

		<div class="footLeft">

			<h1 class="test"> <?php echo $sum_hours_week_user_footer ?> </h1>
			<h2 class="test"> <?php if($sum_hours_week_user == 1){echo "Hour";} else{ echo "Hours";}?> </h2>
			<h3 class="test"> this week </h3>

		</div>

		<div class="footMid">

			<h1 class="test"> <?php echo $number_teams; ?> </h1>
			<h2 class="test"> <?php if($number_teams == 1){echo "Team";} else{ echo "Teams";}?> </h2>

		</div>

		<div class="footRight">

			<h1 class="test"> <?php echo $number_tasks ?></h1>
			


			<h2 class="test"> <?php if($number_tasks == 1){echo "Task";} else{ echo "Tasks";}?> </h2>

		</div>

	
	</footer>
	

</body>
</html>

<?php
mysqli_close($conn);
?>