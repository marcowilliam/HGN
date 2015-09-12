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

	$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail, user_dob FROM user WHERE user_login = '{$username}'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result)) {
	    $row = mysqli_fetch_assoc($result);
	    $user_id = $row["user_id"];
	    $first_name = $row["user_first_name"];
	    $last_name = $row["user_last_name"];
	    $user_type_id = $row["user_type_id"];
	    $user_tel = $row["user_tel"];
	    $user_mail = $row["user_mail"];
	    $user_dob = $row["user_dob"];
	}

	$sql2 = "SELECT user_type_description FROM user_type WHERE user_type_id = '{$user_type_id}'";
	$result2 = mysqli_query($conn, $sql2);
	if (mysqli_num_rows($result2)) {
		$row = mysqli_fetch_assoc($result2);
		$user_type_description = $row["user_type_description"];
	}


$usersCount = 0;
$teamsCount = 0;


$sqlTeam1 = "SELECT team_id, team_description FROM team";
$resultTeam1 = mysqli_query($conn, $sqlTeam1);
if(mysqli_num_rows($resultTeam1) > 0){
	while($row = mysqli_fetch_assoc($resultTeam1)){

		$teamIds[$teamsCount] = $row["team_id"];
		$teamNames[$teamsCount] = $row["team_description"];
		$teamsCount++;

	}
}



$sqlCurrentUser = "SELECT team_id, team_description FROM team LEFT JOIN user_team ON team.team_id = user_team.team_id WHERE user_id = '{$user_id}";
$resultCurrentUser = mysqli_query($conn, $sqlCurrentUser);
if(mysqli_num_rows($resultCurrentUser) > 0){
	while($row = mysqli_fetch_assoc($resultCurrentUser)){
		$userTeamName = $row["team_description"];
		$userTeamId = $row["team_id"];
	}
}
echo $userTeamName;


$teamUserCount = 0;
$sqlTeamMembers = "SELECT user_id, user_first_name, user_last_name FROM user LEFT JOIN user_team ON user.user_id = user_team.user_id WHERE team_id = '{$userTeamId}'";
$resultTeamMembers = mysqli_query($conn, $sqlTeamMembers);
if(mysql_query($resultTeamMembers) > 0){
	while($row = mysqli_fetch_assoc($resultTeamMembers)){
		 $teamUsersId[$teamUserCount] = $row["user_id"];
		 $teamUserFirst[$teamUserCount] = $row["user_first_name"];
		 $teamUserLast[$teamUserCount] = $row["user_last_name"];
		 $teamUserCount++;

	}
}



//include_once 'charts/lineChartUserHoursxTeam1.php';
//include_once 'charts/barChartNumberTeamTasks3.php';
//include_once 'charts/barChartCategoriesxHours2.php';

if(!isset($_POST['teamSelected'])){

	$userTeamName = $_SESSION['team_name'];
}
else{

	$userTeamName = $_POST['teamSelected'];

}

$sql1 = "SELECT team_id FROM team WHERE team_description = '{$team}'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
	while ($row = mysqli_fetch_assoc($result1)) { //run while the lines are not empty
		$teamId = $row["team_id"];
	}
}


$usersCount = 0;

$sql2 = "SELECT user_id FROM User_team WHERE team_id = '{$teamId}'";
$result2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($result2) > 0){
	while($row = mysqli_fetch_assoc($result2)){

		$userId[$usersCount] = $row["user_id"];
		$usersCount++;

	}
}



?>


<html>
<head>
	<title> Highest Good Network </title>
	<link href="styles/reports.css" rel="stylesheet">

	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	
	<link href="styles/basicStyle.css" rel="stylesheet">
<!--	<script type="text/javascript" src="scripts/charts/canvasjs.min.js"></script>
	<script type="text/javascript" src="scripts/charts/membersxteam.js"></script>
	<script src="scripts/jquery.min.js"></script>
	<script src="scripts/chartphp.js"></script>
	
 	<script type="text/javascript" src="scripts/jquery.autocomplete.min.js"></script>
  	<script type="text/javascript" src="scripts/currency-autocomplete.js"></script>
	<link rel="stylesheet" href="scripts/chartphp.css">

	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



  <link rel="stylesheet" href="chosen/docsupport/prism.css">
  <link rel="stylesheet" href="chosen/chosen.css">
  <script type="text/javascript" src="chosen/chosen.jquery.js"></script>
  <script type="text/javascript" src="chosen/chosen.jquery.min.js"></script>
  <script type="text/javascript" src="chosen/chosen.proto.js"></script>
  <script type="text/javascript" src="chosen/chosen.proto.min.js"></script>

<script type="text/javascript">

jQuery(document).ready(function(){
   $(".chosen-select").chosen({disable_search_threshold: 1});
});

</script>



  <style>


  	.carousel-control.left, .carousel-control.right {
    background-image: none;
	}

	.left > .glyphicon-chevron-left{
	margin-left: -50%;
	}

	.right > .glyphicon-chevron-right{
		margin-right: -50%
	}
  </style> -->


</head>
<body>

