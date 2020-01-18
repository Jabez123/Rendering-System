<?php 
	include("config/connectDatabase.php");
	include("config/connectServer.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<link rel="stylesheet" type="text/css" href="dist/css/all.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="dist/css/mdb.css">
	<link rel="stylesheet" type="text/css" href="dist/css/style.css">
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
							<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item active">
							<a class="nav-link" href="trainee.php">Trainees</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">In Charge</a>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<span class="navbar-text white-text mr-5">
								Hello Admin!
							</span>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-user"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-left"
							aria-labelledby="navbarDropdownMenuLink-333">
								<a class="dropdown-item" href="#">Change Password</a>
								<a class="dropdown-item" href="#">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>

<!-- Footer -->
	<footer class="page-footer font-small unique-color-dark mt-5 footer text-center">

		<!-- Footer Elements -->
		<div class="container">

			<!-- Call to action -->
			<ul class="list-unstyled list-inline py-2">
				<li class="list-inline-item">
					<h5 class="mb-1">Register for free</h5>
				</li>
				<li class="list-inline-item">
					<a href="#topSection" class="btn btn-outline-white btn-rounded">Return to top</a>
				</li>
			</ul>
			<!-- Call to action -->

		</div>
		<!-- Footer Elements -->

		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© 2020 Copyright:
			<a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a>
		</div>
		<!-- Copyright -->

	</footer>
	<!-- Footer -->


	<script type="text/javascript" src="dist/js/jquery.js"></script>
	<script type="text/javascript" src="dist/js/popper.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="dist/js/mdb.js"></script>
</body>
</html>