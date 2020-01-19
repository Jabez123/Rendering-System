<?php 

// Include configs
require_once("config/connectServer.php");
require_once("config/connectDatabase.php");

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_error = $confirm_password_error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
	if(empty(trim($_POST["new_password"]))){
		$new_password_error = "Please enter the new password.";     
	} elseif(strlen(trim($_POST["new_password"])) < 4){
		$new_password_error = "Password must have atleast 4 characters.";
	} else{
		$new_password = trim($_POST["new_password"]);
	}

    // Validate confirm password
	if(empty(trim($_POST["confirm_password"]))){
		$confirm_password_error = "Please confirm the password.";
	} else{
		$confirm_password = trim($_POST["confirm_password"]);
		if(empty($new_password_error) && ($new_password != $confirm_password)){
			$confirm_password_error = "Password did not match.";
		}
	}

    // Check input errors before updating the database
	if(empty($new_password_error) && empty($confirm_password_error)){
        // Prepare an update statement
		$sql = "UPDATE admin_tb SET password = ? WHERE admin_id = ?";

		if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
			$param_password = password_hash($new_password, PASSWORD_DEFAULT);
			$param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
				session_destroy();
				header("location: login.php");
				exit();
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}

        // Close statement
		mysqli_stmt_close($stmt);
	}

    // Close connection
	mysqli_close($conn);
}

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
		</div>
	</nav>
</header>

<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>

			<div class="col-sm-12 col-md-10">
				<div class="card">
					<div class="card-header h1 text-center">
						Change Password
					</div>
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<div class="md-form form-group mt-5 <?php echo (!empty($new_password_error)) ? 'has-error' : ''; ?>">
								<input class="form-control" type="password" name="new_password" id="new_password">
								<label for="new_password">Password</label>
								<span class="help-block"><?php echo $new_password_error; ?></span>
							</div>
							<div class="md-form form-group mt-5 <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
								<input class="form-control" type="password" name="confirm_password" id="confirm_password">
								<label for="confirm_password">Confirm Password</label>
								<span class="help-block"><?php echo $confirm_password_error; ?></span>
							</div>
							<div class="card-footer text-center">
								<a href="index.php"><button type="button" class="btn btn-secondary">Go Back</button></a>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-2"></div>
		</div>
	</div>
</main>



<script type="text/javascript" src="dist/js/jquery.js"></script>
<script type="text/javascript" src="dist/js/popper.js"></script>
<script type="text/javascript" src="dist/js/bootstrap.js"></script>
<script type="text/javascript" src="dist/js/mdb.js"></script>

</body>
</html>

