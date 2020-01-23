<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");

$previous_rule_id = $_REQUEST['id'];

$sql_rules = "SELECT 
	rules_tb.rule_id, department_tb.department_id, department_tb.department_name, 
	rules_tb.offense_code, rules_tb.offense_type, 
	rules_tb.offense_description, rules_tb.is_grounded, 
	rules_tb.summaries, rules_tb.words, rules_tb.levitical_service FROM rules_tb INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id
	WHERE rule_id= $previous_rule_id";

$result_rules = mysqli_query($conn, $sql_rules);

$sql = "SELECT * FROM department_tb";

$result = mysqli_query($conn, $sql);
 
// Define variables and initialize with empty values
$department_id = $offense_code = $offense_type = $offense_description = "";
$is_grounded = $summaries = $words = $levitical_service = "";

$department_id_error = $offense_code_error = $offense_type_error = $offense_description_error = "";
$is_grounded_error = $summaries_error = $words_error = $levitical_service_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate department name
    if(empty(trim($_POST["department_id"]))){
        $department_id_error = "Please enter a department name.";
    }
 
    // Validate offense code
    if(empty(trim($_POST["offense_code"]))){
        $offense_code_error = "Please enter a offense code.";
    }

    // Validate offense type
    if(empty(trim($_POST["offense_type"]))){
        $offense_type_error = "Please enter a offense type.";
    } 

    // Validate offense description
    if(empty(trim($_POST["offense_description"]))){
        $offense_description_error = "Please enter a offense description.";
    }

    // Validate is grounded
    if(empty(trim($_POST["is_grounded"]))){
        $is_grounded_error = "Please enter is grounded.";
    }

 //    // Validate summaries
 //    if(empty(trim($_POST["summaries"]))){
 //        $summaries_error = "Please enter a summaries.";
 //    }

	// // Validate class words   
 //    if(empty(trim($_POST["words"]))){
 //        $words_error = "Please enter a words.";
 //    }

	// // Validate levitical service
 //    if(empty(trim($_POST["levitical_service"]))){
 //        $levitical_service_error = "Please enter a levitical service.";
 //    }
    
    // Check input errors before inserting in database
    if(empty($department_id_error) && empty($offense_code_error) && empty($offense_type_error) && empty($offense_description_error) && 
	empty($is_grounded_error) && empty($summaries_error) && empty($words_error) && empty($levitical_service_error)) {
        
        // Prepare an insert statement
        $sql = "UPDATE rules_tb SET
    	department_id = ?, offense_code = ?, offense_type = ?, offense_description = ?, 
        is_grounded = ?, summaries = ?, words = ?, 
        levitical_service = ? WHERE rule_id = ?";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issssiiii", 
            	$param_department_id, $param_offense_code, $param_offense_type, $param_description, 
            	$param_is_grounded, $param_summaries, $param_words, 
            	$param_levitical_service, $param_rule_id);
            
            // Set parameters
            $param_rule_id = $previous_rule_id;
            $param_department_id = trim($_POST["department_id"]);
            $param_offense_code = trim($_POST["offense_code"]);
            $param_offense_type = trim($_POST["offense_type"]);
            $param_description = trim($_POST["offense_description"]);
            $param_is_grounded = trim($_POST["is_grounded"]);
            $param_summaries = trim($_POST["summaries"]);
            $param_words = trim($_POST["words"]);
            $param_levitical_service = trim($_POST["levitical_service"]);
            
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
			<div class="col-md-1"></div>

			<div class="col-sm-12 col-md-10 col-lg-12">
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
									$is_grounded = $row['is_grounded'];
									$summaries = $row['summaries'];
									$words = $row['words'];
									$levitical_service = $row['levitical_service'];
							 ?>
							<div class="col-md-6">
								<div class="md-form form-group mt-5 <?php echo (!empty($department_id_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="department_id">Department Name</p>
									<select name="department_id" id="department_id" class="browser-default custom-select">
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
									<input class="form-control" type="text" name="offense_type" id="offense_type" value="<?php echo $offense_type ?>">
									<label for="offense_type">Offense Type</label>
									<span class="help-block text-danger"><?php echo $offense_type_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_description)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_description" id="offense_description" value="<?php echo $offense_description ?>">
									<label for="offense_description">Description</label>
									<span class="help-block text-danger"><?php echo $offense_description_error; ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="md-form form-group <?php echo (!empty($is_grounded)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="is_grounded">Grounded</p>
									<input type="hidden" name="is_grounded" value="">
									<?php if ($is_grounded == "Yes") { ?>
										<div class="custom-control custom-radio custom-control-inline" style="margin-left: 20px;">
										  <input type="radio" class="custom-control-input" id="yes" name="is_grounded" value="Yes" checked="">
										  <label class="custom-control-label" for="yes">Yes</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline" style="margin-left: 50px;">
										   <input type="radio" class="custom-control-input" id="no" name="is_grounded" value="No">
										  <label class="custom-control-label" for="no">No</label>
										</div>
									<?php } else { ?>
										<div class="custom-control custom-radio custom-control-inline" style="margin-left: 20px;">
										  <input type="radio" class="custom-control-input" id="yes" name="is_grounded" value="Yes">
										  <label class="custom-control-label" for="yes">Yes</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline" style="margin-left: 50px;">
										   <input type="radio" class="custom-control-input" id="no" name="is_grounded" value="No" checked="">
										  <label class="custom-control-label" for="no">No</label>
										</div>
									<?php } ?>
									<p class="text-danger"><?php echo $is_grounded_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($summaries_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="number" name="summaries" id="summaries" min=0 value="<?php echo $summaries ?>">
									<label for="summaries">Summaries</label>
									<span class="help-block text-danger"><?php echo $summaries_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($words_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="number" name="words" id="words" min=0 value="<?php echo $words ?>">
									<label for="words">Words</label>
									<span class="help-block text-danger"><?php echo $words_error; ?></span>
								</div>
							<?php } ?>
								<div class="md-form form-group mt-5 <?php echo (!empty($levitical_service_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="number" name="levitical_service" id="levitical_service" min=0 value="<?php echo $levitical_service ?>">
									<label for="levitical_service">Levitical Service</label>
									<span class="help-block text-danger"><?php echo $levitical_service_error; ?></span>
								</div>
							</div>
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

			<div class="col-md-1"></div>
		</div>
	</div>
</main>
<?php include("footer.php") ?>