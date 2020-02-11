<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values
$trainee_id = $first_name = $last_name = $id_name = "";
$gender = $class = $class_group = $room = "";
$team = $status = "";

$trainee_id_error = $first_name_error = $last_name_error = $id_name_error = $password_error = "";
$gender_error = $class_error = $class_group_error = $room_error = "";
$team_error = $status_error = $region_error = $locality_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate trainee id
    if(empty(trim($_POST["trainee_id"]))){
        $trainee_id_error = "Please enter a trainee id.";
    }
    else{
        // Prepare a select statement
    	$sql = "SELECT trainee_id FROM trainee_tb WHERE trainee_id = ?";

    	if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
    		mysqli_stmt_bind_param($stmt, "i", $param_trainee_id);

            // Set parameters
    		$param_trainee_id = trim($_POST["trainee_id"]);

            // Attempt to execute the prepared statement
    		if(mysqli_stmt_execute($stmt)){
    			/* store result */
    			mysqli_stmt_store_result($stmt);

    			if(mysqli_stmt_num_rows($stmt) == 1){
    				$trainee_id_error = "This trainee id is already taken.";
    			} else{
    				$trainee_id = trim($_POST["trainee_id"]);
    			}
    		} else{
    			echo "Oops! Something went wrong. Please try again later.";
    		}
    	}

        // Close statement
    	mysqli_stmt_close($stmt);
    }
 
    // Validate first name
    if(empty(trim($_POST["first_name"]))){
        $first_name_error = "Please enter a first name.";
    }

    // Validate last name
    if(empty(trim($_POST["last_name"]))){
        $last_name_error = "Please enter a last name.";
    } 

    // Validate id name
    if(empty(trim($_POST["id_name"]))){
        $id_name_error = "Please enter a id name.";
    }

    // Validate gender
    if(empty(trim($_POST["gender"]))){
        $gender_error = "Please enter a gender.";
    }

    // Validate class
    if(empty(trim($_POST["class"]))){
        $class_error = "Please select a class.";
    }

	// Validate class group   
    if(empty(trim($_POST["class_group"]))){
        $class_group_error = "Please enter a class group.";
    }

	// Validate room
 	/*if(empty(trim($_POST["room"]))){
    	$room_error = "Please enter a room.";
    }*/

	// Validate team
    if(empty(trim($_POST["team"]))){
        $team_error = "Please enter a team.";
    }

	// Validate status
    if(empty(trim($_POST["status"]))){
        $status_error = "Please enter a status.";
    }

    // Validate region
    if (empty(trim($_POST["region"]))) {
    	$region_error = "Please select a region.";
    }

    if (empty(trim($_POST["locality"]))) {
    	$locality_error = "Please enter a locality.";
    }
    
    // Check input errors before inserting in database
    if(empty($trainee_id_error) && empty($first_name_error) && empty($last_name_error) && empty($id_name_error) && 
	empty($gender_error) && empty($class_error) && empty($class_group_error) &&
	empty($room_error) && empty($team_error) && empty($status_error)) {
		$trainee_id = trim($_POST['trainee_id']);
		$username = trim($_POST['id_name']);
		$password = trim($_POST['password']);
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$user_level = 4;

		$first_name = trim($_POST['first_name']);
		$last_name = trim($_POST['last_name']);
		$gender = trim($_POST['gender']);
		$class = trim($_POST['class']);
		$class_group = trim($_POST['class_group']);
		$room = trim($_POST['room']);
		$team = trim($_POST['team']);
		$status = trim($_POST['status']);
		$locality = trim($_POST['locality']);
		$region = trim($_POST['region']);

        
        $sql_user = "INSERT INTO users_tb (username, password, hashed_password, user_level) VALUES ('$username', '$password', '$hashed_password', $user_level)";
        $sql_trainee = "INSERT INTO trainee_tb (
        trainee_id, user_id, first_name, last_name, id_name, 
        gender, class, class_group, 
        room, team, status, locality, region) 
        VALUES ('$trainee_id', (SELECT user_id FROM users_tb WHERE username = '$username' AND password = '$password'),
    	'$first_name', '$last_name', '$username', '$gender', '$class',
    	'$class_group', '$room', '$team', 
    	'$status', '$locality', '$region')";

    	$conn->query($sql_user) or die("Error User: " . mysqli_error($conn));
    	$conn->query($sql_trainee) or die("Error Trainee: " . mysqli_error($conn));
        
        $conn->commit();
        $conn->close();

        header("Location: trainee.php");
    }
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
						Add Trainee
					</div>
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="row">
							<div class="col-md-6">
								<div class="md-form form-group mt-5 <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="trainee_id" id="trainee_id">
									<label for="trainee_id">Trainee ID</label>
									<span class="help-block text-danger"><?php echo $trainee_id_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($first_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="first_name" id="first_name">
									<label for="first_name">First Name</label>
									<span class="help-block text-danger"><?php echo $first_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($last_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="last_name" id="last_name">
									<label for="last_name">Last Name</label>
									<span class="help-block text-danger"><?php echo $last_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($id_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="id_name" id="id_name">
									<label for="id_name">ID Name / Username</label>
									<span class="help-block text-danger"><?php echo $id_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="password" name="password" id="password">
									<label for="password">Password</label>
									<span class="help-block text-danger"><?php echo $password_error; ?></span>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="showPassword" onclick="myFunction()">
									<label class="custom-control-label" for="showPassword">Show Password</label>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($gender_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="gender">Gender</p>
									<select name="gender" id="gender" class="selectpicker" data-live-search="true" data-width="99%" onchange="copyText(event)">
									  <option value=" " selected>Select Gender</option>
									  <option value="Brother">Brother</option>
									  <option value="Sister">Sister</option>
									</select>
									<p class="text-danger"><?php echo $gender_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($class_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="class">Class</p>
									<select name="class" id="class" class="selectpicker" data-live-search="true" data-width="99%" onchange="copyText(event)">
									  <option value=" " selected>Select Class</option>
									  <option value="FT1">FT1</option>
									  <option value="FT2">FT2</option>
									  <option value="FT3">FT3</option>
									  <option value="FT4">FT4</option>
									</select>
									<p class="text-danger"><?php echo $class_error; ?></p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="md-form form-group mt-5 <?php echo (!empty($class_group_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="class_group" id="class_group" value=" ">
									<label for="class_group">Class Group</label>
									<span class="help-block text-danger"><?php echo $class_group_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($room_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="room" id="room">
									<label for="room">Room</label>
									<span class="help-block text-danger"><?php echo $room_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($team_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="team" id="team">
									<label for="team">Team</label>
									<span class="help-block text-danger"><?php echo $team_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($status_error)) ? 'has-error' : ''; ?>">
									<label class="text-black-50" for="status">Status</label>
									<input type="hidden" name="status" value="">
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
									  <input type="radio" class="custom-control-input" id="active" name="status" checked value="Active">
									  <label class="custom-control-label" for="active">Active</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 50px;">
									   <input type="radio" class="custom-control-input" id="inactive" name="status" value="Inactive">
									  <label class="custom-control-label" for="inactive">Inactive</label>
									</div>
									<p class="text-danger"><?php echo $status_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($region_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="region">Region</p>
									<select name="region" id="region" class="selectpicker" data-live-search="true" data-width="99%">
									  <option value=" " selected>Select Region</option>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
									  <option value="Region 3">Region 3</option>
									  <option value="Region 4">Region 4</option>
									  <option value="Region 5">Region 5</option>
									  <option value="Region 6">Region 6</option>
									  <option value="Region 7">Region 7</option>
									  <option value="Region 8">Region 8</option>
									  <option value="Region 9">Region 9</option>
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									</select>
									<p class="text-danger"><?php echo $region_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($id_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="locality" id="locality">
									<label for="locality">Locality</label>
									<span class="help-block text-danger"><?php echo $id_name_error; ?></span>
								</div>
							</div>
						</div>
							<div class="card-footer text-center mt-5">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<button type="submit" class="mt-3 btn btn-block btn-primary">Add</button>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4">
									</div>
									<div class="col-md-4 col-lg-4">
										<a href="trainee.php"><button type="button" class="mt-3 btn btn-block btn-secondary">Go Back</button></a>
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
<script> 
    window.onload = function() { 
        document.getElementById("trainee_id").focus(); 
    } 
</script> 