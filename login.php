<?php 

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: User/index.php");
    exit;
}

// Include configs
require_once("config/connectServer.php");
require_once("config/connectDatabase.php");


$username = "";
$password = "";
$username_error = "";
$password_error = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Check username if empty
	if (empty(trim($_POST['username']))) {
		$username_error = "Please enter username";
	}
	else {
		$username = trim($_POST["username"]);
	}

	// Check if password is empty
	if(empty(trim($_POST["password"]))){
		$password_error = "Please enter your password.";
	} 
	else{
		$password = trim($_POST["password"]);
	}

    // Validate credentials
	if(empty($username_error) && empty($password_error)) {
        // Prepare a select statement
		$sql = "SELECT department_id, username, hashed_password FROM department_tb WHERE department_tb.username = ?";
		if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
			$param_username = $username;

            // Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
                // Store result
				mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
				if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
					if(mysqli_stmt_fetch($stmt)){
						if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
							session_start();

                            // Store data in session variables
							$_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;                         

                            // Redirect user to index page
							header("location: User\index.php");
						} else{
                            // Display an error message if password is not valid
							$password_error = "The password you entered was not valid.";
						}
					}
				} else{
                    // Display an error message if username doesn't exist
					$username_error = "No account found with that username.";
				}
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
		else {
			echo "Statement Problem: " . mysqli_error($conn);
		}
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
	<title>Login User</title>
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
						<strong>Log In</strong>
					</h5>
					<div class="card-body">
						<p class="text-center h3 red-text">Note: Only for Departments for now</p>
						<!-- Material form group -->
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<!-- Material input -->
							<div class="md-form form-group mt-5 
							<?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
								<i class="fas fa-user prefix"></i>
								<input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
								<label for="username">Username</label>

								<span class="help-block"><?php echo $username_error; ?></span>
							</div>
							<!-- Material input -->
							<div class="md-form form-group mt-5 
							<?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
								<i class="fas fa-lock prefix"></i>
								<input type="password" name="password" id="password" class="form-control">
								<label for="password">Password</label>

								<span class="help-block"><?php echo $password_error; ?></span>
							</div>

							<!-- Default checked -->
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="showPassword" onclick="myFunction()">
								<label class="custom-control-label" for="showPassword">Show Password</label>
							</div>

							<div class="text-center">
								<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
								<button type="submit" value="Login" class="btn btn-primary">Log in</button>
								<a href="index.php"><button type="button" class="btn btn-secondary">Go back</button></a>
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
	<script type="text/javascript" src="dist/js/other.js"></script>
	<script> 
    window.onload = function() { 
        document.getElementById("username").focus(); 
    } 
</script>

</body>
</html>