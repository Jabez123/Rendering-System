<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values
/*$previous_trainee_id = $first_name = $last_name = "";
$id_name = $gender = $class = ""; 
$class_group = $room = $team = "";
$status = "";*/

$previous_trainee_id = $_REQUEST['id'];

$sql = "SELECT * FROM trainee_tb WHERE trainee_id= $previous_trainee_id";

$result = mysqli_query($conn, $sql);

$trainee_id_error = $first_name_error = $last_name_error = $id_name_error = "";
$gender_error = $class_error = $class_group_error = $room_error = "";
$team_error = $status_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate trainee id
    if(empty(trim($_POST["trainee_id"]))){
        $trainee_id_error = "Please enter a trainee id.";
    }
    else{
        // Prepare a select statement
    	$sql = "SELECT trainee_id FROM trainee_tb WHERE trainee_id = ? AND trainee_id != ?";

    	if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
    		mysqli_stmt_bind_param($stmt, "ii", $param_trainee_id, $param_previous_trainee_id);

            // Set parameters
            $param_previous_trainee_id = $previous_trainee_id;
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
        $class_error = "Please enter a class.";
    }

	// Validate class group   
    if(empty(trim($_POST["class_group"]))){
        $class_group_error = "Please enter a class group.";
    }

	// Validate room
    if(empty(trim($_POST["room"]))){
        $room_error = "Please enter a room.";
    }

	// Validate team
    if(empty(trim($_POST["team"]))){
        $team_error = "Please enter a team.";
    }

	// Validate status
    if(empty(trim($_POST["status"]))){
        $status_error = "Please enter a status.";
    }
    
    // Check input errors before inserting in database
    if(empty($trainee_id_error) && empty($first_name_error) && empty($last_name_error) && empty($id_name_error) && 
	empty($gender_error) && empty($class_error) && empty($class_group_error) &&
	empty($room_error) && empty($team_error) && empty($status_error)) {
        

        // Prepare an update statement
        $sql = "UPDATE trainee_tb SET
    	trainee_id = ?, first_name = ?, last_name = ?, id_name = ?, 
        gender = ?, class = ?, class_group = ?, 
        room = ?, team = ?, status = ?
        WHERE trainee_id = ?";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssssssssi", 
            	$param_trainee_id, $param_first_name, $param_last_name, $param_id_name, 
            	$param_gender, $param_class, $param_class_group, 
            	$param_room, $param_team, $param_status, $param_previous_trainee_id);
            
            // Set parameters
            $param_previous_trainee_id = $previous_trainee_id;
            $param_trainee_id = trim($_POST["trainee_id"]);
            $param_first_name = trim($_POST["first_name"]);
            $param_last_name = trim($_POST["last_name"]);
            $param_id_name = trim($_POST["id_name"]);
            $param_gender = trim($_POST["gender"]);
            $param_class = trim($_POST["class"]);
            $param_class_group = trim($_POST["class_group"]);
            $param_room = trim($_POST["room"]);
            $param_team = trim($_POST["team"]);
            $param_status = trim($_POST["status"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: trainee.php");
            } 

            else{
                echo "Something went wrong. Please try again later.";
                echo "Update Error: " . mysqli_error($conn);
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
						Edit Trainee
					</div>
					<div class="card-body">
						<form action="" method="post">
						<div class="row">
							<?php 
								while($row = mysqli_fetch_assoc($result)) {
									$first_name = $row['first_name'];
									$last_name = $row['last_name'];
									$id_name = $row['id_name'];
									$gender = $row['gender'];
									$class = $row['class'];
									$class_group = $row['class_group'];
									$room = $row['room'];
									$team = $row['team'];
									$status = $row['status'];
							 ?>
							<div class="col-md-6">
								<div class="md-form form-group mt-5 <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="trainee_id" id="trainee_id" value="<?php echo $previous_trainee_id; ?>">
									<label for="trainee_id">Trainee ID</label>
									<span class="help-block text-danger"><?php echo $trainee_id_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($first_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
									<label for="first_name">First Name</label>
									<span class="help-block text-danger"><?php echo $first_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($last_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
									<label for="last_name">Last Name</label>
									<span class="help-block text-danger"><?php echo $last_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($id_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="id_name" id="id_name" value="<?php echo $id_name; ?>">
									<label for="id_name">ID Name</label>
									<span class="help-block text-danger"><?php echo $id_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($gender_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="gender">Gender</p>
									<input type="hidden" name="gender" value="">
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 20px;">
									  <input type="radio" class="custom-control-input" id="brother" name="gender" value="Brother" 
									  <?php if ($gender == "Brother") { ?> checked <?php } ?>>
									  <label class="custom-control-label" for="brother">Brother</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 50px;">
									   <input type="radio" class="custom-control-input" id="sister" name="gender" value="Sister" 
									   <?php if ($gender == "Sister") { ?> checked <?php } ?>>
									  <label class="custom-control-label" for="sister">Sister</label>
									</div>
									<p class="text-danger"><?php echo $gender_error; ?></p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="md-form form-group mt-5 <?php echo (!empty($class_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="status">Class</p>
									<select name="class" id="class" class="browser-default custom-select">
									  <option>Select Class</option>
									  <option <?php if ($class == "FT1") { ?> selected <?php } ?> value="FT1">FT1</option>
									  <option <?php if ($class == "FT2") { ?> selected <?php } ?> value="FT2">FT2</option>
									  <option <?php if ($class == "FT3") { ?> selected <?php } ?>  value="FT3">FT3</option>
									  <option <?php if ($class == "FT4") { ?> selected <?php } ?>  value="FT4">FT4</option>
									</select>
									<p class="text-danger"><?php echo $gender_error; ?></p>
								</div>

								<div class="md-form form-group mt-5 <?php echo (!empty($class_group_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="class_group" id="class_group" value="<?php echo $class_group; ?>">
									<label for="class_group">Class Group</label>
									<span class="help-block text-danger"><?php echo $class_group_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($room_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="room" id="room" value="<?php echo $room; ?>">
									<label for="room">Room</label>
									<span class="help-block text-danger"><?php echo $room_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($team_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="team" id="team" value="<?php echo $team; ?>">
									<label for="team">Team</label>
									<span class="help-block text-danger"><?php echo $team_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($status_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="status">Status</p>
									<select name="status" id="status" class="browser-default custom-select">
									  <option>Select Status</option>
									  <option <?php if ($status == "Active") { ?> selected <?php } ?>  value="Active">Active</option>
									  <option <?php if ($status == "Inactive") { ?> selected <?php } ?>  value="Inactive">Inactive</option>
									</select>
									<p class="text-danger"><?php echo $gender_error; ?></p>
								</div>
							</div>
						</div>
					<?php } ?>
							<div class="card-footer">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<button type="submit" class="mt-3 btn btn-block btn-primary">Save</button>
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