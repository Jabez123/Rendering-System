<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");
	$rule_id = $_REQUEST['r_id'];
	$offense_code = $_REQUEST['offense_code'];
	$department_id = $_REQUEST['d_id'];
	$week_id = $_REQUEST['w_id'];

	$sql = "SELECT * FROM trainee_tb";

	$result = mysqli_query($conn, $sql);

	$sql_offense_type = "SELECT offense_type FROM rules_tb WHERE offense_code = '$offense_code'";

	$result_offense_type = mysqli_query($conn, $sql_offense_type);

	while ($row = mysqli_fetch_assoc($result_offense_type)) {
		$selected_offense_type = $row['offense_type'];
	}
 ?>

<?php 
	$trainee_id = $c_render_id = "";

	$trainee_id_error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$trainee_id = $_POST['trainee_id'];

		$sql_current_render = "SELECT COUNT(rules_tb.offense_type),
		current_render_tb.is_grounded, COUNT(current_render_tb.summaries), current_render_tb.words, current_render_tb.levitical_service 
		FROM current_render_tb INNER JOIN trainee_tb ON current_render_tb.trainee_id = trainee_tb.trainee_id 
		INNER JOIN department_tb ON current_render_tb.department_id = department_tb.department_id
		INNER JOIN rules_tb ON current_render_tb.rule_id = rules_tb.rule_id
		INNER JOIN week_tb ON current_render_tb.week_id = week_tb.week_id
        WHERE trainee_tb.trainee_id = '$trainee_id' AND department_tb.department_id = $department_id 
        AND week_tb.week_id = $week_id AND rules_tb.offense_type = '$selected_offense_type'";

        $result_current_render = mysqli_query($conn, $sql_current_render);

        while ($row = mysqli_fetch_assoc($result_current_render)) {
        	$num_offense_type = $row['COUNT(rules_tb.offense_type)'] + 1;
        	$is_grounded = $row['is_grounded'];
        	$summaries = $row['COUNT(current_render_tb.summaries)'];
        	$words = $row['words'];
        	$levitical_service = $row['levitical_service'];
        }
        echo $num_offense_type;

		if ($selected_offense_type == "CONDUCT" ) {

			// IF CONDUCT IS 4 BELOW INSERT TO PENDING
			if ($num_offense_type < 5) {

				$is_grounded = 0;
				$summaries = 0;
				$words = 0;
				$levitical_service = 0;

				// INSERT TO CURRENT RENDERS
				$sql_insert_current = "INSERT INTO current_render_tb
				(trainee_id, department_id, rule_id, week_id,
				is_grounded, summaries, words, levitical_service) VALUES
				('$trainee_id', $department_id, $rule_id, $week_id,
				$is_grounded, $summaries, $words, $levitical_service)";

				$conn->autocommit(FALSE);
				$conn->query($sql_insert_current) or die("Error Current: " . mysqli_error($conn));

				// INSERT TO PENDING RENDERS
				$sql_insert_pending = "INSERT INTO pending_render_tb(trainee_id, department_id, rule_id, week_id, render_num) 
				VALUES ('$trainee_id', $department_id, $rule_id, $week_id, $num_offense_type)";

				$sql_pending = "SELECT * FROM pending_render_tb WHERE trainee_id = '$trainee_id'";

				$result_pending = mysqli_query($conn, $sql_pending);
				
				$conn->query($sql_insert_pending) or die("Error Pending INSERT: " . mysqli_error($conn));

				$sql_update_pending = "UPDATE pending_render_tb SET render_num = $num_offense_type WHERE trainee_id = $trainee_id";
				$conn->query($sql_update_pending) or die("Error Pending UPDATE: " . mysqli_error($conn));
				
				$conn->commit();
				$conn->close();

				header("Location: render.php");
			}

			if ($num_offense_type == 5) {
				$is_grounded = 1;
				$summaries = 2;
				$words = 625;
				$levitical_service = 0;

				// INSERT TO CURRENT RENDERS
				$sql_insert_current = "INSERT INTO current_render_tb
				(trainee_id, department_id, rule_id, week_id,
				is_grounded, summaries, words, levitical_service) VALUES
				('$trainee_id', $department_id, $rule_id, $week_id,
				$is_grounded, $summaries, $words, $levitical_service)";

				$conn->autocommit(FALSE);
				$conn->query($sql_insert_current) or die("Error Current: " . mysqli_error($conn));

				$sql_pending = "SELECT * FROM pending_render_tb WHERE trainee_id = '$trainee_id'";

				$result_pending = mysqli_query($conn, $sql_pending);

				while ($row = mysqli_fetch_assoc($result_pending)) {
					$p_render_id = $row['p_render_id'];
				}

				// DELETE FROM PENDING RENDERS
				$sql_delete_pending = "DELETE FROM pending_render_tb WHERE trainee_id = $trainee_id";
				$conn->query($sql_delete_pending) or die("Error Delete Pending: " . mysqli_error($conn));

				// INSERT TO TRAINEE RENDERS
				$sql_insert_trainee = "INSERT INTO trainee_render_tb (c_render_id, is_grounded, summaries, words, levitical_service)
				SELECT c_render_id, is_grounded, summaries, words, levitical_service FROM current_render_tb WHERE trainee_id = $trainee_id";

				$conn->query($sql_insert_trainee) or die("Error Insert trainee: " . mysqli_error($conn));
				$conn->commit();
				$conn->close();

				header("Location: render.php");
			}
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
				<form action="" method="post">
					<div class="card mb-5 mt-5">
						<div class="card-header">
							<h1 class="text-center">Select Trainee</h1>
						</div>
						<div class="card-body">
							<div id="trainees" class="md-form form-group <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="trainee_id">Trainee</p>
								<select name="trainee_id" id="trainee_id" class="selectpicker" data-live-search="true" data-width="99%">
								  	<option value=" " selected>Select Trainee</option>
								  	<?php while($row = mysqli_fetch_assoc($result)) { 
								  		$trainee_id = $row['trainee_id'];
								  		$first_name = $row['first_name'];
								  		$last_name = $row['last_name'];
								  	?>
								  	<option value="<?php echo $trainee_id ?>"><?php echo $last_name; ?>, <?php echo $first_name ?></option>
								  	<?php } ?>
								</select>
								<p class="text-danger"><?php echo $trainee_id_error; ?></p>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-4">
									<button type="submit" class="btn btn-block btn-primary">Submit</button>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<a href="select_offense.php?id=<?php echo $rule_id ?>"><button type="button" class="btn btn-block btn-secondary">Go Back</button></a>
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
</body>
</html>