<nav>
		<ul>
			<li> <a href="profile.php"> PROFILE </a> </li>
			<li> <a href="tasks"> TASKS </a> </li>
			<li> <a href="reports.php" class="active"> REPORTS </a> </li>
			<li> <a href="general"> SETUP </a> </li>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0"> PORTAL </a> </li>
			<li class="right img"> <a href="sessionStop.php"> <img src="img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $first_name . " " . $last_name ?> </li>
		</ul>
</nav>
	<div class = "content">
		<content>
			<div class="divTeams">
				<div class = "divTopBar">
						<table class="alo" cellspacing="10">
							<tr>
								<td> 
							
									<form action="" method="post" id="teamsForm">
										<select data-placeholder="Choose a Team..." class="chosen-select" style="width:350px;" name="teamSelected">
										<option value=""></option>
										<?php 
										for($i=0; $i<count($teamIds); $i++){
											echo '<option onclick="document.getElementById(teamsForm).submit()" value="' . $teamNames[$i] . '">' . $teamNames[$i] .'</option>';
										}
										?>
										</select>
										<button type="button" onclick="document.getElementById('teamsForm').submit()">Click Me!</button>
									</form>
						 		</td>
								<td class="textName"> 
									<p><?php echo $teamNames[0];?></p> 
								</td>
							</tr>
						</table>

				</div>



				<article class="artRight">

				<div id="teamMembers">
					
					<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="100000" data-pause="hover">
							//  <!-- Indicators -->
							  	<ol class="carousel-indicators">
									  <?php 
									  		$max = count($teamUsersId);  //maximum of images inside the slide show
									  		for($i=0; $i<$max; $i++){
									  			if($i == 0){
									  				echo '<li data-target="#myCarousel" data-slide-to="' . $i . '" class="active"></li>';
									  			} else {
									  				echo '<li data-target="#myCarousel" data-slide-to="' . $i . '"></li>';
									  			}
									  		}
									  ?>	
								</ol>
					
							  <div class="carousel-inner" role="listbox">
							  		<?php
												//******tirar bug que corta imagem********
							  			for($i=0; $i<count($teamUsersId); $i++){
							  				if($i==0){
							  				
									  			echo '<div class="item active">
									  			<div id="teamMembers">
													<form>' ;
															$urlImage = "imageUpload/uploads/28.jpg";
																if(file_exists($urlImage)){
								       								echo "<img class='userImg' src='" . $urlImage . "'>";
								    							} else {
								    								echo "<img class='userImgBg' src='img/pictureIcon.png'>";
								    							}  
								    					
								    					
													echo '</form>';	
													echo '
								    					<table class="infoTable">
															<tr>
																
																<td class="nameUser" valign="middle">' . $first_name . '</td>
															</tr>
															<tr>
																<td><img src="img/phoneIcon.png" title="Phone" class="icon"></td>
																<td valign="middle">' . $user_tel . '</td>
															</tr>
															<tr>
																<td><img src="img/emailIcon.png" title="Email" class="icon"></td>
																<td valign="middle">' . $user_mail . '</td>
															</tr>

														</table>
												</div>
												</div>';
											} else {
												echo '<div class="item">
									  			<div id="teamMembers">
													<form>' ;
															$urlImage = "imageUpload/uploads/" . $teamUsersId[$i] . ".jpg";
																if(file_exists($urlImage)){
								       								echo "<img class='userImg' src='" . $urlImage . "'>";
								    							} else {
								    								echo "<img class='userImgBg' src='img/pictureIcon.png'>";
								    							}  
								    					
								    					
													echo '</form>';	
													echo '
								    					<table class="infoTable">
															<tr>
																
																<td class="nameUser" valign="middle">' . $first_name . '</td>
															</tr>
															<tr>
																<td><img src="img/phoneIcon.png" title="Phone" class="icon"></td>
																<td valign="middle">' . $user_tel . '</td>
															</tr>
															<tr>
																<td><img src="img/emailIcon.png" title="Email" class="icon"></td>
																<td valign="middle">' . $user_mail . '</td>
															</tr>

														</table>
												</div>
												</div>';
											}
										}

							  		?>

							  </div>  

							 // <!-- Left and right controls -->
							  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							    <span class="glyphicon glyphicon-chevron-left" aria-hidden="false"></span>
							    <span class="sr-only">Previous</span>
							  </a>
							  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							    <span class="sr-only">Next</span>
							  </a>
							</div>
										</div>
										<div id="chartContainer">

											

										</div>
										
										
										<div class="side-by-side clearfix">
											
										</div>




										</article>
									</div>

								</content>
							</div>

	<div id="connectionPhpJs0" style="display:none;">
		<?php echo json_encode($userNames);?>
	</div>
	<div id="connectionPhpJs1" style="display:none;">
		<?php echo json_encode($finalHours);?>
	</div>
	<div id="connectionPhpJs2" style="display:none;">
		<?php echo json_encode($finalDates);?>
	</div>
	<div id="connectionPhpJs3" style="display:none;">
		<?php echo json_encode($currentMonth);?>
	</div>
	<div id="connectionPhpJs4" style="display:none;">
		<?php echo json_encode($quantityDatesUser);?>
	</div>
	<div id="connectionPhpJs6" style="display:none;">
		<?php echo json_encode($all_teams);?>
	</div>

</body>
</html>