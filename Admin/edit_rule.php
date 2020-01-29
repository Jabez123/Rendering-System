<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");

$previous_rule_id = $_REQUEST['id'];
$type_name = $_REQUEST['type_name'];

$sql_rules = "SELECT 
	rules_tb.rule_id, department_tb.department_id, department_tb.department_name, 
	rules_tb.offense_code, rules_tb.offense_type, 
	rules_tb.offense_description FROM rules_tb INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id
	WHERE rule_id = $previous_rule_id";

$result_rules = mysqli_query($conn, $sql_rules);

$sql_selected_department = "SELECT 
	department_tb.department_id FROM rules_tb INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id
	WHERE rule_id = $previous_rule_id";

$result_selected_department = mysqli_query($conn, $sql_selected_department);

while ($row = mysqli_fetch_assoc($result_selected_department)) {
	$selected_department_id = $row['department_id'];
}

$sql = "SELECT * FROM department_tb WHERE department_id <> $selected_department_id";

$result = mysqli_query($conn, $sql);
 
// Define variables and initialize with empty values
$department_id = $offense_code = $offense_type = $offense_description = "";

$department_id_error = $offense_code_error = $offense_type_error = $offense_description_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$offense_type = $_POST['type_name'];

	// Validate department name
    if(empty(trim($_POST["department_id"]))){
        $department_id_error = "Please enter a department name.";
    }
 
    // Validate offense code
    if(empty(trim($_POST["offense_code"]))){
        $offense_code_error = "Please enter a offense code.";
    }

    // Validate offense type
    if(empty(trim($_POST["type_name"]))){
        $offense_type_error = "Please enter a offense type.";
    } 

    // Validate offense description
    if(empty(trim($_POST["offense_description"]))){
        $offense_description_error = "Please enter a offense description.";
    }

    $sql_offense = "SELECT offense_type FROM rules_tb WHERE offense_type = '$offense_type'";

    $result_offense = mysqli_query($conn, $sql_offense);
    while ($row = mysqli_fetch_assoc($result_offense)) {
    	$offense_type = $row['offense_type'];
    }
    
    // Check input errors before inserting in database
    if(empty($department_id_error) && empty($offense_code_error) && empty($offense_type_error) && empty($offense_description_error)) {
        
        // Prepare an insert statement
        $sql = "UPDATE rules_tb SET
    	department_id = ?, offense_code = ?, offense_type = ?, offense_description = ? WHERE rule_id = ?";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssi", 
            	$param_department_id, $param_offense_code, $param_offense_type, $param_description, $param_rule_id);
            
            // Set parameters
            $param_rule_id = $previous_rule_id;
            $param_department_id = trim($_POST["department_id"]);
            $param_offense_code = trim(strtoupper($_POST["offense_code"]));
            $param_offense_type = $offense_type;
            $param_description = trim($_POST["offense_description"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: rules.php");
            }

            else{
                echo "Something went wrong. Please try again later.";
                echo "Update Error: " . mysqli_error($conn);
            }
            // Close statement
        mysqli_stmt_close($stmt);
        }
        else {
        	echo "Update Error: " . mysqli_error($conn);
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
			<div class="col-md-3 col-lg-2"></div>

			<div class="col-sm-12 col-md-6 col-lg-8">
				<div class="card">
					<div class="card-header h1 text-center">
						Edit Rule
					</div>
					<div class="card-body">
						<form action="" method="post">
						<div class="row">
							<?php 
								while($row = mysqli_fetch_assoc($result_rules)) {
									$department_id = $row['department_id'];
									$department_name = $row['department_name'];
									$offense_code = $row['offense_code'];
									$offense_type = $row['offense_type'];
									$offense_description = $row['offense_description'];
							 ?>
							<div class="col-md-12">
								<div class="md-form form-group mt-5 <?php echo (!empty($department_id_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="department_id">Department Name</p>
									<select name="department_id" id="department_id" class="selectpicker" data-live-search="true" data-width="99%">
										<option value="<?php echo $department_id ?>" selected>Current: <?php echo $department_name; ?></option>
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
									<input class="form-control" type="text" name="offense_code" id="offense_code" value="<?php echo $offense_code ?>">
									<label for="offense_code">Offense Code</label>
									<span class="help-block text-danger"><?php echo $offense_code_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_type_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="type_name">Offense Type</p>
									<select name="type_name" id="type_name" class="selectpicker" data-live-search="true" data-width="99%">
										<option value="<?php echo $offense_type ?>">Current: <?php echo $offense_type ?></option>
									  	<?php if ($offense_type == "CONDUCT") { ?>
									  	<option value="MISCELLANEOUS">MISCELLANEOUS</option>
									  	<option value="GROUP">GROUP</option>
									  	<?php } else if ($offense_type == "MISCELLANEOUS") { ?>
									  		<option value="CONDUCT">CONDUCT</option>
									  		<option value="GROUP">GROUP</option>
									  	<?php } else if ($offense_type == "GROUP") { ?>
									  		<option value="CONDUCT">CONDUCT</option>
									  		<option value="MISCELLANEOUS">MISCELLANEOUS</option>
									  	<?php } else { ?>
									  		<option value="CONDUCT">CONDUCT</option>
									  		<option value="MISCELLANEOUS">MISCELLANEOUS</option>
									  		<option value="GROUP">GROUP</option>
									  	<?php } ?>
									</select>
									<p class="text-danger"><?php echo $offense_type_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_description_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_description" id="offense_description" value="<?php echo $offense_description ?>">
									<label for="offense_description">Description</label>
									<span class="help-block text-danger"><?php echo $offense_description_error; ?></span>
								</div>
							</div>
							<?php } ?>
							</div>
						</div>
							<div class="card-footer text-center">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<button type="submit" class="mt-3 btn btn-block btn-success">Save</button>
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

			<div class="col-md-3 col-lg-2"></div>
		</div>
	</div>
</main>
<?php include("footer.php") ?>
<script> 
    window.onload = function() { 
        document.getElementById("department_id").focus(); 
    } 
</script> 