<?php 
	// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");


$type_id = $_REQUEST['id'];

// Prepare an update statement
        
        $sql = "DELETE FROM type_tb WHERE type_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $type_id);
            
            // Set parameters
            $type_id = $type_id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: type.php");
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