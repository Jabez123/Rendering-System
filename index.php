<?php 
	// Include configs
	require_once("config/connectServer.php");
	require_once("config/connectDatabase.php");

	$total_pages_trainee = $conn->query("SELECT * FROM trainee_tb")->num_rows;

	$page_trainee = isset($_GET['page_trainee']) && is_numeric($_GET['page_trainee']) ? $_GET['page_trainee'] : 1;

	$num_results_on_page_trainee = 8;

	$sql_trainee = "SELECT * FROM trainee_tb LIMIT ?, ?";

	if ($stmt_trainee = $conn->prepare($sql_trainee)) {
		$calc_page_trainee = ($page_trainee - 1) * $num_results_on_page_trainee;
		$stmt_trainee->bind_param('ii', $calc_page_trainee, $num_results_on_page_trainee);
		$stmt_trainee->execute();

		$result_trainee = $stmt_trainee->get_result();
	}

	$total_pages_department = $conn->query("SELECT * FROM department_tb")->num_rows;

	$page_department = isset($_GET['page_department']) && is_numeric($_GET['page_department']) ? $_GET['page_department'] : 1;

	$num_results_on_page_department = 8;

	$sql_department = "SELECT * FROM department_tb LIMIT ?, ?";

	if ($stmt_department = $conn->prepare($sql_department)) {
		$calc_page_department = ($page_department - 1) * $num_results_on_page_department;
		$stmt_department->bind_param('ii', $calc_page_department, $num_results_on_page_department);
		$stmt_department->execute();

		$result_department = $stmt_department->get_result();
	}
 ?>

<?php include("header.php"); ?>

