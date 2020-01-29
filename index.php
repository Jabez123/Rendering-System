<?php 
	// Include configs
	require_once("config/connectServer.php");
	require_once("config/connectDatabase.php");

	$date = date('m/d/Y h:i:s a', time());

	$total_pages_render = $conn->query("SELECT * FROM render_tb")->num_rows;

	$page_render = isset($_GET['page_render']) && is_numeric($_GET['page_render']) ? $_GET['page_render'] : 1;

	$num_results_on_page_render = 8;

	$sql_render = "SELECT trainee_tb.trainee_id, trainee_tb.last_name, trainee_tb.first_name, 
	trainee_tb.id_name, trainee_tb.gender, trainee_tb.class_group,
	rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_description, 
	render_tb.render_id, render_tb.render_date, trainee_tb.summaries, trainee_tb.is_grounded, trainee_tb.words, trainee_tb.levitical_service
	FROM render_tb 
	INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
	INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
	INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id
	GROUP BY trainee_tb.first_name, trainee_tb.last_name LIMIT ?, ?";

	if ($stmt_render = $conn->prepare($sql_render)) {
		$calc_page_render = ($page_render - 1) * $num_results_on_page_render;
		$stmt_render->bind_param('ii', $calc_page_render, $num_results_on_page_render);
		$stmt_render->execute();

		$result_render = $stmt_render->get_result();
	}
	else {
		echo "Error: " . mysqli_Error($conn);
	}
 ?>

