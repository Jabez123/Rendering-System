<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values
$department_id = $offense_code = $offense_type = $offense_description = $offense_input = "";

$department_id_error = $offense_code_error = $offense_type_error = $offense_description_error = $offense_input_error = "";
$sql = "SELECT * FROM department_tb";

$result = mysqli_query($conn, $sql);
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$type_name = $_POST['type_name'];

	// Validate department name
    if(empty(trim($_POST["department_id"]))){
        $department_id_error = "Please enter a department name.";
    }
 
    // Validate offense code
    if(empty(trim($_POST["offense_code"]))){
        $offense_code_error = "Please enter a offense code.";
    }
    else {
    	// Prepare a select statement
    	$sql = "SELECT offense_code FROM rules_tb WHERE offense_code = ?";

    	if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
    		mysqli_stmt_bind_param($stmt, "s", $param_offense_code);

            // Set parameters
    		$param_offense_code = trim($_POST["offense_code"]);

            // Attempt to execute the prepared statement
    		if(mysqli_stmt_execute($stmt)){
    			/* store result */
    			mysqli_stmt_store_result($stmt);

    			if(mysqli_stmt_num_rows($stmt) == 1){
    				$offense_code_error = "This offense code already taken.";
    			} else{
    				$offense_code = trim($_POST["offense_code"]);
    			}
    		} else{
    			echo "Oops! Something went wrong. Please try again later.";
    		}
    	}

        // Close statement
    	mysqli_stmt_close($stmt);
    }

    if (empty(trim($_POST["type_name"]))) {
    	$offense_type_error = "Please enter a offense type.";
    }

    // Validate offense description
    if(empty(trim($_POST["offense_description"]))){
        $offense_description_error = "Please enter a offense description.";
    }

    if (empty(trim($_POST['offense_input']))) {
        $offense_input_error = "Please select an offense input";
    }
    
    // Check input errors before inserting in database
    if(empty($department_id_error) && empty($offense_code_error) 
    	&& empty($type_name_error) && empty($offense_description_error)) {



        // Prepare an insert statement
        $sql = "INSERT INTO rules_tb (
        department_id, offense_code, offense_type, offense_description, offense_input) 
        VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", 
            	$param_department_id, $param_offense_code, $param_offense_type, $param_description, $param_offense_input);
            
            // Set parameters
            $param_department_id = trim($_POST["department_id"]);
            $param_offense_code = trim(strtoupper($_POST["offense_code"]));
            $param_offense_type = trim($_POST["type_name"]);
            $param_description = trim($_POST["offense_description"]);
            $param_offense_input = trim($_POST['offense_input']);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: rules.php");
            } 

            else{
                echo "Something went wrong. Please try again later.";
                echo "Error: " . mysqli_error($conn);
            }
            // Close statement
        mysqli_stmt_close($stmt);
        }
        else {
        	echo "Error: " . mysqli_error($conn);
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
			<div class="col-md-2 col-lg-2"></div>

			<div class="col-sm-12 col-md-8 col-lg-8">
				<div class="card">
					<div class="card-header h1 text-center">
						Add Rule
					</div>
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="row">
							<div class="col-md-12">
								<div class="md-form form-group mt-5 <?php echo (!empty($department_id_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="department_id">Department Name</p>
									<select name="department_id" id="department_id" class="selectpicker" data-live-search-style="startsWith" data-live-search="true" data-width="99%">
										<option value=" " selected>Select Department Name</option>
										<?php while($row = mysqli_fetch_assoc($result)) {
											$department_id = $row['department_id'];
											$department_name = $row['department_name'];
										 ?>
										<option value="<?php echo $department_id ?>"><?php echo $department_name; ?></option>
									<?php } ?>
									</select>
										
									<p class="text-danger"><?php echo $department_id_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_code_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_code" id="offense_code">
									<label for="offense_code">Offense Code</label>
									<span class="help-block text-danger"><?php echo $offense_code_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_type_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="type_name">Offense Type</p>
									<select name="type_name" id="type_name" class="selectpicker" data-live-search-style="startsWith" data-live-search="true" data-width="99%">
									  	<option value=" " selected>Select Offense Type</option>
									  	<option value="CONDUCT">CONDUCT</option>
									  	<option value="MISCELLANEOUS">MISCELLANEOUS</option>
									  	<option value="GROUP">GROUP</option>
                                        <option value="LATE ON SESSION">LATE ON SESSION</option>
                                        <option value="ONE SUM">ONE SUM</option>
                                        <option value="GROUNDED">GROUNDED</option>
									</select>
									<p class="text-danger"><?php echo $offense_type_error; ?></p>
								</div>
                                <div class="md-form form-group mt-5 <?php echo (!empty($offense_input)) ? 'has-error' : ''; ?>">
                                    <p class="text-black-50">Offense Input</p>
                                    <div class="custom-control custom-radio custom-control-inline ml-4">
                                        <input type="hidden" name="offense_input" value="Individual">
                                        <input type="radio" class="custom-control-input" id="individual" name="selection" checked onclick="hideGroup()">
                                        <label class="custom-control-label" for="individual">Individual</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
                                        <input type="radio" class="custom-control-input" id="group" name="selection" onclick="showGroup()">
                                        <label class="custom-control-label" for="group">Group</label>
                                    </div>
                                    <p class="text-danger"><?php echo $offense_input_error; ?></p>
                                </div>
                                <div id="input" class="md-form form-group mt-5" style="display: none;">
                                    <div class="custom-control custom-radio custom-control-inline ml-4">
                                        <input type="radio" class="custom-control-input" id="room" name="offense_input" value="Room Offense">
                                        <label class="custom-control-label" for="room">Room</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
                                        <input type="radio" class="custom-control-input" id="team" name="offense_input" value="Team Offense">
                                        <label class="custom-control-label" for="team">Team</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
                                        <input type="radio" class="custom-control-input" id="region" name="offense_input" value="Region Offense">
                                        <label class="custom-control-label" for="region">Region</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline" style="margin-left: 100px;">
                                        <input type="radio" class="custom-control-input" id="class" name="offense_input" value="Class Offense">
                                        <label class="custom-control-label" for="class">Class</label>
                                    </div>
                                </div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_description)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_description" id="offense_description">
									<label for="offense_description">Description</label>
									<span class="help-block text-danger"><?php echo $offense_description_error; ?></span>
								</div>
							</div>
						</div>
							<div class="card-footer text-center">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<button type="submit" class="mt-3 btn btn-block btn-primary">Add</button>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4">
									</div>
									<div class="col-md-4 col-lg-4">
										<a href="rules.php"><button type="button" class="mt-3 btn btn-block btn-secondary">Go Back</button></a>
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
        document.getElementById("department_id").focus(); 
    } 
</script> 
<script type="text/javascript">
    function showGroup() {
        document.getElementById("input").style.display = "inline-block";
    }

    function hideGroup() {
        document.getElementById("input").style.display = "none";
    }
</script>