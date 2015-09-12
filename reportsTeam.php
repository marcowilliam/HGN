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

	$team_display_id = $_POST["team_id"];
	


	// Create connection
$conn = new mysqli($servername, $user_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



include_once 'charts/lineChartUserHoursxTeam1.php';

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
	
	
	
		   			// criar query pra pegar todos os usuarios que de acordo com o time
	   			$countTeamUsers = 0;
	   			$sqlTeamUsers = "SELECT user_id, user_first_name, user_last_name, user_tel, user_mail FROM user LEFT JOIN user_team ON user.user_id = user_team.user_id WHERE user_team.team_id =team.team_id ";/*{$team_display_id}*/
	   			$resultTeamUsers = mysqli_query($conn, $sqlTeamUsers);
					if(mysqli_num_rows($resultTeamUsers)>0){
						while($rowTeamUsers = mysqli_fetch_assoc($resultTeamUsers)){
	
							$teamUsersId[$countTeamUsers] = $rowTeamUsers["user_id"];
							$teamUsersFirst[$countTeamUsers] = $rowTeamUsers["user_first_name"];
							$teamUsersSecond[$countTeamUsers] = $rowTeamUsers["user_last_name"];
							$teamUsersTel[$countTeamUsers] = $rowTeamUsers["user_tel"];
							$teamUsersMail[$countTeamUsers] = $rowTeamUsers["user_mail"];
							$countTeamUsers++;
							
							
						}
						
					}
					echo $teamUsersId[0];





?>


<html>
<head>
	<title> Highest Good Network </title>
	
	<link href="styles/reports.css" rel="stylesheet">

	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	
	<link href="styles/basicStyle.css" rel="stylesheet">
	<link href="chosen/chosen.css" rel="stylesheet">
	




	
	<!-- CHOSEN -->
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	
	<script type="text/javascript" src="chosen/chosen.jquery.js"></script>
	<script type="text/javascript" src="chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="chosen/chosen.proto.js"></script>
	<script type="text/javascript" src="chosen/chosen.proto.min.js"></script>
	
  	<script type="text/javascript" src="scripts/jquery.autocomplete.min.js"></script>
  	
  	<script type="text/javascript" src="scripts/reports.js"></script>
  	<link rel="stylesheet" href="charts/scripts/chartphp.css">
  	<script type="text/javascript" src="charts/scripts/charts/canvasjs.min.js"></script>
  	<script type="text/javascript" src="charts/scripts/charts/membersxteam.js"></script>
	
	<!-- TINYSLIDER -->
	<link rel="stylesheet" type="text/css" href="tinyslider/style.css">
	<script type="text/javascript" src="tinyslider/script.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	

	

  	

</head>
<body>

<nav>
		<ul>
			<li> <a href="profile.php"> PROFILE </a> </li>
			<li> <a href="tasks"> TASKS </a> </li>
			<li> <a href="reports.php" class="active"> REPORTS </a> </li>
			<li> <a href="general"> SETUP </a> </li>
			<?php if ($_SESSION['user_type']==1 || $_SESSION['user_type']==2) { ?>
			<li> <a href="https://docs.google.com/spreadsheets/d/1bRcrZh3NT7Ya11cl_LQHDlfSD36UYbRfUcSNfBM4du8/edit#gid=0" target="_blank"> PORTAL </a> </li>
			<?php } ?>
			<li class="right img"> <a href="sessionStop.php"> <img src="img/logoutIcon.png" alt="Logout"> </a> </li>
			<li class="right"> Hi, <?php echo $first_name . " " . $last_name ?> </li>
		</ul>
</nav>



<form action="reports.php" id="formSubmit" method="post" style="margin:0;">
	<input type="hidden" name="team_id" id="team_id_form">
	<input type="hidden" name="user_id" id="user_id_form">
</form>

<div class="title">

	<?php
	echo $user_id_display;
		
		if ($user_display_id <> false) {
			$sql = "SELECT user_first_name, user_last_name FROM user WHERE user_id = {$user_display_id}";
		       	$result = mysqli_query($conn, $sql);
		       	
		       	if (mysqli_num_rows($result) > 0){
		        	while ($row = mysqli_fetch_assoc($result)){
		        		echo $row["user_first_name"] . " " . $row["user_last_name"] . " REPORT";
		        	}
		        }
		} else {
			$sql = "SELECT team_description, team_id FROM team WHERE team_id = {$team_display_id}";
		       	$result = mysqli_query($conn, $sql);
		       	
		       	if (mysqli_num_rows($result) > 0){
		        	while ($row = mysqli_fetch_assoc($result)){
		        		echo $row["team_description"] . " REPORT";
		        	}
		        } 
		}
	
	?>
	
<div class="searchBar">
	<select class="chosen" style="width:200px;" data-placeholder="Choose a country..." id="selecionado">
		<option value='' disabled selected style='display:none;'>Choose a Team or User</option>
		<optgroup label="Teams">
		        <?php
		        
		        	if ($_SESSION["user_type"]==1 || $_SESSION["user_type"]==2) {
		        		$sql = "SELECT team_id, team_description FROM team WHERE visibility=1";
		        	} else {
		        		$sql = "SELECT team_id, team_description FROM team WHERE visibility=1 AND team_id IN (SELECT team_id FROM user_team WHERE user_id =   {$user_id} AND visibility=1)";
		        	}
		  
		        	$result = mysqli_query($conn, $sql);
		        	
		        	if (mysqli_num_rows($result) > 0){
			        	while ($row = mysqli_fetch_assoc($result)){
			        		$teamId = $row["team_id"];
			        		echo "<option value=" . $row["team_id"] . " onclick='submitFormTeam(" . $row["team_id"] . ")'>" . $row["team_description"] . "</option>";
			        	}
		        	} else {
		        		echo "<option disabled> No teams to show </option>";
		        	}
		        ?>
		</optgroup>
		<optgroup label="Users" title="users">
		
			<?php
		        
		        	if ($_SESSION["user_type"]==1 || $_SESSION["user_type"]==2) {
		        		$sql = "SELECT user_first_name, user_last_name, user_id FROM user WHERE visibility=1";
		        	} else {
		        		$sql = "SELECT user_first_name, user_last_name, user_id FROM user WHERE visibility=1 AND user_id IN (SELECT user_id FROM user_team WHERE visibility = 1 AND team_id IN (SELECT team_id FROM user_team WHERE user_id = {$user_id} AND visibility=1) )";
		        	}
		        	
		        	$result = mysqli_query($conn, $sql);
		        	
		        	if (mysqli_num_rows($result) > 0){
			        	while ($row = mysqli_fetch_assoc($result)){
			        		echo "<option value=" . $row["user_id"] . " onclick='$(#team_id).val()=0'>" .  $row["user_first_name"] . " " . $row["user_last_name"] . "</option>";
			        	}
		        	} else {
		        		echo "<option disabled> No users to show </option>";
		        	}
		        ?>
		
		</optgroup>
		
	</select> <i class="fa fa-search" style="font-size: 80%; cursor: hand;" onclick="submitForm()"></i>
</div>

</div>

<content>

		<article class="navLeft">


			<div class="navLeftTop">
				<hr style="width:0%; height:80%; float:right">
				<p>Team Name: </p>
				<p>Hours this week:</p>
				<p>Manager:</p>
			</div>

		</article>



		<article class="rightArt">
		
   		<div id="wrapper">
	   		<div id="container">
	   		

				<div class="sliderbutton" id="slideleft" onclick="slideshow.move(-1)"></div>
				<div id="slider">
					<ul>
						<li><img src="img/Logo.jpg" width="558" height="235" alt="Image One" /></li>
						<li><img src="img/LogoTest.png" width="558" height="235" alt="Image Two" /></li>
						<li><img src="img/Logo.png" width="558" height="235" alt="Image Three" /></li>
					</ul>
				</div>
				<div class="sliderbutton" id="slideright" onclick="slideshow.move(1)"></div>
				<ul id="pagination" class="pagination">
					<li onclick="slideshow.pos(0)"></li>
					<li onclick="slideshow.pos(1)"></li>
					<li onclick="slideshow.pos(2)"></li>
				</ul>
			</div>
		</div>
			<script type="text/javascript">
				var slideshow=new TINY.slider.slide('slideshow',{
					id:'slider',
					auto:4,
					resume:false,
					vertical:false,
					navid:'pagination',
					activeclass:'current',
					position:1,
					rewind:false,	
					elastic:true,
					left:'slideleft',
					right:'slideright'
				});
			</script>
	 
	

				<div id="chartContainer" style="margin-top:30%; width:98%; height:50%;">
					
				</div>
			

  		</article>

 	</content>
 	
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



</body>
</html>

<?php
mysqli_close($conn);
?>