<?php include("header.php"); ?>

<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");
	$department_id = $_SESSION['id'];
 ?>

 <?php 
 	// Define variables and initialize with empty values
	$render_id = $rule_id = $trainee_id = "";

	$render_id_error = $rule_id_error = $trainee_id_error = $department_id_error = "";
  ?>

<?php 
	$sql_trainee = "SELECT * FROM trainee_tb";

	$result_trainee = mysqli_query($conn, $sql_trainee);

	$sql_rule = "SELECT * FROM rules_tb WHERE department_id = $department_id";

	$result_rule = mysqli_query($conn, $sql_rule);
 ?>

<?php 
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$trainee_id = trim($_POST['trainee_id']);
		$rule_id = trim($_POST['rule_id']);

		// Check input errors before inserting in database
	    if(empty($trainee_id_error) && empty($render_id_error) && empty($rule_id_error)) {
	        
	        // Prepare an insert statement
	        $sql = "INSERT INTO render_tb (
	        trainee_id, department_id, rule_id) 
	        VALUES (?, ?, ?)";
	         
	        if($stmt = mysqli_prepare($conn, $sql)) {
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "iii", 
            	$param_trainee_id, $param_department_id, $param_rule_id);
	            
	            // Set parameters
	            $param_trainee_id = trim($_POST["trainee_id"]);
	            $param_department_id = $department_id;
	            $param_rule_id = trim($_POST["rule_id"]);
	            
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
	    // Close connection
	    mysqli_close($conn);

	}
?>

<main class="mt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Home</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<div class="container-fluid mt-5">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-sm-12 col-md-12 col-lg-8">
				<div class="card">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="card-header">
							<h1 class="display-4 text-center">Make Render</h1>
						</div>
						<div class="card-body">
							<div class="md-form form-group <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="trainee_id">Trainee</p>
								<select name="trainee_id" id="trainee_id" class="selectpicker" data-live-search="true" data-width="99%">
								  	<option selected>Select Trainee</option>
								  	<?php while($row = mysqli_fetch_assoc($result_trainee)) { 
								  		$trainee_id = $row['trainee_id'];
								  		$first_name = $row['first_name'];
								  		$last_name = $row['last_name'];
								  	?>
								  	<option value="<?php echo $trainee_id ?>"><?php echo $last_name; ?>, <?php echo $first_name ?></option>
								  	<?php } ?>
								</select>
								<p class="text-danger"><?php echo $trainee_id_error; ?></p>
							</div>

							<div class="md-form form-group mt-5 <?php echo (!empty($rule_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="rule_id">Offense Code</p>
								<select name="rule_id" id="rule_id" class="selectpicker" data-live-search="true" data-width="99%">
								  	<option selected>Select Offense</option>
								  	<?php while($row = mysqli_fetch_assoc($result_rule)) { 
								  		$rule_id = $row['rule_id'];
								  		$offense_code = $row['offense_code'];
								  		$offense_type = $row['offense_type'];
								  		$offense_description = $row['offense_description'];
								  	?>
								  	<option value="<?php echo $rule_id ?>"><?php echo $offense_code; ?> - <?php echo $offense_description; ?>: <?php echo $offense_type; ?></option>
								  	<?php } ?>
								</select>
								<p class="text-danger"><?php echo $rule_id_error; ?></p>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-block btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
</main>

<?php include("footer.php"); ?>

</body>
</html>