<?php 
	// Include configs
require_once("config/connectServer.php");
require_once("config/connectDatabase.php");


$trainee_id = $_REQUEST['id'];

echo "From request: " . $trainee_id;

// Prepare an update statement
        
        $sql = "DELETE FROM trainee_tb WHERE trainee_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $trainee_id);
            
            // Set parameters
            $trainee_id = $trainee_id;

            echo "From parameter: " . $trainee_id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: trainee.php");
            } 

            else{
                echo "Something went wrong. Please try again later.";
                echo "Deleting Error: " . mysqli_error($conn);
            }
            // Close statement
        mysqli_stmt_close($stmt);
        }
    
    // Close connection
    mysqli_close($conn);
 ?>