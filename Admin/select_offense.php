<?php include("header.php"); ?>

<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");
	$department_id = $_REQUEST['id'];
 ?>

 <?php 
 	// Define variables and initialize with empty values
	$rule_id = $week = $current_week = "";

	$rule_id_error = $week_error = "";
  ?>

<?php 
	// SELECT INPUTS
	$sql_rule = "SELECT * FROM rules_tb WHERE department_id = $department_id";

	$result_rule = mysqli_query($conn, $sql_rule);
 ?>

<?php 
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$rule_id = trim($_POST['rule_id']);
		$week = trim($_POST['week']);

		echo $rule_id;

		if (empty($week)) {
			$week_error = "Please enter a week.";
		}

		if (empty($rule_id)) {
			$rule_id_error = "Please select a rule";
		}

		// Check input errors before inserting in database
	    if(empty($render_id_error) && empty($rule_id_error) &&
		empty($week_error)) {

			$sql_offense_type = "SELECT * FROM rules_tb WHERE rule_id = $rule_id";

			$result_offense_type = mysqli_query($conn, $sql_offense_type);

			while ($row = mysqli_fetch_assoc($result_offense_type)) {
				$rule_id = $row['rule_id'];
				$selected_offense_type = $row['offense_type'];
				$offense_code = $row['offense_code'];
			}

			$sql_week = "SELECT * FROM week_tb WHERE week_num = $week";

			$result_week = mysqli_query($conn, $sql_week);

			while ($row = mysqli_fetch_assoc($result_week)) {
				$week_id = $row['week_id'];
				$current_week = $row['week_num'];
			}

	    	if ($week != $current_week) {
	    		$conn->autocommit(FALSE);
		    	$conn->query("INSERT INTO week_tb (week_num) VALUES ($week)");
		    	$conn->commit();
		    	$conn->close();
	    	}
	    	else {
	    		$conn->autocommit(FALSE);
		    	$conn->query("UPDATE week_tb SET week_num = $week WHERE week_id = $week_id");
		    	$conn->commit();
		    	$conn->close();
	    	}

	    	if ($selected_offense_type == "CONDUCT" || $selected_offense_type == "MISCELLANEOUS") {
	    		header("Location: select_trainee.php?r_id=$rule_id&offense_code=$offense_code&d_id=$department_id&w_id=$week_id");
	    	}

		}
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
					<form action="" method="post">
						<div class="card-header">
							<h1 class="display-4 text-center">Make Render</h1>
						</div>
						<div class="card-body">
							<div class="md-form form-group mt-5 <?php echo (!empty($week_error)) ? 'has-error' : ''; ?>">
								<input class="form-control" type="number" name="week" id="week">
								<label for="week">Week</label>
								<span class="help-block text-danger"><?php echo $week_error; ?></span>
							</div>
							<div class="md-form form-group mt-5 <?php echo (!empty($rule_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="rule_id">Offense Code</p>
								<select name="rule_id" id="rule_id" class="selectpicker" data-live-search="true" data-width="99%" onchange="">
								  	<option value=" " selected>Select Offense</option>
								  	<?php while($row = mysqli_fetch_assoc($result_rule)) { 
								  		$rule_id = $row['rule_id'];
								  		$offense_code = $row['offense_code'];
								  		$offense_type = $row['offense_type'];
								  		$offense_description = $row['offense_description'];
								  	?>
								  	<option value="<?php echo $rule_id ?>"><?php echo $offense_code; ?>: <?php echo $offense_type; ?> - <?php echo $offense_description; ?></option>
								  	<?php } ?>
								</select>
								<p class="text-danger"><?php echo $rule_id_error; ?></p>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-4">
									<button type="submit" class="btn btn-block btn-primary">Submit</button>
								</div>
								<div class="col-sm-12 col-md-4"></div>
								<div class="col-md-4">
									<a href="select_department.php"><button type="button" class="btn btn-block btn-secondary">Go Back</button></a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
</main>

<?php include("footer.php"); ?>
<script> 
    window.onload = function() { 
        document.getElementById("week").focus(); 
    } 
</script>

</body>
</html>