<?php 
	// Include configs
	require_once("config/connectServer.php");
	require_once("config/connectDatabase.php");

	$sql = "SELECT * FROM trainee_tb";

	$result = mysqli_query($conn, $sql);
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
			<a class="nav-link" id="incharge-tab" data-toggle="tab" href="#incharge" role="tab" aria-controls="profile"
			aria-selected="false">Department Overview</a>
		</li>
	</ul>
	<div class="tab-content" id="dashboardTabContent">
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
									<div class="row">
										<?php if (mysqli_num_rows($result) > 0) { ?>

											<?php while($row = mysqli_fetch_assoc($result)) {
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
								</div>
							</div>
						</div>
						<!-- Card Dark -->
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="incharge" role="tabpanel" aria-labelledby="profile-tab">
			
			<div class="container" style="margin-top: 80px;">
				<div class="row">
					<div class="col-12">
						<!-- Card Dark -->
						<div class="card">
							<!-- Card content -->
							<div class="card-body elegant-color white-text rounded-bottom">
								<!-- Title -->
								<h4 class="card-title text-center"> Department Overview</h4>
								<hr class="hr-light">
								<!-- Body -->
								<div class="container-fluid">
									<div class="row">
										<div class="col-sm-12">

											<div class="card mb-4">
												<div class="card-body">
													<!-- Material input -->
													<div class="md-form">
														<input type="text" id="form1" class="form-control">
														<label for="form1">Search</label>
													</div>
													<div class="text-center">
														<button type="button" class="btn btn-primary">Search</button>
													</div>

												</div>
											</div>

										</div>
										<div class="col-sm-4">
											<!-- Card -->
											<div class="card mb-4">
												<!--Card content-->
												<div class="card-body">

													<!--Title-->
													<h4 class="card-title">Card title</h4>
													<!--Text-->
													<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
													<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
													<button type="button" class="btn btn-light-blue btn-md">Read more</button>

												</div>

											</div>
											<!-- Card -->
										</div>

										<div class="col-sm-4">
											<!-- Card -->
											<div class="card mb-4">
												<!--Card content-->
												<div class="card-body">

													<!--Title-->
													<h4 class="card-title">Card title</h4>
													<!--Text-->
													<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
													<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
													<button type="button" class="btn btn-light-blue btn-md">Read more</button>

												</div>

											</div>
											<!-- Card -->
										</div>

										<div class="col-sm-4">
											<!-- Card -->
											<div class="card mb-4">
												<!--Card content-->
												<div class="card-body">

													<!--Title-->
													<h4 class="card-title">Card title</h4>
													<!--Text-->
													<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
													<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
													<button type="button" class="btn btn-light-blue btn-md">Read more</button>

												</div>

											</div>
											<!-- Card -->
										</div>

										<div class="col-sm-4">
											<!-- Card -->
											<div class="card mb-4">
												<!--Card content-->
												<div class="card-body">

													<!--Title-->
													<h4 class="card-title">Card title</h4>
													<!--Text-->
													<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
													<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
													<button type="button" class="btn btn-light-blue btn-md">Read more</button>

												</div>

											</div>
											<!-- Card -->
										</div>

										<div class="col-sm-4">
											<!-- Card -->
											<div class="card mb-4">
												<!--Card content-->
												<div class="card-body">

													<!--Title-->
													<h4 class="card-title">Card title</h4>
													<!--Text-->
													<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
													<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
													<button type="button" class="btn btn-light-blue btn-md">Read more</button>

												</div>

											</div>
											<!-- Card -->
										</div>

										<div class="col-sm-4">
											<!-- Card -->
											<div class="card mb-4">
												<!--Card content-->
												<div class="card-body">

													<!--Title-->
													<h4 class="card-title">Card title</h4>
													<!--Text-->
													<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
													<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
													<button type="button" class="btn btn-light-blue btn-md">Read more</button>

												</div>

											</div>
											<!-- Card -->
										</div>


									</div>
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