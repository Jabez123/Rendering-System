<?php 
	// Starting session
	session_start();

	// Unset all the session variables
	$_SESSION = array();

	// Destroy the session
	session_destroy();

	// Redirect to login page
	header("location: ../index.php");
	exit;
 ?>