<?php include("header.php"); ?>

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
	<div class="container-fluid" style="margin-top: 80px;">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<!-- Card Dark -->
						<div class="card">
							<!-- Card content -->
							<div class="card-body white-text rounded-bottom">
								<!-- Title -->
								<h4 class="card-title text-center text-black-50"> Renders</h4>
								<!-- Material input -->
								<div class="md-form">
									<input type="text" id="search" class="form-control">
									<label for="search">Search Name</label>
								</div>
								<div class="text-center">
									<button type="button" class="btn btn-primary">Search</button>
								</div>
								<!-- Body -->
								<div class="mt-5">
										<?php if (ceil($total_pages_render / $num_results_on_page_render) > 0) { ?>
											<nav aria-label="Page navigation">
												<ul class="pagination pg-blue justify-content-center">
													<?php if ($page_render > 1) {?>
												    <li class="page-item ">
												      <a class="page-link" href="index.php?page_render=<?php echo $page_render-1 ?>" tabindex="-1">Previous</a>
												    </li>
												    <?php } ?>

												    <?php if ($page_render > 3) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_render=1">1 </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_render-2 > 0) { ?>
												    <li class="page-item">
												      <a class="page-link" href="index.php?page_render=<?php echo $page_render-2 ?>"><?php echo $page_render-2; ?> </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_render-1 > 0) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_render=<?php echo $page_render-1 ?>"><?php echo $page_render-1; ?></a>
												    </li>
												    <?php } ?>

												    <li class="page-item active">
												    	<a class="page-link" href="index.php?page_render=<?php echo $page_render ?>"><?php echo $page_render ?> <span class="sr-only">(current)</span></a>
												    </li>

												    <?php if ($page_render+1 < ceil($total_pages_render / $num_results_on_page_render)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo $page_render+1 ?>"><?php echo $page_render+1 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_render+2 < ceil($total_pages_render / $num_results_on_page_render)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo $page_render+2 ?>"><?php echo $page_render+2 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_render < ceil($total_pages_render / $num_results_on_page_render)-2) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo ceil($total_pages_render/ $num_results_on_page_render) ?>"><?php echo ceil($total_pages_render/ $num_results_on_page_render) ?></a>
														</li>
													<?php } ?>

												    <?php if ($page_render < ceil($total_pages_render / $num_results_on_page_render)) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo $page_render+1 ?>">Next</a>
														</li>
													<?php } ?>

												 </ul>
											</nav>
										<?php } ?>
									<div class="row" id="myData">
										<?php if (mysqli_num_rows($result_render) > 0) { ?>
											<?php 
												while($row = $result_render->fetch_assoc()) {
												$render_id = $row['render_id'];
												$trainee_id = $row['trainee_id'];
												$first_name = $row['first_name'];
												$last_name = $row['last_name'];
												$id_name = $row['id_name'];
												$gender = $row['gender'];
												if ($gender == "Brother") {
													$gender = "Bro";
												}
												else if ($gender == "Sister") {
													$gender = "Sis";
												}
												$class_group = $row['class_group'];
												$summaries = $row['summaries'];
												$words = $row['words'];
												$levitical_service = $row['levitical_service'];
												$is_grounded = $row['is_grounded'];
												if ($is_grounded == 1) {
													$is_grounded = "Yes";
												}
												else {
													$is_grounded = "No";
												}
												$offense_code = $row['offense_code'];

												$sql_offense = "SELECT trainee_tb.trainee_id, trainee_tb.last_name, trainee_tb.first_name, 
													trainee_tb.id_name, trainee_tb.gender, trainee_tb.class_group,
													rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_description, 
													render_tb.render_id, render_tb.render_date, trainee_tb.summaries, render_tb.is_grounded, trainee_tb.words, trainee_tb.levitical_service
													FROM render_tb 
													INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
													INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
													INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id 
													WHERE trainee_tb.trainee_id = $trainee_id";
												$result_offense = mysqli_query($conn, $sql_offense);

										 	?>
												<div class="col-sm-12 col-md-6 col-lg-3">
													<!-- Card -->
													<div class="card mb-4">
														<div class="card-header unique-color">
															<h4 class="card-title text-white text-center"><?php echo $class_group; ?> <?php echo $gender . " " . $last_name . " " . $first_name; ?></h4>
														</div>
														<!--Card content-->
														<div class="card-body">
															<ul class="list-group list-group-flush">															    <li class="list-group-item text-body">Summary: <?php echo $summaries; ?></li>
															    <li class="list-group-item text-body">Words: <?php echo $words; ?></li>
															    <li class="list-group-item text-body">Levitical Service: <?php echo $levitical_service; ?></li>
															    <li class="list-group-item text-body">Grounded: <?php echo $is_grounded; ?></li>
															</ul>
														</div>
														<div class="card-footer">
															<button class="btn btn-block btn-primary" data-toggle="modal" 
															data-target="#modalOffense<?php echo $render_id; ?>">See offenses</button>
														</div>
													</div>
												<!-- Card -->
												</div>
												<?php include("offense_modal.php"); ?>
											<?php } ?>
										<?php }
										else { ?>
											<div class="col-sm-12">
												<!-- Card -->
											<div class="card bg-primary mb-4">
												<!--Card content-->
												<div class="card-body">
													<center>
														<p class="display-4 mt-5 mb-5 font-weight-bold">No Renders</p>
													</center>
												</div>
											</div>
											<!-- Card -->
											</div>
										<?php } ?>
									</div>
								</div>
										<?php if (ceil($total_pages_render / $num_results_on_page_render) > 0) { ?>
											<nav aria-label="Page_render navigation">
												<ul class="pagination pg-blue justify-content-center">
													<?php if ($page_render > 1) {?>
												    <li class="page-item ">
												      <a class="page-link" href="index.php?page_render=<?php echo $page_render-1 ?>" tabindex="-1">Previous</a>
												    </li>
												    <?php } ?>

												    <?php if ($page_render > 3) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_render=1">1 </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_render-2 > 0) { ?>
												    <li class="page-item">
												      <a class="page-link" href="index.php?page_render=<?php echo $page_render-2 ?>"><?php echo $page_render-2; ?> </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_render-1 > 0) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_render=<?php echo $page_render-1 ?>"><?php echo $page_render-1; ?></a>
												    </li>
												    <?php } ?>

												    <li class="page-item active">
												    	<a class="page-link" href="index.php?page_render=<?php echo $page_render ?>"><?php echo $page_render ?> <span class="sr-only">(current)</span></a>
												    </li>

												    <?php if ($page_render+1 < ceil($total_pages_render / $num_results_on_page_render)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo $page_render+1 ?>"><?php echo $page_render+1 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_render+2 < ceil($total_pages_render / $num_results_on_page_render)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo $page_render+2 ?>"><?php echo $page_render+2 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_render < ceil($total_pages_render / $num_results_on_page_render)-2) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo ceil($total_pages_render/ $num_results_on_page_render) ?>"><?php echo ceil($total_pages_render/ $num_results_on_page_render) ?></a>
														</li>
													<?php } ?>

												    <?php if ($page_render < ceil($total_pages_render / $num_results_on_page_render)) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_render=<?php echo $page_render+1 ?>">Next</a>
														</li>
													<?php } ?>

												 </ul>
											</nav>
										<?php } ?>
								</div>
							</div>
						</div>
						<!-- Card Dark -->
					</div>
				</div>
			</div>
</main>

<?php include("footer.php"); ?>
<script>
$('#search').keyup(function (){
    $('.col-lg-3').removeClass('d-none');
    var filter = $(this).val(); // get the value of the input, which we filter on
    $('#myData').find('.col-lg-3 .card .card-header h4:not(:contains("'+filter+'"))').parent().parent().parent().addClass('d-none');
})
</script>

</body>
</html>