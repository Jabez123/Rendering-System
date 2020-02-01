<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values

$department_id = $_REQUEST['id'];
$user_id = $_REQUEST['user_id'];

$sql = "SELECT users_tb.username, users_tb.password,
    department_tb.department_id, department_tb.department_name FROM users_tb INNER JOIN
    department_tb ON users_tb.user_id = department_tb.user_id
    WHERE department_id = $department_id";

$result = mysqli_query($conn, $sql);

$username_error = $password_error = $department_name_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate trainee id
    if(empty(trim($_POST["department_name"]))){
        $department_name_error = "Please enter a department name.";
    }
    else {
        // Prepare a select statement
        $sql = "SELECT department_tb FROM department_name WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_department_name);
            
            // Set parameters
            $param_department_name = trim($_POST["department_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $department_name_error = "This department is already added.";
                } else{
                    $department_name = trim($_POST["department_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter a username.";
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
        
        $username = trim($_POST['username']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash 
        $password = trim($_POST["password"]);
        $department_name = trim($_POST["department_name"]);

        // Prepare an update statement
        $sql_user = "UPDATE users_tb SET
    	username = '$username', password = '$password', hashed_password = '$hashed_password'
        WHERE user_id = $user_id";

        $sql_department = "UPDATE department_tb SET
        department_name = '$department_name' WHERE department_id = $department_id";
         
        $conn->autocommit(FALSE);

        $conn->query($sql_user) or die("Error User: " . mysqli_error($conn));
        $conn->query($sql_department) or die("Error Department: " . mysqli_error($conn));

        $conn->commit();
        $conn->close();

        header("Location: department.php");
    }
}
?>


<?php include("header.php") ?>

<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-lg-2"></div>

			<div class="col-sm-12 col-md-8 col-lg-8">
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
									<span class="help-block text-danger"><?php echo $password_error; ?></span>
								</div>
                                <!-- Default checked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="showPassword" onclick="myFunction()">
                                    <label class="custom-control-label" for="showPassword">Show Password</label>
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

			<div class="col-md-2 col-lg-2"></div>
		</div>
	</div>
</main>

<?php include("footer.php") ?>
<script> 
    window.onload = function() { 
        document.getElementById("username").focus(); 
    } 
</script> 