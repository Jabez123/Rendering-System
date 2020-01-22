<?php
// Include configs
require_once("config/connectServer.php");
require_once("config/connectDatabase.php");
 
// Define variables and initialize with empty values
$department_name = $offense_code = $offense_type = $offense_description = "";
$is_grounded = $summaries = $words = $levitical_service = "";

$department_name_error = $offense_code_error = $offense_type_error = $offense_description_error = "";
$is_grounded_error = $summaries_error = $words_error = $levitical_service_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate department name
    if(empty(trim($_POST["department_name"]))){
        $department_name_error = "Please enter a department name.";
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

    // Validate summaries
    if(empty(trim($_POST["summaries"]))){
        $summaries_error = "Please enter a summaries.";
    }

	// Validate class words   
    if(empty(trim($_POST["words"]))){
        $words_error = "Please enter a words.";
    }

	// Validate levitical service
    if(empty(trim($_POST["levitical_service"]))){
        $levitical_service_error = "Please enter a levitical service.";
    }
    
    // Check input errors before inserting in database
    if(empty($department_name_error) && empty($offense_code_error) && empty($offense_type_error) && empty($offense_description_error) && 
	empty($is_grounded_error) && empty($summaries_error) && empty($words_error) && empty($levitical_service_error)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO rules_tb (
        department_name, offense_code, offense_type, offense_description, 
        is_grounded, summaries, words, levitical_service) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssiii", 
            	$param_department_name, $param_offense_code, $param_offense_type, $param_description, 
            	$param_is_grounded, $param_summaries, $param_words, 
            	$param_levitical_service, $param_team, $param_status);
            
            // Set parameters
            $param_department_name = trim($_POST["department_name"]);
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
                echo "Error: " . mysqli_error($conn);
            }
            // Close statement
        mysqli_stmt_close($stmt);
        }

        
    }
    
    // Close connection
    mysqli_close($conn);
}

	$sql = "SELECT 
	department_tb.department_id, department_tb.department_name FROM rules_tb INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id";

	$result = mysqli_query($conn, $sql);
?>


<?php include("header.php") ?>

<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-sm-12 col-md-10 col-lg-12">
				<div class="card">
					<div class="card-header h1 text-center">
						Add Rule
					</div>
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="row">
							<div class="col-md-6">
								<div class="md-form form-group mt-5 <?php echo (!empty($department_name_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="department_name">Department Name</p>
									<select name="department_name" id="department_name" class="browser-default custom-select">
										<option selected>Select Department Name</option>
										<?php while($row = mysqli_fetch_assoc($result)) {
											$department_id = $row['department_id'];
											$department_name = $row['department_name'];
										 ?>
										<option value="<?php echo $department_id ?>"><?php echo $department_name; ?></option>
									<?php } ?>
									</select>
										
									<p class="text-danger"><?php echo $department_name_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_code_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_code" id="offense_code">
									<label for="offense_code">Offense Code</label>
									<span class="help-block text-danger"><?php echo $offense_code_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_type_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_type" id="offense_type">
									<label for="offense_type">Offense Type</label>
									<span class="help-block text-danger"><?php echo $offense_type_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_description)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="offense_description" id="offense_description">
									<label for="offense_description">Description</label>
									<span class="help-block text-danger"><?php echo $offense_description_error; ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="md-form form-group <?php echo (!empty($is_grounded)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="is_grounded">Grounded</p>
									<input type="hidden" name="is_grounded" value="">
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 20px;">
									  <input type="radio" class="custom-control-input" id="yes" name="is_grounded" value="Yes">
									  <label class="custom-control-label" for="yes">Yes</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 50px;">
									   <input type="radio" class="custom-control-input" id="no" name="is_grounded" value="No">
									  <label class="custom-control-label" for="no">No</label>
									</div>
									<p class="text-danger"><?php echo $is_grounded_error; ?></p>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($summaries_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="number" name="summaries" id="summaries" min=0>
									<label for="summaries">Summaries</label>
									<span class="help-block text-danger"><?php echo $summaries_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($words_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="number" name="words" id="words" min=0>
									<label for="words">Words</label>
									<span class="help-block text-danger"><?php echo $words_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($levitical_service_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="number" name="levitical_service" id="levitical_service" min=0>
									<label for="levitical_service">Levitical Service</label>
									<span class="help-block text-danger"><?php echo $levitical_service_error; ?></span>
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

			<div class="col-md-1"></div>
		</div>
	</div>
</main>

<?php include("footer.php") ?>