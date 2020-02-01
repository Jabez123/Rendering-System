<?php 
	// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");


$trainee_id = $_REQUEST['id'];
$user_id = $_REQUEST['user_id'];

// Prepare an update statement
        $sql_user = "DELETE FROM users_tb WHERE user_id = $user_id";
        $sql_trainee = "DELETE FROM trainee_tb WHERE trainee_id = $trainee_id";

        $conn->autocommit(FALSE);
        $conn->query($sql_trainee) or die("Error Trainee: " . mysqli_error($conn));
        $conn->query($sql_user) or die("Error User: " . mysqli_error($conn));

        $conn->commit();
        $conn->close();

        header("Location: trainee.php");
 ?>