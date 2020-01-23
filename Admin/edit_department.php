<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values

$previous_department_id = $_REQUEST['id'];

$sql = "SELECT * FROM department_tb WHERE department_id= $previous_department_id";

$result = mysqli_query($conn, $sql);

$username_error = $password_error = $department_name_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate trainee id
    if(empty(trim($_POST["department_name"]))){
        $department_name_error = "Please enter a department name.";
    }
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter a username.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM department_tb WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_error = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
        	mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 4){
        $password_error = "Password must have atleast 4 characters.";
    } else{
        $password = trim($_POST["password"]);
        $hashed_password = trim($_POST["password"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_error) && empty($password_error) && empty($department_name_error)) {
        

        // Prepare an update statement
        $sql = "UPDATE department_tb SET
    	username = ?, password = ?, hashed_password = ?, department_name = ?
        WHERE department_id = ?";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", 
            	$param_username, $param_password, $param_hashed_password, $param_department_name, $param_department_id);
            
            // Set parameters
            $param_department_id = $previous_department_id;
            $param_username = trim($_POST["username"]);
            $param_password = trim($_POST["password"]);
            $param_hashed_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash 
            $param_department_name = trim($_POST["department_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: department.php");
            } 

            else{
                echo "Something went wrong. Please try again later.";
                echo "Updating Error: " . mysqli_error($conn);
            }
            // Close statement
        mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>


<?php include("header.php") ?>

<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-sm-12 col-md-10 col-lg-12">
				<div class="card">
					<div class="card-header h1 text-center">
						Edit Department
					</div>
					<div class="card-body">
						<form action="" method="post">
							<?php 
								while($row = mysqli_fetch_assoc($result)) {
									$department_id = $row['department_id'];
									$department_name = $row['department_name'];
									$username = $row['username'];
									$password = $row['password'];
							 ?>
							<div class="md-form form-group mt-5 <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="username" id="username" value="<?php echo $username ?>">
									<label for="username">Username</label>
									<span class="help-block text-danger"><?php echo $username_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="password" name="password" id="password" value="<?php echo $password ?>">
									<label for="password">Password</label>
									<span class="help-block">Current Password: <?php echo $password; ?></span>
									<span class="help-block text-danger"><?php echo $password_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($department_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="department_name" id="department_name" value="<?php echo $department_name ?>">
									<label for="department_name">Department Name</label>
									<span class="help-block text-danger"><?php echo $department_name_error; ?></span>
								</div>
							<?php } ?>
							<div class="card-footer text-center">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<button type="submit" class="mt-3 btn btn-block btn-primary">Save</button>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4">
									</div>
									<div class="col-md-4 col-lg-4">
										<a href="department.php"><button type="button" class="mt-3 btn btn-block btn-secondary">Go Back</button></a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-1"></div>
		</div>
	</div>
</main>

<?php include("footer.php") ?>