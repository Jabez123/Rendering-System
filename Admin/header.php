<?php 
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin_admin"]) || $_SESSION["loggedin_admin"] !== true){
	header("location: login.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../dist/css/all.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/mdb.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/style.css">
	<!-- MDBootstrap Datatables  -->
	<link href="../dist/css/addons/datatables.min.css" rel="stylesheet">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../dist/css/bootstrap-select.min.css">
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark unique-color">
			<div class="container">
				<a class="navbar-brand" id="topSection" href="#">Rendering System</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="trainee.php">Trainees</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="department.php">Departments</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="rules.php">Rules</a>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<span class="navbar-text white-text mr-5">
								Hello <?php echo htmlspecialchars($_SESSION["username"]); ?>!
							</span>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-left"
								aria-labelledby="navbarDropdownMenuLink-333">
								<a class="dropdown-item" href="change_password.php">Change Password</a>
								<a class="dropdown-item" href="logout.php">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>