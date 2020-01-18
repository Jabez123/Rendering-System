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
	<main class="mt-5">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4 col-sm-12">

				<div class="card">

					<h5 class="card-header unique-color white-text text-center py-4">
						<strong>Login In</strong>
					</h5>

					<div class="card-body">
						<!-- Material form group -->
						<form action="#" method="post">
							<!-- Material input -->
							<div class="md-form form-group mt-5">
								<i class="fas fa-user prefix"></i>
								<input type="text" id="username" class="form-control">
								<label for="username">Username</label>
							</div>
							<!-- Material input -->
							<div class="md-form form-group mt-5">
								<i class="fas fa-lock prefix"></i>
								<input type="password" id="password" class="form-control">
								<label for="password">Password</label>
							</div>

							<!-- Default checked -->
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="showPassword">
								<label class="custom-control-label" for="showPassword">Show Password</label>
							</div>

							<div class="text-center">
								<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
								<button type="button" class="btn btn-primary">Primary</button>
							</div>
						</form>
						<!-- Material form group -->
					</div>
				</div>
			</div>
			<div class="col-md-4"></div>

		</div>
	</main>

	<script type="text/javascript" src="dist/js/jquery.js"></script>
	<script type="text/javascript" src="dist/js/popper.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="dist/js/mdb.js"></script>

</body>
</html>