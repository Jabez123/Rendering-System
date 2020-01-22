<?php
// Include configs
require_once("config/connectServer.php");
require_once("config/connectDatabase.php");
 
// Define variables and initialize with empty values
$selected_department_name = "None";
$selected_offense_code = "None";
$selected_trainee = "None";

$trainee_id = $rule_id = $department_id = "";
$offense_code = $offense_type = $offense_description = "";
$is_grounded = $summaries = $words = $levitical_service = "";

$trainee_id_error = $rule_id_error = $department_id_error = "";
$offense_code_error = $offense_type_error = $offense_description_error = "";
$is_grounded_error = $summaries_error = $words_error = $levitical_service_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$selected_department_name = trim($_POST["department_id"]);
	$selected_offense_code = trim($_POST["offense_code"]);
	$selected_trainee = trim($_POST["trainee_id"]);


	if ($selected_department_name != "None" && $selected_offense_code != "None" && $selected_trainee != "None") {

	    
	    // Check input errors before inserting in database
	    if(empty($trainee_id_error) && empty($offense_code_error) && empty($department_id_error)) {
	        // Prepare an insert statement
	        $sql = "INSERT INTO render_tb (
	        trainee_id, rule_id)
	        VALUES (?, ?)";
	         
	        if($stmt = mysqli_prepare($conn, $sql)) {
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "ii", 
	            	$param_trainee_id, $param_rule_id);
	            
	            // Set parameters
	            $param_trainee_id = trim($_POST['trainee_id']);
	            $param_rule_id = trim($_POST['rule_id']);
	            
	            // Attempt to execute the prepared statement
	            if(mysqli_stmt_execute($stmt)){
	                // Redirect to login page
	                header("location: render.php");
	            } 

	            else{
	                echo "Something went wrong. Please try again later.";
	                echo "Error: " . mysqli_error($conn);
	            }
	            // Close statement
	        mysqli_stmt_close($stmt);
	        }
	    }
	}
	
}
	
	// TRAINEE
	$sql_trainee = "SELECT * FROM trainee_tb";

	$result_trainee = mysqli_query($conn, $sql_trainee);

	// SELECTED TRAINEE
	$sql_selected_trainee = "SELECT * FROM trainee_tb WHERE trainee_id = $selected_trainee";

	$result_selected_trainee = mysqli_query($conn, $sql_selected_trainee);

	// DEPARTMENT
	$sql_department = "SELECT DISTINCT
	department_tb.department_id, department_tb.department_name
	FROM rules_tb 
	INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id";

	$result_department = mysqli_query($conn, $sql_department);

	// SELECTED DEPARTMENT
	$sql_selected_department = "SELECT 
	department_tb.department_id, department_tb.department_name
	FROM rules_tb
	INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id
    WHERE rules_tb.department_id = $selected_department_name";

	$result_selected_department = mysqli_query($conn, $sql_selected_department);

	// RULE
	$sql_rules = "SELECT
	rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_description, rules_tb.is_grounded,
	rules_tb.summaries, rules_tb.words, rules_tb.levitical_service
	FROM rules_tb
	INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id
	WHERE rules_tb.department_id = $selected_department_name";

	$result_rules = mysqli_query($conn, $sql_rules);

	// SELECTED RULE
	$sql_selected_rules = "SELECT
	rules_tb.rule_id, rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_description, rules_tb.is_grounded,
	rules_tb.summaries, rules_tb.words, rules_tb.levitical_service
	FROM rules_tb
	INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id
	WHERE rules_tb.offense_code = '$selected_offense_code'";

	$result_selected_rules = mysqli_query($conn, $sql_selected_rules);
?>


<?php include("header.php") ?>

