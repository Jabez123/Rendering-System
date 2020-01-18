<?php 
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "rendering_db";

	$conn = mysqli_connect($server, $username, $password, $database);

	if (!$conn) {
		die("Connection Error: " . mysqli_error($conn));
	}
 ?>