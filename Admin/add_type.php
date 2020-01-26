<?php
// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");
 
// Define variables and initialize with empty values
$type_id = $type_name = $offense = "";

$type_id_error = $type_name_error = $offense_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validate offense code
    if(empty(trim($_POST["type_name"]))){
        $type_name_error = "Please enter a type name.";
    }
    else {
    	// Prepare a select statement
        $sql = "SELECT type_name FROM type_tb WHERE type_name = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_type_name);
            
            // Set parameters
            $param_type_name = trim($_POST["type_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $type_name_error = "This type name is already taken.";
                } else{
                    $type_name = trim($_POST["type_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
        	mysqli_stmt_close($stmt);
        }
    }

    // Validate offense type
    if(empty(trim($_POST["offense"]))){
        $offense_error = "Please enter a offense.";
    } 
    
    // Check input errors before inserting in database
    if(empty($type_id_error) && empty($type_name_error) && empty($offense_error)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO type_tb (
        type_name, offense) 
        VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", 
            	$param_type_name, $param_offense);
            
            // Set parameters
            $param_type_name = trim($_POST["type_name"]);
            $param_offense = trim($_POST["offense"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: type.php");
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


<?php include("header.php") ?>

<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-lg-2"></div>

			<div class="col-sm-12 col-md-8 col-lg-8">
				<div class="card">
					<div class="card-header h1 text-center">
						Add Type
					</div>
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="row">
							<div class="col-md-12">
								<div class="md-form form-group mt-5 <?php echo (!empty($type_name_error)) ? 'has-error' : ''; ?>">
									<input class="form-control" type="text" name="type_name" id="type_name">
									<label for="type_name">Type Name</label>
									<span class="help-block text-danger"><?php echo $type_name_error; ?></span>
								</div>
								<div class="md-form form-group mt-5 <?php echo (!empty($offense_error)) ? 'has-error' : ''; ?>">
									<p class="text-black-50" for="offense">Offense</p>
									<input type="hidden" name="offense" value="">
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 20px;">
									  <input type="radio" class="custom-control-input" id="CONDUCT" name="offense" value="CONDUCT">
									  <label class="custom-control-label" for="CONDUCT">CONDUCT</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline" style="margin-left: 90px;">
									   <input type="radio" class="custom-control-input" id="MISCELLANEOUS" name="offense" value="MISCELLANEOUS">
									  <label class="custom-control-label" for="MISCELLANEOUS">MISCELLANEOUS</label>
									</div>
									<p class="mt-1 text-danger"><?php echo $offense_error; ?></p>
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
										<a href="type.php"><button type="button" class="mt-3 btn btn-block btn-secondary">Go Back</button></a>
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