<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-sm-12 col-md-10 col-lg-12">
				<div class="card">
					<div class="card-header h1 text-center">
						Add Render
					</div>
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="row">
							<?php if ($selected_department_name == "None") { ?>
								<div class="col-md-12">
									<div class="md-form form-group mt-5 <?php echo (!empty($department_id_error)) ? 'has-error' : ''; ?>">
										<p class="text-black-50" for="department_id">Department</p>
										<select name="department_id" id="department_id" class="browser-default custom-select">
											<option value="None" selected>Select Department</option>
											
											<?php while($row = mysqli_fetch_assoc($result_department)) {
												$department_id = $row['department_id'];
												$department_name = $row['department_name'];
											 ?>
											<option value="<?php echo $department_id ?>"><?php echo $department_name; ?></option>
										<?php } ?>
										</select>
											<input type="hidden" name="trainee_id" value="None">
											<input type="hidden" name="offense_code" value="None">
										<p class="text-danger"><?php echo $department_id_error; ?></p>
										<div class="text-center">
											<button class="btn btn-primary">Save</button>
										</div>
									</div>
								</div>
								
							<?php } else { ?>
								<div class="col-2"></div>
								<div class="col-8">
									<div class="md-form form-group mt-5 <?php echo (!empty($department_id_error)) ? 'has-error' : ''; ?>">
										<p class="text-black-50" for="department_id">Department</p>
										<select name="department_id" id="department_id" class="browser-default custom-select">
											<option value="None">Select Department</option>
											<?php while($row = mysqli_fetch_assoc($result_selected_department)) {
												$department_id = $row['department_id'];
												$department_name = $row['department_name'];
											 ?>
											 <option value="<?php echo $department_id ?>" selected><?php echo $department_name; ?></option>
										<?php } ?>
										</select>
											
										<p class="text-danger"><?php echo $department_id_error; ?></p>

										<div class="text-center">
											<button class="btn btn-primary">Save</button>
										</div>
									</div>

									<?php if ($selected_trainee == "None") { ?>
										<div class="md-form form-group mt-5 <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
											<p class="text-black-50" for="trainee_id">Trainee</p>
											<select name="trainee_id" id="trainee_id" class="browser-default custom-select">
												<option value="None" selected>Select Trainee</option>
												<?php while($row = mysqli_fetch_assoc($result_trainee)) {
													$trainee_id = $row['trainee_id'];
													$first_name = $row['first_name'];
													$last_name = $row['last_name'];
												 ?>
												<option value="<?php echo $trainee_id ?>"><?php echo $last_name; ?>, <?php echo $first_name; ?></option>
											<?php } ?>
											</select>
												
											<p class="text-danger"><?php echo $trainee_id_error; ?></p>
										</div>
									<?php } 

									else { ?>
										<div class="md-form form-group mt-5 <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
											<p class="text-black-50" for="trainee_id">Trainee</p>
											<select name="trainee_id" id="trainee_id" class="browser-default custom-select">
												<option value="None" selected>Select Trainee</option>
												<?php while($row = mysqli_fetch_assoc($result_selected_trainee)) {
													$trainee_id = $row['trainee_id'];
													$first_name = $row['first_name'];
													$last_name = $row['last_name'];
												 ?>
												<option value="<?php echo $trainee_id ?>" selected><?php echo $last_name; ?>, <?php echo $first_name; ?></option>
											<?php } ?>
											</select>
												
											<p class="text-danger"><?php echo $trainee_id_error; ?></p>
										</div>
									<?php } ?>

									<?php if ($selected_offense_code == "None") { ?>
										<div class="md-form form-group mt-5 <?php echo (!empty($offense_code_error)) ? 'has-error' : ''; ?>">
											<p class="text-black-50" for="rule_id">Offense Code</p>
											<select name="rule_id" id="rule_id" class="browser-default custom-select">
												<option value="None" selected>Select Offense Code</option>
												<?php while($row = mysqli_fetch_assoc($result_rules)) {
													$offense_code = $row['offense_code'];
													$offense_type = $row['offense_type'];
												 ?>
												<option value="<?php echo $rule_id ?>">Code: <?php echo $offense_code; ?> Type: <?php echo $offense_type; ?></option>
											<?php } ?>
											</select>
												
											<p class="text-danger"><?php echo $offense_code_error; ?></p>
											<div class="text-center">
												<button class="btn btn-primary">Save</button>
											</div>
										</div>
									<?php } 

									else { ?>
										<div class="md-form form-group mt-5 <?php echo (!empty($offense_code_error)) ? 'has-error' : ''; ?>">
											<p class="text-black-50" for="offense_code">Offense Code</p>
											<select name="rule_id" id="rule_id" class="browser-default custom-select">
												<option value="None">Select Offense Code</option>
												<?php while($row = mysqli_fetch_assoc($result_selected_rules)) {
													$rule_id = $row['rule_id'];
													$offense_code = $row['offense_code'];
													$offense_type = $row['offense_type'];
													$offense_description = $row['offense_description'];
													$is_grounded = $row['is_grounded'];
													$summaries = $row['summaries'];
													$words = $row['words'];
													$levitical_service = $row['levitical_service'];
												 ?>
												<option value="<?php echo $rule_id ?>" selected>Code: <?php echo $offense_code; ?> Type: <?php echo $offense_type; ?></option>
											</select>
												
											<p class="text-danger"><?php echo $offense_code_error; ?></p>
											<div class="text-center">
												<button class="btn btn-primary">Save</button>
											</div>
										</div>
											<div class="card">
												<div class="card-header text-center">Render Summary</div>
												<div class="card-body">
													<div class="md-form form-group mt-5 <?php echo (!empty($offense_description_error)) ? 'has-error' : ''; ?>">
														<input class="form-control" type="text" name="offense_description" id="offense_description" 
														value="<?php echo $offense_description; ?>" disabled>
														<label for="offense_description">Offense Description</label>
														<span class="help-block text-danger"><?php echo $offense_description_error; ?></span>
													</div>
													<div class="md-form form-group mt-5 <?php echo (!empty($summaries_error)) ? 'has-error' : ''; ?>">
														<input class="form-control" type="number" name="summaries" id="summaries" 
														value="<?php echo $summaries; ?>" disabled>
														<label for="summaries">Summary</label>
														<span class="help-block text-danger"><?php echo $summaries_error; ?></span>
													</div>
													<div class="md-form form-group mt-5 <?php echo (!empty($words_error)) ? 'has-error' : ''; ?>">
														<input class="form-control" type="number" name="words" id="words" 
														value="<?php echo $words; ?>" disabled>
														<label for="words">Words</label>
														<span class="help-block text-danger"><?php echo $words_error; ?></span>
													</div>
													<div class="md-form form-group mt-5 <?php echo (!empty($levitical_service_error)) ? 'has-error' : ''; ?>">
														<input class="form-control" type="number" name="levitical_service" id="levitical_service" 
														value="<?php echo $levitical_service; ?>" disabled>
														<label for="levitical_service">Levitical Service</label>
														<span class="help-block text-danger"><?php echo $levitical_service_error; ?></span>
													</div>
													<div class="md-form form-group <?php echo (!empty($is_grounded)) ? 'has-error' : ''; ?>">
														<p class="text-black-50" for="is_grounded">Grounded</p>
														<?php if ($is_grounded == "Yes") { ?>
															<input type="hidden" name="is_grounded" value="">
															<div class="custom-control custom-radio custom-control-inline" style="margin-left: 20px;">
															  <input type="radio" class="custom-control-input" id="yes" name="is_grounded" value="Yes" checked disabled>
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
															   <input type="radio" class="custom-control-input" id="no" name="is_grounded" value="No" checked disabled>
															  <label class="custom-control-label" for="no">No</label>
															</div>
														<?php } ?>
														<p class="text-danger"><?php echo $is_grounded_error; ?></p>
													</div>
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<div class="card-footer text-center">
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<button type="submit" class="mt-3 btn btn-block btn-primary">Finalize</button>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-4">
									</div>
									<div class="col-md-4 col-lg-4">
										<a href="render.php"><button type="button" class="mt-3 btn btn-block btn-secondary">Go Back</button></a>
									</div>
								</div>
							</div>
							<div class="col-2"></div>
						<?php } ?>
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