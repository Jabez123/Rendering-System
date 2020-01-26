<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values
$department_id = $offense_code = $offense_type = $offense = $offense_description = "";

$department_id_error = $offense_code_error = $type_name_error = $offense_description_error = "";

$sql_type = "SELECT * FROM type_tb";

$result_type = mysqli_query($conn, $sql_type);


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

    // Validate offense type
    if(empty(trim($_POST["type_name"]))){
        $type_name_error = "Please enter a offense type.";
    } 

    // Validate offense description
    if(empty(trim($_POST["offense_description"]))){
        $offense_description_error = "Please enter a offense description.";
    }

    $sql_offense = "SELECT offense FROM type_tb WHERE type_name = '$type_name'";

    $result_offense = mysqli_query($conn, $sql_offense);
    while ($row = mysqli_fetch_assoc($result_offense)) {
    	$offense = $row['offense'];
    }
    
    // Check input errors before inserting in database
    if(empty($department_id_error) && empty($offense_code_error) 
    	&& empty($type_name_error) && empty($offense_description_error)) {



        // Prepare an insert statement
        $sql = "INSERT INTO rules_tb (
        department_id, offense_code, offense_type, offense, offense_description) 
        VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issss", 
            	$param_department_id, $param_offense_code, $param_offense_type, $offense, $param_description);
            
            // Set parameters
            $param_department_id = trim($_POST["department_id"]);
            $param_offense_code = trim($_POST["offense_code"]);
            $param_offense_type = trim($_POST["type_name"]);
            $param_description = trim($_POST["offense_description"]);
            
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
									<select name="department_id" id="department_id" class="selectpicker" data-live-search="true" data-width="99%">
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
								<div class="md-form form-group mt-5 <?php echo (!empty($type_name_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="type_name">Offense Type</p>
									<select name="type_name" id="type_name" class="selectpicker" data-live-search="true" data-width="99%">
									  	<option value=" " selected>Select Offense Type</option>
									  	<?php while ($row = mysqli_fetch_assoc($result_type)) { 
									  		$type_name = $row['type_name'];
									  	?>
									  		<option value="<?php echo $type_name ?>"><?php echo $type_name ?></option>
									  	<?php } ?>
									</select>
									<p class="text-danger"><?php echo $type_name_error; ?></p>
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