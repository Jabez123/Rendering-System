<?php include("header.php"); ?>

<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");
	$department_id = $_SESSION['id'];
	$render_id = $_REQUEST['id_render'];
	$rule_id = $_REQUEST['id_rule'];
	$trainee_id = $_REQUEST['id_trainee'];
	$render_code = $_REQUEST['render_code'];
 ?>

 <?php 
 	// Define variables and initialize with empty values
	

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
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = 'CONDUCT'";

		$result_conduct = mysqli_query($conn, $sql_conduct);

		while ($row = mysqli_fetch_assoc($result_conduct)) {
			$total_conduct = $row['COUNT(rules_tb.offense_type)'];
		}

		$sql_miscellaneous = "SELECT COUNT(rules_tb.offense_type) FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = 'MISCELLANEOUS'";

		$result_miscellaneous = mysqli_query($conn, $sql_miscellaneous);

		while ($row = mysqli_fetch_assoc($result_miscellaneous)) {
			$total_miscellaneous = $row['COUNT(rules_tb.offense_type)'];
		}

		$sql_render_code = "SELECT render_tb.render_code FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = '$selected_offense_type'";

		$result_render_code = mysqli_query($conn, $sql_render_code);

		while ($row = mysqli_fetch_assoc($result_render_code)) {
			$current_render_code = $row['render_code'];
		}

		$sql_selected_trainee = "SELECT * FROM trainee_tb WHERE trainee_id = $trainee_id";

		$result_selected_trainee = mysqli_query($conn, $sql_selected_trainee);

		while ($row = mysqli_fetch_assoc($result_selected_trainee)) {
			$selected_trainee = $row['trainee_id'];
			$total_trainee_summaries = $row['summaries'];
			$total_trainee_words = $row['words'];
			$total_trainee_levitical_service = $row['levitical_service'];
			$is_trainee_grounded = $row['is_grounded'];
		}

		$sql_render_code_latest = "SELECT MAX(render_tb.render_code) FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = '$selected_offense_type'";

		$result_render_code_latest = mysqli_query($conn, $sql_render_code_latest);

		while ($row = mysqli_fetch_assoc($result_render_code_latest)) {
			$render_code_latest = $row['MAX(render_tb.render_code)'];
		}

		$sql_summaries_latest = "SELECT render_tb.summaries FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = '$selected_offense_type' AND render_tb.render_code = $render_code_latest";

		$result_summaries_latest = mysqli_query($conn, $sql_summaries_latest);

		while ($row = mysqli_fetch_assoc($result_summaries_latest)) {
			if ($selected_offense_type == "CONDUCT") {
				$latest_summaries_conduct = $row['summaries'];
			}
			else if ($selected_offense_type == "MISCELLANEOUS") {
				$latest_summaries_miscellaneous = $row['summaries'];
			}
		}

		$sql_words_latest = "SELECT render_tb.words FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = '$selected_offense_type' AND render_tb.render_code = $render_code_latest";

		$result_words_latest = mysqli_query($conn, $sql_words_latest);

		while ($row = mysqli_fetch_assoc($result_words_latest)) {
			if ($selected_offense_type == "CONDUCT") {
				$latest_words_conduct = $row['words'];
			}
			else if ($selected_offense_type == "MISCELLANEOUS") {
				$latest_words_miscellaneous = $row['words'];
			}
		}

		$sql_levitical_service_latest = "SELECT render_tb.levitical_service FROM render_tb 
		INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
		INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
		INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
		WHERE trainee_tb.trainee_id = $trainee_id AND rules_tb.offense_type = '$selected_offense_type' AND render_tb.render_code = $render_code_latest";

		$result_levitical_service_latest = mysqli_query($conn, $sql_levitical_service_latest);

		while ($row = mysqli_fetch_assoc($result_levitical_service_latest)) {
			if ($selected_offense_type == "CONDUCT") {
				$latest_levitical_service_conduct = $row['levitical_service'];
			}
			else if ($selected_offense_type == "MISCELLANEOUS") {
				$latest_levitical_service_miscellaneous = $row['levitical_service'];
			}
		}

		// Check input errors before inserting in database
	    if(empty($trainee_id_error) && empty($render_id_error) && empty($rule_id_error)) {

	    	if (empty($latest_summaries_conduct)) {
	    		$latest_summaries_conduct = 0;
	    	}

	    	if (empty($latest_summaries_miscellaneous)) {
	    		$latest_summaries_miscellaneous = 0;
	    	}

	    	if ($selected_offense_type == "CONDUCT") {
	    		$total_conduct += 1;

	    		if ($total_conduct <= 4) {
					
					$render_code = $current_render_code + 1;

					if ($latest_summaries_conduct == 0 && $latest_summaries_miscellaneous == 0) {
						$total_trainee_summaries += 1;
						$total_summaries = 1;
						$total_words = + 125;
						$total_trainee_words += + 125;
					}

					else if ($latest_summaries_conduct == 0 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = 125 + $latest_words_miscellaneous;
						$total_trainee_words += 125 + $latest_words_miscellaneous;
					}

					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}

					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 0, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 0, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}
	    		
	    		if ($total_conduct <= 7) {

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						
						if ($total_summaries == 2 || $total_trainee_summaries == 2) {

							$total_summaries = 2 + $latest_summaries_miscellaneous;
							$total_trainee_summaries = 2 + $latest_summaries_miscellaneous;
						}

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						
						if ($total_summaries == 2 || $total_trainee_summaries == 2) {

							$total_summaries = 2 + $latest_summaries_miscellaneous;
							$total_trainee_summaries = 2 + $latest_summaries_miscellaneous;
						}

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 9 && $latest_words_conduct <= 875) {
	    			if ($latest_words_conduct >= 875) {
	    				$latest_words_conduct = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries = 1 + $latest_summaries_conduct;
						$total_levitical_service = 1;
						$total_trainee_levitical_service += 1;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 1 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 1 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 11 && $latest_words_conduct <= 875) {
	    			if ($latest_words_conduct >= 875) {
	    				$latest_words_conduct = 625;
	    			}

	    			$render_code = $current_render_code + 1;
	    			if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						$total_levitical_service = 2;
						$total_trainee_levitical_service += 2;
						
						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 2 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 2 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 13 && $latest_words_conduct <= 875) {
	    			if ($latest_words_conduct >= 875) {
	    				$latest_words_conduct = 625;
	    			}

	    			$render_code = $current_render_code + 1;

	    			if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						$total_levitical_service = 3;
						$total_trainee_levitical_service += 3;
						
						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 3 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 3 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}
	    		
	    		if ($total_conduct <= 15 && $latest_words_conduct <= 875) {
	    			if ($latest_words_conduct >= 875) {
	    				$latest_words_conduct = 625;
	    			}

	    			$render_code = $current_render_code + 1;
	    			
	    			if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						$total_levitical_service = 4;
						$total_trainee_levitical_service += 4;
						
						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 4 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 4 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 17 && $latest_words_conduct <= 875) {
	    			if ($latest_words_conduct >= 875) {
	    				$latest_words_conduct = 625;
	    			}

	    			$render_code = $current_render_code + 1;
	    			
	    			if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						$total_levitical_service = 5;
						$total_trainee_levitical_service += 5;
						
						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 5 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 5 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct <= 19 && $latest_words_conduct <= 875) {
	    			if ($latest_words_conduct >= 875) {
	    				$latest_words_conduct = 625;
	    			}

	    			$render_code = $current_render_code + 1;
	    			
	    			if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = 1 + $latest_summaries_conduct;
						$total_trainee_summaries += 1 + $latest_summaries_conduct;
						$total_levitical_service = 6;
						$total_trainee_levitical_service += 6;
						
						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries += 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125;
						$total_trainee_words += $latest_words_conduct + 125;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 6 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 6 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries += 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}

	    		if ($total_conduct > 19 && $latest_words_conduct <= 875) {

	    			$render_code = $current_render_code + 1;
	    			
	    			if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous == 0) {
						$total_summaries = $latest_summaries_conduct;
						$total_trainee_summaries = $total_trainee_summaries;
						$total_levitical_service = 7;
						$total_trainee_levitical_service += 7;
						
						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = 750;
						$total_trainee_words = 750;
					}
					else if ($latest_summaries_conduct >= 1 && $latest_summaries_miscellaneous >= 1) {
						$total_summaries = $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries = $total_trainee_summaries + $latest_summaries_miscellaneous;
						$total_levitical_service = 7 + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 7 + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = 750 + $latest_words_miscellaneous;
						$total_trainee_words = 750 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 1, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

		    		$conn->commit();

		    		$conn->close();

		    		header("Location: render.php");
	    		}
			}

			if ($selected_offense_type == "MISCELLANEOUS") {
				$total_miscellaneous += 1;

				if ($total_miscellaneous <= 4) {
					$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous == 0 && $latest_summaries_conduct == 0) {
						$total_trainee_summaries += 0;
						$total_summaries = 0;
						$total_words = 0;
						$total_trainee_words += 0;
					}

					else if ($latest_summaries_miscellaneous == 0 && $latest_summaries_conduct >= 1) {
						$total_summaries = 0 + $latest_summaries_conduct;
						$total_trainee_summaries += 0 + $latest_summaries_conduct;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 0;
						$total_trainee_summaries += 0;
						$total_words = 0;
						$total_trainee_words += 0;
					}

					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries += $latest_summaries_conduct;
						$total_trainee_summaries += $latest_summaries_conduct;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_summaries_miscellaneous + 125;
						$total_trainee_words += $latest_summaries_miscellaneous + 125;
					}

					$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    			summaries, is_grounded, words, levitical_service) 
		    			VALUES ($trainee_id, $department_id, $rule_id, $render_code, $total_summaries, 0, $total_words, $total_levitical_service)");

		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, 
		    			is_grounded = 0, words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 7) {
					$render_code = $current_render_code + 1;
					if ($total_miscellaneous == 5) {

						if ($latest_summaries_miscellaneous == 0 && $latest_summaries_conduct == 0) {
							$total_summaries = 2;
							$total_trainee_summaries += 2;
							
							if ($total_summaries == 2 || $total_trainee_summaries == 2) {

								$total_summaries = 2;
								$total_trainee_summaries = 2;
							}

							if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

								$total_summaries = 3;
								$total_trainee_summaries = 3;
								$total_levitical_service += 1;
								$total_trainee_levitical_service += 1;
							}

							$total_words = $latest_words_miscellaneous + 125;
							$total_trainee_words += $latest_words_miscellaneous + 125;
						}

						else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
							$total_summaries = 1 + $latest_summaries_miscellaneous;
							$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
							
							if ($total_summaries == 2 || $total_trainee_summaries == 2) {

								$total_summaries = 2;
								$total_trainee_summaries = 2;
							}

							if ($total_summaries > 3 || $total_trainee_summaries > 3) {

								$total_summaries = 3;
								$total_trainee_summaries = 3;
								$total_levitical_service += 1;
								$total_trainee_levitical_service += 1;
							}

							$total_words = $latest_words_miscellaneous + 125;
							$total_trainee_words += $latest_words_miscellaneous + 125;
						}
						else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
							$total_summaries = 2 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
							$total_trainee_summaries += 2 + $latest_summaries_conduct + $latest_summaries_miscellaneous;

							if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

								$total_summaries = 3;
								$total_trainee_summaries = 3;
								$total_levitical_service += 1;
								$total_trainee_levitical_service += 1;
							}

							$total_words = $latest_words_miscellaneous + 125 + $latest_words_conduct;
							$total_trainee_words += $latest_words_miscellaneous + 125 + $latest_words_conduct;
						}
					}

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries += 3;
						$total_trainee_summaries += 3;
						
						if ($total_summaries == 2 || $total_trainee_summaries == 2) {

							$total_summaries = 2;
							$total_trainee_summaries = 2;
						}

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 3 + $latest_summaries_conduct;
						$total_trainee_summaries = 3 + $latest_summaries_conduct;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}
					

					$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 0, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 0, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service
		    			WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 9 && $total_words <= 875) {
					if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
						$total_levitical_service = 1;
						$total_trainee_levitical_service += 1;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 1 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 1 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_summaries, is_grounded = 1, 
		    			words = $total_words, levitical_service = $total_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 11 && $total_words <= 875) {
					if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
						$total_levitical_service = 2;
						$total_trainee_levitical_service += 2;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 2 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 2 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 1, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 13 && $total_words <= 875) {
					if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
						$total_levitical_service = 3;
						$total_trainee_levitical_service += 3;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 3 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 3 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 1, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 15 && $total_words <= 875) {
					if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
						$total_levitical_service = 4;
						$total_trainee_levitical_service += 4;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 4 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 4 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 1, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 17 && $total_words <= 875) {
					if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
						$total_levitical_service = 5;
						$total_trainee_levitical_service += 5;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 5 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 5 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 1, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_miscellaneous <= 19 && $total_words <= 875) {
					if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = 1 + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_miscellaneous;
						$total_levitical_service = 6;
						$total_trainee_levitical_service += 6;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_miscellaneous + 125;
						$total_trainee_words += $latest_words_miscellaneous + 125;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_trainee_summaries += 1 + $latest_summaries_conduct + $latest_summaries_miscellaneous;
						$total_levitical_service = 6 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;
						$total_trainee_levitical_service += 6 + $latest_levitical_service_conduct + $latest_levitical_service_miscellaneous;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = $latest_words_conduct + 125 + $latest_words_miscellaneous;
						$total_trainee_words += $latest_words_conduct + 125 + $latest_words_miscellaneous;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("INSERT INTO render_tb (trainee_id, department_id, rule_id, render_code,
		    		summaries, is_grounded, words, levitical_service) 
		    		VALUES ($trainee_id, $department_id, $rule_id, $render_code,
		    		$total_summaries, 1, $total_words, $total_levitical_service)");
		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 1, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}

				if ($total_conduct > 19 && $total_words <= 875) {
	    			if ($latest_words_miscellaneous >= 875) {
	    				$latest_words_miscellaneous = 625;
	    			}

	    			$render_code = $current_render_code + 1;

					if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct == 0) {
						$total_summaries = $latest_summaries_miscellaneous;
						$total_trainee_summaries = $total_trainee_summaries;
						$total_levitical_service = 7;
						$total_trainee_levitical_service = 7;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = 750;
						$total_trainee_words = 750;
					}
					else if ($latest_summaries_miscellaneous >= 1 && $latest_summaries_conduct >= 1) {
						$total_summaries = $latest_summaries_miscellaneous + $latest_summaries_conduct;
						$total_trainee_summaries = $total_trainee_summaries + $latest_summaries_conduct;
						$total_levitical_service = 7 + $latest_levitical_service_conduct;
						$total_trainee_levitical_service = 7 + $latest_levitical_service_conduct;

						if ($total_summaries >= 3 || $total_trainee_summaries >= 3) {

							$total_summaries = 3;
							$total_trainee_summaries = 3;
							$total_levitical_service += 1;
							$total_trainee_levitical_service += 1;
						}

						$total_words = 750 + $latest_words_conduct;
						$total_trainee_words = 750 + $latest_words_conduct;
					}

	    			$conn->autocommit(FALSE);

		    		$conn->query("UPDATE render_tb SET trainee_id = $trainee_id, department_id = $department_id, 
		    			rule_id = $rule_id, summaries = $total_summaries, is_grounded = 1, 
			    		words = $total_words, levitical_service = $total_levitical_service
			    		WHERE render_id = ");

		    		$conn->query("UPDATE trainee_tb SET summaries = $total_trainee_summaries, is_grounded = 1, 
		    			words = $total_trainee_words, levitical_service = $total_trainee_levitical_service WHERE trainee_id = $selected_trainee");

					$conn->commit();

					$conn->close();
					header("Location: render.php");
				}
			}
			else {
				echo "Error: " . mysqli_error($conn);
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
					<form action="" method="post">
						<div class="card-header">
							<h1 class="display-4 text-center">Edit Render</h1>
						</div>
						<div class="card-body">
							<div class="md-form form-group <?php echo (!empty($trainee_id_error)) ? 'has-error' : ''; ?>">
								<p class="text-black-50" for="trainee_id">Trainee</p>
								<select name="trainee_id" id="trainee_id" class="selectpicker" data-live-search="true" data-width="99%">
								  	<?php while($row = mysqli_fetch_assoc($result_selected_trainee)) { 
								  		$trainee_id = $row['trainee_id'];
								  		$first_name = $row['first_name'];
								  		$last_name = $row['last_name'];
								  	?>
								  	<option value="<?php echo $trainee_id ?>" selected><?php echo $last_name; ?>, <?php echo $first_name ?></option>
								  	<?php } ?>

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
								  	<?php while($row = mysqli_fetch_assoc($result_selected_rule)) { 
								  		$rule_id = $row['rule_id'];
								  		$offense_code = $row['offense_code'];
								  		$offense_type = $row['offense_type'];
								  		$offense_description = $row['offense_description'];
								  	?>
								  	<option value="<?php echo $rule_id ?>" selected><?php echo $offense_code; ?> - <?php echo $offense_description; ?>: <?php echo $offense_type; ?></option>
								  	<?php } ?>

								  	<?php while($row = mysqli_fetch_assoc($result_rule)) { 
								  		$rule_id = $row['rule_id'];
								  		$offense_code = $row['offense_code'];
								  		$offense_type = $row['offense_type'];
								  		$offense_description = $row['offense_description'];
								  	?>
								  	<option value="<?php echo $rule_id ?>"><?php echo $offense_code; ?> - <?php echo $offense_description; ?>: <?php echo $offense_type; ?></option>
								  	<?php } ?>
								</select>
								<p class="text-danger"><?php echo $rule_id_error; ?></p>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-4">
									<button type="submit" class="btn btn-block btn-primary">Save</button>
								</div>
								<div class="col-sm-12 col-md-4"></div>
								<div class="col-md-4">
									<a href="render.php"><button type="button" class="btn btn-block btn-secondary">Go Back</button></a>
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

</body>
</html>