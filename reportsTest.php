<?php


	
	$servername = "localhost";
	$user_db = "ethosolu_ocApp";
	$password_db = "8888Thisawesomepassword!!";
	$dbname = "ethosolu_ocApp";

/* trocar a a associacao da tabela user com a tabela task;
associar a tabela task com a quantidade de hora da subtask
associar datas iguais e somar horas
passar variaveis pro js
criar for para criacao de vetor no grafico
*/
// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



include_once 'charts/lineChartUserHoursxTeam1.php';
include_once 'charts/barChartNumberTeamTasks3.php';
include_once 'charts/hoursChartUsers.php';
//include_once 'charts/barChartCategoriesxHours2.php';

$user_id = "";
$user_first_name = "";
$user_type_id = "";
$user_tel = "";
$user_mail = "";

$sql = "SELECT user_id, user_first_name, user_last_name, user_type_id, user_tel, user_mail FROM user WHERE user_login = '{$username}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];
    $user_first_name = $row["user_first_name"];
    $user_last_name = $row["user_last_name"];
    $_SESSION["user_first_name"] = $user_first_name;
    $_SESSION["user_last_name"] = $user_last_name;
    $user_type_id = $row["user_type_id"];
    $user_tel = $row["user_tel"];
    $user_mail = $row["user_mail"];
}

$count_teams=0;
$sql32 = "SELECT team_description FROM team";
$result32 = mysqli_query($conn, $sql32);
if (mysqli_num_rows($result32) > 0) {
	while ($row = mysqli_fetch_assoc($result32)) {
		$all_teams[$count_teams] = $row["team_description"];
	
		$count_teams++;
	}
}

$usersCount = 0;

$sqlTeam = "SELECT user_id FROM user";
$resultTeam = mysqli_query($conn, $sqlTeam);
if(mysqli_num_rows($resultTeam) > 0){
	while($row = mysqli_fetch_assoc($resultTeam)){

		$userId[$usersCount] = $row["user_id"];
		$usersCount++;

	}
}

?>


<html>
<head>
	<title> Highest Good Network </title>
	<link href="styles/reports.css" rel="stylesheet">
	<link href="styles/basicStyle.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="scripts/charts/canvasjs.min.js"></script>
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
    </style>

</head>
<body>

<nav>
		<ul>
			<li> <a href="#" class="active"> PROFILE </a> </li>
			<li> <a href="#"> TASKS </a> </li>
			<li> <a href="#"> REPORTS </a> </li>
			<li> <a href="general"> SETUP </a> </li>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0"> PORTAL </a> </li>
			<li class="right img"> <a href="sessionStop.php"> <img src="img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $user_first_name; ?> </li>
		</ul>
	</nav>
	<div class = "content">
		<content>
			<div class="divTeams">
				<div class = "divTopBar">
					
						
						
				</div>


				<article class="artRight">

				<div id="teamMembers">
					
					<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="10000" data-pause="hover">
							  <!-- Indicators -->
							  	<ol class="carousel-indicators">
									  <?php 
									  		$max = 1;  //maximum of images inside the slide show
									  		for($i=0; $i<$max; $i++){
									  			if($i == 0){
									  				echo '<li data-target="#myCarousel" data-slide-to="' . $i . '" class="active"></li>';
									  			} else {
									  				echo '<li data-target="#myCarousel" data-slide-to="' . $i . '"></li>';
									  			}
									  		}
									  ?>	
								</ol>
							  <!-- Wrapper for slides -->
							  <div class="carousel-inner" role="listbox">
							  		<?php

							  			for($i=0; $i<count($userId); $i++){
							  				if($i==0){
									  			echo '<div class="item active">
									  			<div id="teamMembers">
													<form>' ;
															$urlImage = "imageUpload/uploads/" . $userId[$i] . ".jpg";
																if(file_exists($urlImage)){
								       								echo "<img class='userImg' src='" . $urlImage . "'>";
								    							} else {
								    								echo "<img class='userImgBg' src='img/pictureIcon.png'>";
								    							}  
								    					
								    					
													echo '</form>';	
													echo '
								    					<table class="infoTable">
															<tr>
																
																<td class="nameUser" valign="middle">' . $user_first_name . '</td>
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
															$urlImage = "imageUpload/uploads/" . $userId[$i] . ".jpg";
																if(file_exists($urlImage)){
								       								echo "<img class='userImg' src='" . $urlImage . "'>";
								    							} else {
								    								echo "<img class='userImgBg' src='img/pictureIcon.png'>";
								    							}  
								    					
								    					
													echo '</form>';	
													echo '
								    					<table class="infoTable">
															<tr>
																
																<td class="nameUser" valign="middle">' . $user_first_name . '</td>
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

							  <!-- Left and right controls -->
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
										
										
										

										</article>
									</div>

								</content>
							</div>
							
							<div>
									   <table class="hoursBarsChart hours" id="barChart2">
		   
			<?php  
			

			$ballColor = "#FF0000";
			if (mysqli_num_rows($result5) > 0){
				for($i=0; $i<count($user_name_temp); $i++){	
					$percentGraphType2 = getPercentType2($sum_tangible_hours[$i]);
					$colorType2 = getColorType2($sum_tangible_hours[$i]);
					$user_id_encode = $user_id_temp[$i];
					
					if($sum_tangible_hours[$i] >= $user_week_hrs_temp[$i]){
						$ballColor = "#008000";
					} else {
						$ballColor = "#FF0000";
					}
					

					
					echo "<tr onclick='showTasksID({$user_id_encode})' style='cursor: hand;'>";
					
			
					
					echo "<td><div style='border-radius: 50%; background:" . $ballColor . "; height: 8px; width:8px;'></div></td>";
					echo "<td>" . $user_name_temp[$i] . "</td>";
	                		echo "<td style='text-align: right;'>" . $sum_tangible_hours[$i] . " tan" . "</td>";
	                		echo "<td style='width: 40%;'>" . "<div style='border-radius: 10px; border: 1px solid; background: #FFF; height: 8px;'><div style='width: " . $percentGraphType2 . "%; background-color: " . $colorType2 . "; border-radius: 10px; height: 8px;'></div></div>" . "</td>";
	                		echo "<td>" . $time_task[$i] . " tot" . "</td></tr>";
					
					

	                	}
			
	                }
	                	                						
			?>
			
		   </table>
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