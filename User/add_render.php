<?php include("header.php"); ?>

<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");
	$department_id = $_SESSION['id'];
 ?>

 <?php 
 	// Define variables and initialize with empty values
	$render_id = $rule_id = $trainee_id = "";

	$render_id_error = $rule_id_error = $trainee_id_error = $department_id_error = "";
  ?>

<?php 
	$sql_trainee = "SELECT * FROM trainee_tb";

	$result_trainee = mysqli_query($conn, $sql_trainee);

	$sql_rule = "SELECT * FROM rules_tb WHERE department_id = $department_id";

	$result_rule = mysqli_query($conn, $sql_rule);
 ?>

<?php 
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$trainee_id = trim($_POST['trainee_id']);
		$rule_id = trim($_POST['rule_id']);

		$sql_offense_type = "SELECT offense_type FROM rules_tb WHERE rule_id = $rule_id";

		$result_offense_type = mysqli_query($conn, $sql_offense_type);

		while ($row = mysqli_fetch_assoc($result_offense_type)) {
			$selected_offense_type = $row['offense_type'];
		}

		$sql_conduct = "SELECT COUNT(rules_tb.offense_type) FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = 'Conduct'";

		$result_conduct = mysqli_query($conn, $sql_conduct);

		while ($row = mysqli_fetch_assoc($result_conduct)) {
			$total_conduct = $row['COUNT(rules_tb.offense_type)'];
		}


		$sql_summaries = "SELECT SUM(summaries) FROM trainee_tb WHERE trainee_id = $trainee_id";

		$result_summaries = mysqli_query($conn, $sql_summaries);

		while ($row = mysqli_fetch_assoc($result_summaries)) {
			$total_summaries = $row['SUM(summaries)'];
		}

		$sql_words = "SELECT words FROM trainee_tb WHERE trainee_id = $trainee_id";

		$result_words = mysqli_query($conn, $sql_words);

		while ($row = mysqli_fetch_assoc($result_words)) {
			$total_words = $row['words'];
		}

		$sql_levitical_service = "SELECT SUM(levitical_service) FROM trainee_tb WHERE trainee_id = $trainee_id";

		$result_levitical_service = mysqli_query($conn, $sql_levitical_service);

		while ($row = mysqli_fetch_assoc($result_levitical_service)) {
			$total_levitical_service = $row['SUM(levitical_service)'];
		}

		// Check input errors before inserting in database
	    if(empty($trainee_id_error) && empty($render_id_error) && empty($rule_id_error)) {

	    	if ($selected_offense_type == "CONDUCT") {
	    		$total_conduct += 1;

	    		if ($total_conduct <= 4) {

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = 1, 
		    			is_grounded = 0, 
		    			words = $total_words + 125 
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}
	    		
	    		if ($total_conduct <= 7) {
	    			$total_summaries++;
	    			if ($total_summaries == 2) {
	    				$total_summaries = 2;
	    			}

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;

	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 9 && $total_words <= 875) {
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}
	    			
	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 1;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 11 && $total_words <= 875) {
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}

	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 2;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 13 && $total_words <= 875) {
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}

	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 3;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}
	    		
	    		if ($total_conduct <= 15 && $total_words <= 875) {
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}

	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 4;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 17 && $total_words <= 875) {
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}

	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 5;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 19 && $total_words <= 875) {
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}

	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 6;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words + 125,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct > 19 && $total_words <= 875) {
	    			$total_conduct = 20;
	    			if ($total_words >= 875) {
	    				$total_words = 625;
	    			}

	    			$total_summaries++;
	    			$levitical_service = 0;

	    			if ($total_summaries >= 3) {

	    				$total_summaries = 3;
	    				$levitical_service = 7;
	    			}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE trainee_tb SET 
		    			summaries = $total_summaries, 
		    			is_grounded = 1, 
		    			words = $total_words,
		    			levitical_service = $levitical_service
		    			WHERE trainee_id = $trainee_id");
		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id) VALUES ($trainee_id, $department_id, $rule_id)");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}
			}
	        
	    }
	    // Close connection
	    mysqli_close($conn);

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
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="card-header">
							<h1 class="display-4 text-center">Make Render</h1>
						</div>
						<div class="card-body">
							<div class="md-form form-group <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="trainee_id">Trainee</p>
								<select name="trainee_id" id="trainee_id" class="selectpicker" data-live-search="true" data-width="99%">
								  	<option selected>Select Trainee</option>
								  	<?php while($row = mysqli_fetch_assoc($result_trainee)) { 
								  		$trainee_id = $row['trainee_id'];
								  		$first_name = $row['first_name'];
								  		$last_name = $row['last_name'];
								  	?>
								  	<option value="<?php echo $trainee_id ?>"><?php echo $last_name; ?>, <?php echo $first_name ?></option>
								  	<?php } ?>
								</select>
								<p class="text-danger"><?php echo $trainee_id_error; ?></p>
							</div>

							<div class="md-form form-group mt-5 <?php echo (!empty($rule_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="rule_id">Offense Code</p>
								<select name="rule_id" id="rule_id" class="selectpicker" data-live-search="true" data-width="99%">
								  	<option selected>Select Offense</option>
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
							<button type="submit" class="btn btn-block btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
</main>

<?php include("footer.php"); ?>

</body>
</html>