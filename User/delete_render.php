<?php 
	// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");


$render_id = $_REQUEST['id'];

echo "From request: " . $render_id;

// Prepare an update statement
        
        $sql = "DELETE FROM render_tb WHERE render_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $render_id);
            
            // Set parameters
            $render_id = $render_id;

            echo "From parameter: " . $render_id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: render.php");
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