<main class="mt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Home</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<ul class="nav nav-tabs mt-5" id="dashboardTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="trainees-tab" data-toggle="tab" href="#trainees" role="tab" aria-controls="trainees"
			aria-selected="true">Trainees Dashboard</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="department-tab" data-toggle="tab" href="#department" role="tab" aria-controls="department"
			aria-selected="false">Department Overview</a>
		</li>
	</ul>
	<div class="tab-content" id="dashboardTabContent">
		<!-- Trainees Tab -->
		<div class="tab-pane fade show active" id="trainees" role="tabpanel" aria-labelledby="trainees-tab">

			<div class="container-fluid" style="margin-top: 80px;">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<!-- Card Dark -->
						<div class="card">
							<!-- Card content -->
							<div class="card-body white-text rounded-bottom">
								<!-- Title -->
								<h4 class="card-title text-center text-black-50"> Trainees Dashboard</h4>
								<!-- Material input -->
								<div class="md-form">
									<input type="text" id="form1" class="form-control">
									<label for="form1">Search</label>
								</div>
								<div class="text-center">
									<button type="button" class="btn btn-primary">Search</button>
								</div>
								<!-- Body -->
								<div class="mt-5">
										<?php if (ceil($total_pages_trainee / $num_results_on_page_trainee) > 0) { ?>
											<nav aria-label="Page navigation">
												<ul class="pagination pg-blue justify-content-center">
													<?php if ($page_trainee > 1) {?>
												    <li class="page-item ">
												      <a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee-1 ?>" tabindex="-1">Previous</a>
												    </li>
												    <?php } ?>

												    <?php if ($page_trainee > 3) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_trainee=1">1 </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_trainee-2 > 0) { ?>
												    <li class="page-item">
												      <a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee-2 ?>"><?php echo $page_trainee-2; ?> </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_trainee-1 > 0) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee-1 ?>"><?php echo $page_trainee-1; ?></a>
												    </li>
												    <?php } ?>

												    <li class="page-item active">
												    	<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee ?>"><?php echo $page_trainee ?> <span class="sr-only">(current)</span></a>
												    </li>

												    <?php if ($page_trainee+1 < ceil($total_pages_trainee / $num_results_on_page_trainee)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee+1 ?>"><?php echo $page_trainee+1 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_trainee+2 < ceil($total_pages_trainee / $num_results_on_page_trainee)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee+2 ?>"><?php echo $page_trainee+2 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_trainee < ceil($total_pages_trainee / $num_results_on_page_trainee)-2) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo ceil($total_pages_trainee/ $num_results_on_page_trainee) ?>"><?php echo ceil($total_pages_trainee/ $num_results_on_page_trainee) ?></a>
														</li>
													<?php } ?>

												    <?php if ($page_trainee < ceil($total_pages_trainee / $num_results_on_page_trainee)) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee+1 ?>">Next</a>
														</li>
													<?php } ?>

												 </ul>
											</nav>
										<?php } ?>
									<div class="row">
										<?php if (mysqli_num_rows($result_trainee) > 0) { ?>

											<?php while($row = $result_trainee->fetch_assoc()) {
											$trainee_id = $row['trainee_id'];
											$first_name = $row['first_name'];
											$last_name = $row['last_name'];
											$id_name = $row['id_name'];
											$gender = $row['gender'];
											if ($gender == "Brother") {
												$gender = "Bro";
											}
											else {
												$gender = "Sis";
											}
											$class = $row['class'];
											$class_group = $row['class_group'];
											$room = $row['room'];
											$team = $row['team'];
											$status = $row['status'];
										 ?>
										<div class="col-sm-12 col-md-6 col-lg-3">
											<?php 
												if ($status == "Active") { 
											?>
											<!-- Card -->
											<div class="card bg-dark mb-4">
												<div class="card-header ">
													<h4 class="card-title text-white text-center"><?php echo $gender . " " . $last_name . " " . $first_name; ?></h4>
												</div>
												<!--Card content-->
												<div class="card-body">
													  <ul class="list-group list-group-flush">
													    <li class="list-group-item text-body">ID Name: <?php echo $id_name; ?></li>
													    <li class="list-group-item text-body">Class: <?php echo $class; ?></li>
													    <li class="list-group-item text-body">Group: <?php echo $class_group; ?></li>
													    <li class="list-group-item text-body">Room: <?php echo $room; ?></li>
													    <li class="list-group-item text-body">Team: <?php echo $team; ?></li>
													  </ul>
												</div>
												<div class="card-footer">
													<a href="trainee.php"><button class="btn btn-block btn-primary">Manage</button></a>
												</div>
											</div>
											<!-- Card -->
											<?php } 
												else if ($status == "Inactive") {
											?>

											<!-- Card -->
											<div class="card bg-danger mb-4">
												<div class="card-header ">
													<h4 class="card-title text-white text-center"><?php echo $gender . " " . $last_name . " " . $first_name; ?></h4>
												</div>
												<!--Card content-->
												<div class="card-body">
													  <ul class="list-group list-group-flush">
													    <li class="list-group-item text-body">ID Name: <?php echo $id_name; ?></li>
													    <li class="list-group-item text-body">Class: <?php echo $class; ?></li>
													    <li class="list-group-item text-body">Group: <?php echo $class_group; ?></li>
													    <li class="list-group-item text-body">Room: <?php echo $room; ?></li>
													    <li class="list-group-item text-body">Team: <?php echo $team; ?></li>
													  </ul>
												</div>
												<div class="card-footer">
													<a href="trainee.php"><button class="btn btn-block btn-primary">Manage</button></a>
												</div>
											</div>
											<!-- Card -->

										<?php } ?>
											
										</div>
									<?php } ?>
										<?php }
										else { ?>
											<div class="col-sm-12">
												<!-- Card -->
											<div class="card bg-dark mb-4">
												<!--Card content-->
												<div class="card-body">
													<center>
														<p class="display-4 mt-3 font-weight-bold">No Data</p>
														<a href="trainee.php"><button class="btn btn-primary">Go here</button></a>
													</center>
												</div>
											</div>
											<!-- Card -->
											</div>
										<?php } ?>
									</div>
										<?php if (ceil($total_pages_trainee / $num_results_on_page_trainee) > 0) { ?>
											<nav aria-label="Page_trainee navigation">
												<ul class="pagination pg-blue justify-content-center">
													<?php if ($page_trainee > 1) {?>
												    <li class="page-item ">
												      <a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee-1 ?>" tabindex="-1">Previous</a>
												    </li>
												    <?php } ?>

												    <?php if ($page_trainee > 3) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_trainee=1">1 </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_trainee-2 > 0) { ?>
												    <li class="page-item">
												      <a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee-2 ?>"><?php echo $page_trainee-2; ?> </a>
												    </li>
												    <?php } ?>

												    <?php if ($page_trainee-1 > 0) { ?>
												    <li class="page-item">
												    	<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee-1 ?>"><?php echo $page_trainee-1; ?></a>
												    </li>
												    <?php } ?>

												    <li class="page-item active">
												    	<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee ?>"><?php echo $page_trainee ?> <span class="sr-only">(current)</span></a>
												    </li>

												    <?php if ($page_trainee+1 < ceil($total_pages_trainee / $num_results_on_page_trainee)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee+1 ?>"><?php echo $page_trainee+1 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_trainee+2 < ceil($total_pages_trainee / $num_results_on_page_trainee)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee+2 ?>"><?php echo $page_trainee+2 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_trainee < ceil($total_pages_trainee / $num_results_on_page_trainee)-2) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo ceil($total_pages_trainee/ $num_results_on_page_trainee) ?>"><?php echo ceil($total_pages_trainee/ $num_results_on_page_trainee) ?></a>
														</li>
													<?php } ?>

												    <?php if ($page_trainee < ceil($total_pages_trainee / $num_results_on_page_trainee)) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_trainee=<?php echo $page_trainee+1 ?>">Next</a>
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
		</div>

		<!-- Departments Tab -->
		<div class="tab-pane fade show" id="department" role="tabpanel" aria-labelledby="department-tab">

			<div class="container-fluid" style="margin-top: 80px;">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<!-- Card Dark -->
						<div class="card">
							<!-- Card content -->
							<div class="card-body white-text rounded-bottom">
								<!-- Title -->
								<h4 class="card-title text-center text-black-50"> Department Overview</h4>
								<!-- Material input -->
								<div class="md-form">
									<input type="text" id="form1" class="form-control">
									<label for="form1">Search</label>
								</div>
								<div class="text-center">
									<button type="button" class="btn btn-primary">Search</button>
								</div>
								<!-- Body -->
								<div class="mt-5">
										<?php if (ceil($total_pages_department / $num_results_on_page_department) > 0) { ?>
											<nav aria-label="Page navigation">
												<ul class="pagination pg-blue justify-content-center">
													<?php if ($page_department > 1) {?>
														<li class="page-item ">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department-1 ?>" tabindex="-1">Previous</a>
														</li>
													<?php } ?>

													<?php if ($page_department > 3) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=1">1 </a>
														</li>
													<?php } ?>

													<?php if ($page_department-2 > 0) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department-2 ?>"><?php echo $page_department-2; ?> </a>
														</li>
													<?php } ?>

													<?php if ($page_department-1 > 0) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department-1 ?>"><?php echo $page_department-1; ?></a>
														</li>
													<?php } ?>

													<li class="page-item active">
														<a class="page-link" href="index.php?page_department=<?php echo $page_department ?>"><?php echo $page_department ?> <span class="sr-only">(current)</span></a>
													</li>

													<?php if ($page_department+1 < ceil($total_pages_department / $num_results_on_page_department)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department+1 ?>"><?php echo $page_department+1 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_department+2 < ceil($total_pages_department / $num_results_on_page_department)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department+2 ?>"><?php echo $page_department+2 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_department < ceil($total_pages_department / $num_results_on_page_department)-2) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo ceil($total_pages_department/ $num_results_on_page_department) ?>"><?php echo ceil($total_pages_department/ $num_results_on_page_department) ?></a>
														</li>
													<?php } ?>

													<?php if ($page_department < ceil($total_pages_department / $num_results_on_page_department)) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department+1 ?>">Next</a>
														</li>
													<?php } ?>

												</ul>
											</nav>
										<?php } ?>
									<div class="row">
										<?php if (mysqli_num_rows($result_department) > 0) { ?>

											<?php while($row = $result_department->fetch_assoc()) {
											$department_name = $row['department_name'];
											$username = $row['username'];
											$password = $row['password'];
										 ?>
										<div class="col-sm-12 col-md-6 col-lg-3">
											<!-- Card -->
											<div class="card bg-dark mb-4">
												<div class="card-header ">
													<h4 class="card-title text-white text-center"><?php echo $department_name; ?></h4>
												</div>
												<!--Card content-->
												<div class="card-body">
													  <ul class="list-group list-group-flush">
													    <li class="list-group-item text-body">User Name: <?php echo $username; ?></li>
													    <li class="list-group-item text-body">Password: <?php echo $password; ?></li>
													  </ul>
												</div>
												<div class="card-footer">
													<a href="department.php"><button class="btn btn-block btn-primary">Manage</button></a>
												</div>
											</div>
											<!-- Card -->
										</div>
									<?php } ?>
										<?php }
										else { ?>
											<div class="col-sm-12">
												<!-- Card -->
											<div class="card bg-dark mb-4">
												<!--Card content-->
												<div class="card-body">
													<center>
														<p class="display-4 mt-3 font-weight-bold">No Data</p>
														<a href="department.php"><button class="btn btn-primary">Go here</button></a>
													</center>
												</div>
											</div>
											<!-- Card -->
											</div>
										<?php } ?>
									</div>
										<?php if (ceil($total_pages_department / $num_results_on_page_department) > 0) { ?>
											<nav aria-label="Page navigation">
												<ul class="pagination pg-blue justify-content-center">
													<?php if ($page_department > 1) {?>
														<li class="page-item ">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department-1 ?>" tabindex="-1">Previous</a>
														</li>
													<?php } ?>

													<?php if ($page_department > 3) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=1">1 </a>
														</li>
													<?php } ?>

													<?php if ($page_department-2 > 0) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department-2 ?>"><?php echo $page_department-2; ?> </a>
														</li>
													<?php } ?>

													<?php if ($page_department-1 > 0) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department-1 ?>"><?php echo $page_department-1; ?></a>
														</li>
													<?php } ?>

													<li class="page-item active">
														<a class="page-link" href="index.php?page_department=<?php echo $page_department ?>"><?php echo $page_department ?> <span class="sr-only">(current)</span></a>
													</li>

													<?php if ($page_department+1 < ceil($total_pages_department / $num_results_on_page_department)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department+1 ?>"><?php echo $page_department+1 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_department+2 < ceil($total_pages_department / $num_results_on_page_department)+1) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department+2 ?>"><?php echo $page_department+2 ?></a>
														</li>
													<?php } ?>

													<?php if ($page_department < ceil($total_pages_department / $num_results_on_page_department)-2) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo ceil($total_pages_department/ $num_results_on_page_department) ?>"><?php echo ceil($total_pages_department/ $num_results_on_page_department) ?></a>
														</li>
													<?php } ?>

													<?php if ($page_department < ceil($total_pages_department / $num_results_on_page_department)) { ?>
														<li class="page-item">
															<a class="page-link" href="index.php?page_department=<?php echo $page_department+1 ?>">Next</a>
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
		</div>
	</div>
</main>

<?php include("footer.php"); ?>

</body>
</html>
<?php 
	$stmt_trainee->close();
 ?>