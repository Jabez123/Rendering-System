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

	// VARIABLES
	$num_offense_type_conduct = $num_offense_type_miscellaneous = 0;
	$is_grounded = $is_grounded_conduct = $is_grounded_miscellaneous = 0;
	$total_summaries = $total_summaries_conduct = $total_summaries_miscellaneous = 0;
	$current_summaries = $current_summaries_conduct = $current_summaries_miscellaneous = 0;
	$words = $words_conduct = $words_miscellaneous = 0;
	$levitical_service = $levitical_service_conduct = $levitical_service_miscellaneous = 0;


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$trainee_id = $_POST['trainee_id'];

		$sql_trainee_render = "SELECT * FROM trainee_render_tb WHERE trainee_id = $trainee_id";

		$result_trainee_render = mysqli_query($conn, $sql_trainee_render);

		while ($row = mysqli_fetch_assoc($result_trainee_render)) {
			$is_grounded_trainee = $row['is_grounded'];
			$total_summaries_trainee = $row['total_summaries'];
			$current_summaries_trainee = $row['current_summaries'];
			$words_trainee = $row['words'];
			$levitical_service_trainee = $row['levitical_service'];
		}

		$sql_current_render = "SELECT MAX(current_render_tb.c_render_id), COUNT(rules_tb.offense_type),
		MAX(current_render_tb.is_grounded), MAX(current_render_tb.total_summaries), MAX(current_render_tb.current_summaries), MAX(current_render_tb.words), 
		MAX(current_render_tb.levitical_service)
		FROM current_render_tb INNER JOIN trainee_tb ON current_render_tb.trainee_id = trainee_tb.trainee_id 
		INNER JOIN department_tb ON current_render_tb.department_id = department_tb.department_id
		INNER JOIN rules_tb ON current_render_tb.rule_id = rules_tb.rule_id
		INNER JOIN week_tb ON current_render_tb.week_id = week_tb.week_id
        WHERE trainee_tb.trainee_id = '$trainee_id' AND week_tb.week_id = $week_id AND rules_tb.offense_type = '$selected_offense_type'";

        $result_current_render = mysqli_query($conn, $sql_current_render);

        while ($row = mysqli_fetch_assoc($result_current_render)) {
        	

        	if ($selected_offense_type == "CONDUCT") {
        		$latest_render_id_conduct = $row['MAX(current_render_tb.c_render_id)'] + 1;
        		$num_offense_type_conduct = $row['COUNT(rules_tb.offense_type)'] + 1;
	        	$is_grounded_conduct = $row['MAX(current_render_tb.is_grounded)'];
	        	$total_summaries_conduct = $row['MAX(current_render_tb.total_summaries)'];
	        	$current_summaries_conduct = $row['MAX(current_render_tb.current_summaries)'];
	        	$words_conduct = $row['MAX(current_render_tb.words)'];
	        	$levitical_service_conduct = $row['MAX(current_render_tb.levitical_service)'];
        	}

        	if ($selected_offense_type == "MISCELLANEOUS") {
        		$latest_render_id_miscellaneous = $row['MAX(current_render_tb.c_render_id)'] + 1;
        		$num_offense_type_miscellaneous = $row['COUNT(rules_tb.offense_type)'] + 1;
	        	$is_grounded_miscellaneous = $row['MAX(current_render_tb.is_grounded)'];
	        	$total_summaries_miscellaneous = $row['MAX(current_render_tb.total_summaries)'];
	        	$current_summaries_miscellaneous = $row['MAX(current_render_tb.current_summaries)'];
	        	$words_miscellaneous = $row['MAX(current_render_tb.words)'];
	        	$levitical_service_miscellaneous = $row['MAX(current_render_tb.levitical_service)'];
        	}
        }

		if ($selected_offense_type == "CONDUCT" ) {

			// IF CONDUCT IS 4 BELOW INSERT TO PENDING
			if ($num_offense_type_conduct < 5) {

				$is_grounded_conduct = 0;
				$current_summaries_conduct = 0;
				$total_summaries_conduct = 0;
				$words_conduct = 0;
				$levitical_service_conduct = 0;

				// INSERT TO CURRENT RENDERS
				$sql_insert_current = "INSERT INTO current_render_tb
				(trainee_id, department_id, rule_id, week_id,
				is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
				('$trainee_id', $department_id, $rule_id, $week_id,
				$is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct, 
				$num_offense_type_conduct)";

				// INSERT TO PENDING RENDERS
				$sql_insert_pending = "INSERT INTO pending_render_tb(trainee_id, department_id, rule_id, week_id, render_num) 
				VALUES ('$trainee_id', $department_id, $rule_id, $week_id, $num_offense_type_conduct)";

				$conn->autocommit(FALSE);
				$conn->query($sql_insert_current) or die("Error Current INSERT: " . mysqli_error($conn));
				$conn->query($sql_insert_pending) or die("Error Pending INSERT: " . mysqli_error($conn));
				$conn->commit();
				$conn->close();

				header("Location: render.php");
			}

			// IF OFFENSE TYPE NUMBER IS 5
			if ($num_offense_type_conduct == 5) {
				$is_grounded_conduct = 1;
				$current_summaries_conduct = 2;
				$total_summaries_conduct = $current_summaries_conduct;
				$words_conduct = 625;
				$levitical_service_conduct = 0;

				// INSERT TO CURRENT RENDERS
				$sql_insert_current = "INSERT INTO current_render_tb
				(trainee_id, department_id, rule_id, week_id,
				is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
				($trainee_id, $department_id, $rule_id, $week_id,
				$is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct, $num_offense_type_conduct)";

				// DELETE FROM PENDING RENDERS
				$sql_delete_pending = "DELETE FROM pending_render_tb WHERE trainee_id = $trainee_id";

				if (mysqli_num_rows($result_trainee_render) == 0) {
					// INSERT TO TRAINEE RENDERS
					$sql_insert_trainee = "INSERT INTO trainee_render_tb (trainee_id, week_id, is_grounded, total_summaries, current_summaries, words, levitical_service) VALUES 
					($trainee_id, $week_id, $is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct)";
					$conn->query($sql_insert_trainee) or die("5 Error Insert Trainee: " . mysqli_error($conn));
				}
				else {

					if ($total_summaries_trainee > 3) {
						$levitical_service_conduct = $total_summaries_trainee - 3;
						$current_summaries_conduct = 3;
					}

					if ($words_trainee > 1000) {
						$words_conduct = 1000;
					}
					$sql_update_trainee = "UPDATE trainee_render_tb 
					SET is_grounded = $is_grounded_conduct,
					total_summaries = $total_summaries_trainee + $total_summaries_conduct,
					current_summaries = $current_summaries_conduct,
					words = $words_conduct,
					levitical_service = $levitical_service_conduct
					WHERE trainee_id = $trainee_id AND week_id = $week_id";
					$conn->query($sql_update_trainee) or die("5 Error Update Trainee: " . mysqli_error($conn));
				}
				
				$conn->autocommit(FALSE);
				$conn->query($sql_delete_pending) or die("5 Error Delete Pending: " . mysqli_error($conn));
				$conn->query($sql_insert_current) or die("5 Error Insert Current: " . mysqli_error($conn));
				$conn->commit();
				$conn->close();

				header("Location: render.php");
			}

			// IF OFFENSE TYPE NUMBER IS GREATER THAN 5
			if ($num_offense_type_conduct > 5) {

				// IF OFFENSE TYPE NUMBER IS EVEN
				if ($num_offense_type_conduct % 2 == 0) {
					$is_grounded_conduct = 1;
					$current_summaries_conduct += 1;
					$total_summaries_conduct += 1;
					$words_conduct = 750;

					if ($total_summaries_conduct > 3) {
						$levitical_service_conduct = $total_summaries_conduct - 3;
						$current_summaries_conduct = 3;
					}

					// INSERT TO CURRENT RENDERS
					$sql_insert_current = "INSERT INTO current_render_tb
					(trainee_id, department_id, rule_id, week_id,
					is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
					($trainee_id, $department_id, $rule_id, $week_id,
					$is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct, $num_offense_type_conduct)";

					if (mysqli_num_rows($result_trainee_render) == 0) {
					// INSERT TO TRAINEE RENDERS
					$sql_insert_trainee = "INSERT INTO trainee_render_tb (trainee_id, week_id, is_grounded, total_summaries, current_summaries, words, levitical_service) VALUES 
					($trainee_id, $week_id, $is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct)";
					$conn->query($sql_insert_trainee) or die("5 Error Insert Trainee: " . mysqli_error($conn));
				}
				else {

					if ($total_summaries_trainee > 3) {
						$levitical_service_conduct = $total_summaries_trainee - 3;
						$current_summaries_conduct = 3;
					}

					if ($words_trainee > 1000) {
						$words_conduct = 1000;
					}

					$sql_update_trainee = "UPDATE trainee_render_tb 
					SET is_grounded = $is_grounded_conduct,
					total_summaries = $total_summaries_trainee + $total_summaries_conduct,
					current_summaries = $current_summaries_conduct,
					words = $words_conduct,
					levitical_service = $levitical_service_conduct
					WHERE trainee_id = $trainee_id AND week_id = $week_id";
					$conn->query($sql_update_trainee) or die("5 Error Update Trainee: " . mysqli_error($conn));
				}

					$conn->autocommit(FALSE);
					$conn->query($sql_insert_current) or die("Even Error Current INSERT: " . mysqli_error($conn));
					$conn->commit();
					$conn->close();

					header("Location: render.php");
				}
				// IF OFFENSE TYPE NUMBER IS ODD
				else {
					$is_grounded_conduct = 1;
					$words_conduct = 875;
					$levitical_service_conduct = $levitical_service_conduct;

					// INSERT TO CURRENT RENDERS
					$sql_insert_current = "INSERT INTO current_render_tb
					(trainee_id, department_id, rule_id, week_id,
					is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
					('$trainee_id', $department_id, $rule_id, $week_id,
					$is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct, $num_offense_type_conduct)";

					if (mysqli_num_rows($result_trainee_render) == 0) {
					// INSERT TO TRAINEE RENDERS
					$sql_insert_trainee = "INSERT INTO trainee_render_tb (trainee_id, week_id, is_grounded, total_summaries, current_summaries, words, levitical_service) VALUES 
					($trainee_id, $week_id, $is_grounded_conduct, $total_summaries_conduct, $current_summaries_conduct, $words_conduct, $levitical_service_conduct)";
					$conn->query($sql_insert_trainee) or die("5 Error Insert Trainee: " . mysqli_error($conn));
					}
					else {

						if ($total_summaries_trainee > 3) {
								$levitical_service_conduct = $total_summaries_trainee - 3;
								$current_summaries_conduct = 3;
						}

						if ($words_trainee > 1000) {
							$words_conduct = 1000;
						}

						$sql_update_trainee = "UPDATE trainee_render_tb 
						SET is_grounded = $is_grounded_conduct,
						total_summaries = $total_summaries_trainee + $total_summaries_conduct,
						current_summaries = $current_summaries_conduct,
						words = $words_conduct,
						levitical_service = $levitical_service_conduct
						WHERE trainee_id = $trainee_id AND week_id = $week_id";
						$conn->query($sql_update_trainee) or die("5 Error Update Trainee: " . mysqli_error($conn));
					}

					$conn->autocommit(FALSE);
					$conn->query($sql_insert_current) or die("Even Error Current INSERT: " . mysqli_error($conn));
					$conn->commit();
					$conn->close();

					header("Location: render.php");
				}
			}
		}

		if ($selected_offense_type == "MISCELLANEOUS") {
			
			if ($num_offense_type_miscellaneous < 5) {
				
				$is_grounded_miscellaneous = 0;
				$total_summaries_miscellaneous = 0;
				$words_miscellaneous = 0;
				$levitical_service_miscellaneous = 0;

				// INSERT TO CURRENT RENDERS
				$sql_insert_current = "INSERT INTO current_render_tb
				(trainee_id, department_id, rule_id, week_id,
				is_grounded, total_summaries, words, levitical_service, render_num) VALUES
				($trainee_id, $department_id, $rule_id, $week_id,
				$is_grounded_miscellaneous, $total_summaries_miscellaneous, $words_miscellaneous, $levitical_service_miscellaneous, $num_offense_type_miscellaneous)";

				// INSERT TO PENDING RENDERS
				$sql_insert_pending = "INSERT INTO pending_render_tb(trainee_id, department_id, rule_id, week_id, render_num) 
				VALUES ('$trainee_id', $department_id, $rule_id, $week_id, $num_offense_type_miscellaneous)";

				$conn->autocommit(FALSE);
				$conn->query($sql_insert_current) or die("Error Current INSERT: " . mysqli_error($conn));
				$conn->query($sql_insert_pending) or die("Error Current INSERT: " . mysqli_error($conn));
				$conn->commit();
				$conn->close();

				header("Location: render.php");
			}

			if ($num_offense_type_miscellaneous == 5) {
				$is_grounded_miscellaneous = 0;
				$current_summaries_miscellaneous = 2;
				$total_summaries_miscellaneous = $current_summaries_miscellaneous;
				$words_miscellaneous = 625;
				$levitical_service_miscellaneous = 0;

				// INSERT TO CURRENT RENDERS
				$sql_insert_current = "INSERT INTO current_render_tb
				(trainee_id, department_id, rule_id, week_id,
				is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
				($trainee_id, $department_id, $rule_id, $week_id,
				$is_grounded_miscellaneous, $total_summaries_miscellaneous, $current_summaries_miscellaneous, $words_miscellaneous, $levitical_service_miscellaneous, $num_offense_type_miscellaneous)";

				// DELETE FROM PENDING RENDERS
				$sql_delete_pending = "DELETE FROM pending_render_tb WHERE trainee_id = $trainee_id";

				// INSERT TO TRAINEE RENDERS
				if (mysqli_num_rows($result_trainee_render) == 0) {
					// INSERT TO TRAINEE RENDERS
					$sql_insert_trainee = "INSERT INTO trainee_render_tb (trainee_id, week_id, is_grounded, total_summaries, current_summaries, words, levitical_service) VALUES 
					($trainee_id, $week_id, $is_grounded_miscellaneous, $total_summaries_miscellaneous, $current_summaries_miscellaneous, $words_miscellaneous, $levitical_service_miscellaneous)";
					$conn->query($sql_insert_trainee) or die("5 Error Insert Trainee: " . mysqli_error($conn));
				}
				else {

					if ($total_summaries_trainee > 3) {
						$levitical_service_miscellaneous = $total_summaries_trainee - 3;
						$current_summaries_miscellaneous = 3;
					}

					if ($words_trainee > 1000) {
						$words_miscellaneous = 1000;
					}

					$sql_update_trainee = "UPDATE trainee_render_tb 
					SET is_grounded = $is_grounded_miscellaneous,
					total_summaries = $total_summaries_trainee + $total_summaries_miscellaneous,
					current_summaries = $current_summaries_miscellaneous,
					words = $words_miscellaneous,
					levitical_service = $levitical_service_miscellaneous
					WHERE trainee_id = $trainee_id AND week_id = $week_id";
					$conn->query($sql_update_trainee) or die("5 Error Update Trainee: " . mysqli_error($conn));
				}

				$conn->autocommit(FALSE);
				$conn->query($sql_delete_pending) or die("5 Error Delete Pending: " . mysqli_error($conn));
				$conn->query($sql_insert_current) or die("5 Error Insert Current: " . mysqli_error($conn));
				$conn->commit();
				$conn->close();

				header("Location: render.php");
			}

			// IF OFFENSE TYPE NUMBER IS GREATER THAN 5
			if ($num_offense_type_miscellaneous > 5) {

				// IF OFFENSE TYPE NUMBER IS EVEN
				if ($num_offense_type_miscellaneous % 2 == 0) {
					$is_grounded_miscellaneous = 0;
					$current_summaries_miscellaneous += 1;
					$total_summaries_miscellaneous += 1;
					$words_miscellaneous = 750;

					if ($total_summaries_miscellaneous > 3) {
						$levitical_service_miscellaneous = $total_summaries_miscellaneous - 3;
						$current_summaries_miscellaneous = 3;
					}

					// INSERT TO CURRENT RENDERS
					$sql_insert_current = "INSERT INTO current_render_tb
					(trainee_id, department_id, rule_id, week_id,
					is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
					('$trainee_id', $department_id, $rule_id, $week_id,
					$is_grounded_miscellaneous, $total_summaries_miscellaneous, $current_summaries_miscellaneous, $words_miscellaneous, $levitical_service_miscellaneous, $num_offense_type_miscellaneous)";

					if (mysqli_num_rows($result_trainee_render) == 0) {
						// INSERT TO TRAINEE RENDERS
						$sql_insert_trainee = "INSERT INTO trainee_render_tb (trainee_id, week_id, is_grounded, total_summaries, current_summaries, words, levitical_service) VALUES 
						($trainee_id, $week_id, $is_grounded_miscellaneous, $total_summaries_miscellaneous, $current_summaries_miscellaneous, $words_miscellaneous, $levitical_service_miscellaneous)";
						$conn->query($sql_insert_trainee) or die("5 Error Insert Trainee: " . mysqli_error($conn));
					}
					else {

						if ($total_summaries_trainee > 3) {
							$levitical_service_miscellaneous = $total_summaries_trainee - 3;
							$current_summaries_miscellaneous = 3;
						}

						if ($words_trainee > 1000) {
							$words_conduct = 1000;
						}
						$sql_update_trainee = "UPDATE trainee_render_tb 
						SET is_grounded = $is_grounded_miscellaneous,
						total_summaries = $total_summaries_miscellaneous,
						current_summaries = $current_summaries_conduct,
						words = $words_conduct,
						levitical_service = $levitical_service_conduct
						WHERE trainee_id = $trainee_id AND week_id = $week_id";
						$conn->query($sql_update_trainee) or die("5 Error Update Trainee: " . mysqli_error($conn));
					}

					$conn->autocommit(FALSE);
					$conn->query($sql_insert_current) or die("Even Error Insert Current: " . mysqli_error($conn));
					$conn->query($sql_insert_trainee) or die("Even Error Insert trainee: " . mysqli_error($conn));
					$conn->commit();
					$conn->close();

					header("Location: render.php");
				}
				// IF OFFENSE TYPE NUMBER IS ODD
				else {
					$is_grounded_miscellaneous = 1;
					$words_miscellaneous = 875;
					$levitical_service_miscellaneous = $levitical_service_miscellaneous;

					// INSERT TO CURRENT RENDERS
					$sql_insert_current = "INSERT INTO current_render_tb
					(trainee_id, department_id, rule_id, week_id,
					is_grounded, total_summaries, current_summaries, words, levitical_service, render_num) VALUES
					('$trainee_id', $department_id, $rule_id, $week_id,
					$is_grounded_miscellaneous, $total_summaries_miscellaneous, $current_summaries_miscellaneous, $words_miscellaneous, $levitical_service_miscellaneous, $num_offense_type_miscellaneous)";

					// INSERT TO TRAINEE RENDERS
					$sql_insert_trainee = "INSERT INTO trainee_render_tb (c_render_id, is_grounded, total_summaries, current_summaries, words, levitical_service) VALUES 
					((SELECT MAX(c_render_id) FROM current_render_tb 
					INNER JOIN rules_tb ON rules_tb.rule_id = current_render_tb.rule_id 
					WHERE current_render_tb.trainee_id = $trainee_id AND rules_tb.offense_type = 'MISCELLANEOUS'), $is_grounded_miscellaneous, $total_summaries_miscellaneous, $current_summaries_miscellaneous, $words_miscellaneous, 
					$levitical_service_miscellaneous)";

					$conn->autocommit(FALSE);
					$conn->query($sql_insert_current) or die("Even Error Insert Current: " . mysqli_error($conn));
					$conn->commit();
					$conn->query($sql_insert_trainee) or die("Even Error Insert trainee: " . mysqli_error($conn));
					$conn->commit();
					$conn->close();

					header("Location: render.php");
				}
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
<script> 
    window.onload = function() { 
        document.getElementById("trainee_id").focus(); 
    } 
</script>
</body>
</html>