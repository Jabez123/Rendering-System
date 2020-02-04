<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT * FROM department_tb";


	$result = mysqli_query($conn, $sql);
 ?>

<?php 
	$department_id = "";
	$department_id_error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty(trim($department_id))) {
		$department_name_error = "Please select a department.";
	}

		if (empty($department_id_error)) {
			$department_id = $_POST['department_id'];

			header("Location: select_offense.php?id=$department_id");
		}
	}
 ?>

<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Render</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container-fluid">
	<main class="mt-5 mb-5">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="card mb-5 mt-5">
						<div class="card-header">
							<h1 class="text-center">Select Department</h1>
						</div>
						<div class="card-body">
							<div class="md-form form-group mt-5 <?php echo (!empty($department_id_error)) ? 'has-error' : ''; ?>">
								<select name="department_id" id="department_id" class="selectpicker" data-live-search="true" data-width="99%" onchange="copyText(event)">
								  <option value=" " selected>Select Department</option>
								  <?php while ($row = mysqli_fetch_assoc($result)) {
								  		$department_name = $row['department_name'];
								  		$department_id = $row['department_id'];
								  ?>
								  <option value="<?php echo $department_id ?>"><?php echo $department_name ?></option>
								<?php } ?>
								</select>
								<p class="text-danger"><?php echo $department_id_error; ?></p>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-4">
									<button type="submit" class="btn btn-block btn-primary">Submit</button>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<a href="render.php"><button type="button" class="btn btn-block btn-secondary">Go Back</button></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</main>
</div>

<?php include("footer.php"); ?>
<script> 
    window.onload = function() { 
        document.getElementById("department_id").focus(); 
    } 
</script>
</body>
</html>