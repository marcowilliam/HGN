<html>
<head>
	<title> Login - Highest Good Network </title>
	<link href="styles/index.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="img/favicon.png"/>
</head>

<body>
	
	<div>
	<a href="http://www.onecommunityglobal.org" target="_blank"> <img class="siteLogo" src="img/Logo.jpg"> </a>
	</div>
	
	<div>
	<img class="appLogo" src="img/LogoTest.png">
	</div>
	
	<section class="main">
	
	
	
	
			<form class="form-1" action="loginAuth.php" method="POST">
				<p class="field">
					<input type="text" name="username" placeholder="Username">
				<i class="fa fa-user fa-lg"></i>
			</p>
			<p class="field">
				<input type="password" name="password" placeholder="Password">
				<i class="fa fa-lock fa-lg"></i>
			</p>
			<p class="submit">
				<button type="submit" name="submit"><i class="fa fa-arrow-right fa-lg arrowLen"></i></button>
			</p>

		<h2><a href="forgotPassword.php" class="forgot"> Forgot your password? </a></h2>
		</form>
	</section>

</body>
</html>