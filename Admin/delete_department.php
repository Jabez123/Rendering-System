<?php 
	// Include configs
require_once("../config/connectServer.php");
require_once("../config/connectDatabase.php");


$department_id = $_REQUEST['id'];
$user_id = $_REQUEST['user_id'];

    $conn->autocommit(FALSE);

    $sql_user = "DELETE FROM users_tb WHERE user_id = $user_id";
    $sql_department = "DELETE FROM department_tb WHERE department_id = $department_id";

    $conn->query($sql_department) or die("Error Department: " . mysqli_error($conn));
    $conn->query($sql_user) or die("Error User: " . mysqli_error($conn));
    $conn->commit();
    $conn->close();

    header("Location: department.php");
 ?>