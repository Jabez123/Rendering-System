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
$user_id = $_REQUEST['user_id'];

$sql = "SELECT trainee_tb.trainee_id, trainee_tb.user_id, 
	trainee_tb.first_name, trainee_tb.last_name, trainee_tb.gender, trainee_tb.class,
	trainee_tb.class_group, trainee_tb.room, trainee_tb.team, 
	trainee_tb.status, trainee_tb.locality, trainee_tb.region,
	users_tb.username, users_tb.password
	FROM trainee_tb INNER JOIN users_tb ON trainee_tb.user_id = users_tb.user_id
	WHERE trainee_id = $previous_trainee_id";

$result = mysqli_query($conn, $sql);

$trainee_id_error = $first_name_error = $last_name_error = $username_error = $password_error = "";
$gender_error = $class_error = $class_group_error = $room_error = "";
$team_error = $status_error = $locality_error = $region_error = "";
 
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
        $username_error = "Please enter a id name.";
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

    if (empty(trim($_POST['locality']))) {
    	$locality_error = "Please enter a locality.";
    }

    if (empty(trim($_POST['region']))) {
    	$region_error = "Please select a region.";
    }
    
    // Check input errors before inserting in database
    if(empty($trainee_id_error) && empty($first_name_error) && empty($last_name_error) && empty($id_name_error) && 
	empty($gender_error) && empty($class_error) && empty($class_group_error) &&
	empty($room_error) && empty($team_error) && empty($status_error) && empty($locality_error) &&
	empty($region_error) && empty($username_error) && empty($password_error)) {
		$trainee_id = trim($_POST['trainee_id']);
		$username = trim($_POST['id_name']);
		$password = trim($_POST['password']);
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$gender = $_POST['gender'];
		$class = $_POST['class'];
		$class_group = $_POST['class_group'];
		$room = $_POST['room'];
		$team = $_POST['team'];
		$status = $_POST['status'];
		$region = $_POST['region'];
		$locality = $_POST['locality'];

		$sql_user = "UPDATE users_tb SET username = '$username', 
		password = '$password', hashed_password = '$hashed_password' WHERE user_id = $user_id";

		$sql_trainee = "UPDATE trainee_tb SET first_name = '$first_name', last_name = '$last_name',
		gender = '$gender', class = '$class', class_group = '$class_group', room = '$room',
		team = '$team', status = '$status', locality = '$locality', region = '$region' WHERE trainee_id = $trainee_id";

		$conn->autocommit(FALSE);
		$conn->query($sql_user) or die("Error User: " . mysqli_error($conn));
		$conn->query($sql_trainee) or die("Error Trainee: " . MYSQLI_ERROR($conn));
		$conn->commit();
		$conn->close();

		header("Location: trainee.php");
    }
    else {
    	echo "Error: " . mysqli_error($conn);
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
						Edit Trainee
					</div>
					<div class="card-body">
						<form action="" method="post">
						<div class="row">
							<?php 
								while($row = mysqli_fetch_assoc($result)) {
									$first_name = $row['first_name'];
									$last_name = $row['last_name'];
									$username = $row['username'];
									$password = $row['password'];
									$gender = $row['gender'];
									$class = $row['class'];
									$class_group = $row['class_group'];
									$room = $row['room'];
									$team = $row['team'];
									$status = $row['status'];
									$region = $row['region'];
									$locality = $row['locality'];
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
								<div class="md-form form-group mt-5 <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="id_name" id="id_name" value="<?php echo $username ?>">
									<label for="id_name">ID Name / Username</label>
									<span class="help-block text-danger"><?php echo $username_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="password" name="password" id="password" value="<?php echo $password ?>">
									<label for="password">Password</label>
									<span class="help-block text-danger"><?php echo $password_error; ?></span>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="showPassword" onclick="myFunction()">
									<label class="custom-control-label" for="showPassword">Show Password</label>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($gender_error)) ? 'has-error' : ''; ?>">
									<label class="text-black-50" for="gender">Gender</label>
									<input type="hidden" name="gender" value="">
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
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
								<div class="md-form form-group mt-5 <?php echo (!empty($class_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="status">Class</p>
									<select name="class" id="class" class="browser-default custom-select" onchange="copyText(event)">
									  <option>Select Class</option>
									  <option <?php if ($class == "FT1") { ?> selected <?php } ?> value="FT1">FT1</option>
									  <option <?php if ($class == "FT2") { ?> selected <?php } ?> value="FT2">FT2</option>
									  <option <?php if ($class == "FT3") { ?> selected <?php } ?>  value="FT3">FT3</option>
									  <option <?php if ($class == "FT4") { ?> selected <?php } ?>  value="FT4">FT4</option>
									</select>
									<p class="text-danger"><?php echo $class_error; ?></p>
								</div>
							</div>
							<div class="col-md-6">
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
									<label class="text-black-50" for="status">Status</label>
									<input type="hidden" name="status" value="">
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
									  <input type="radio" class="custom-control-input" id="active" name="status" value="Active" 
									  <?php if ($status == "Active") { ?> checked <?php } ?>>
									  <label class="custom-control-label" for="active">Active</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 50px;">
									   <input type="radio" class="custom-control-input" id="inactive" name="status" value="Inactive" 
									   <?php if ($status == "Inactive") { ?> checked <?php } ?>>
									  <label class="custom-control-label" for="inactive">Inactive</label>
									</div>
									<p class="text-danger"><?php echo $status_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($region_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="region">Region</p>
									<select name="region" id="region" class="selectpicker" data-live-search="true" data-width="99%">
									  <option value="<?php echo $region ?>" selected>Current: <?php echo $region ?></option>
									  <?php if ($region == "NCR") { ?>
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
									  <?php } ?>
									  <?php if ($region == "CAR") { ?>
									  <option value="NCR">NCR</option>
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
									  <?php } ?>
									  <?php if ($region == "Region 1") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
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
									  <?php } ?>
									  <?php if ($region == "Region 2") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
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
									  <?php } ?>
									  <?php if ($region == "Region 3") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
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
									  <?php } ?>
									  <?php if ($region == "Region 4") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
									  <option value="Region 3">Region 3</option>
									  <option value="Region 5">Region 5</option>
									  <option value="Region 6">Region 6</option>
									  <option value="Region 7">Region 7</option>
									  <option value="Region 8">Region 8</option>
									  <option value="Region 9">Region 9</option>
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 5") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
									  <option value="Region 3">Region 3</option>
									  <option value="Region 4">Region 4</option>
									  <option value="Region 6">Region 6</option>
									  <option value="Region 7">Region 7</option>
									  <option value="Region 8">Region 8</option>
									  <option value="Region 9">Region 9</option>
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 6") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
									  <option value="Region 3">Region 3</option>
									  <option value="Region 4">Region 4</option>
									  <option value="Region 5">Region 5</option>
									  <option value="Region 7">Region 7</option>
									  <option value="Region 8">Region 8</option>
									  <option value="Region 9">Region 9</option>
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 7") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
									  <option value="Region 3">Region 3</option>
									  <option value="Region 4">Region 4</option>
									  <option value="Region 5">Region 5</option>
									  <option value="Region 6">Region 6</option>
									  <option value="Region 8">Region 8</option>
									  <option value="Region 9">Region 9</option>
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 8") { ?>
									  <option value="NCR">NCR</option>
									  <option value="CAR">CAR</option>
									  <option value="Region 1">Region 1</option>
									  <option value="Region 2">Region 2</option>
									  <option value="Region 3">Region 3</option>
									  <option value="Region 4">Region 4</option>
									  <option value="Region 5">Region 5</option>
									  <option value="Region 6">Region 6</option>
									  <option value="Region 7">Region 7</option>
									  <option value="Region 9">Region 9</option>
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 9") { ?>
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
									  <option value="Region 10">Region 10</option>
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 10") { ?>
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
									  <option value="Region 11">Region 11</option>
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 11") { ?>
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
									  <option value="Region 12">Region 12</option>
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 12") { ?>
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
									  <option value="Region 13">Region 13</option>
									  <?php } ?>
									  <?php if ($region == "Region 13") { ?>
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
									  <?php } ?>
									</select>
									<p class="text-danger"><?php echo $region_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($locality_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="locality" id="locality" value="<?php echo $locality ?>">
									<label for="locality">Locality</label>
									<span class="help-block text-danger"><?php echo $locality_error; ?></span>
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
<script> 
    window.onload = function() { 
        document.getElementById("trainee_id").focus(); 
    } 
</script> 