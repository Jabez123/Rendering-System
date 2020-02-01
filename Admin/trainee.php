<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectDatabase.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT trainee_tb.trainee_id, trainee_tb.user_id, 
	trainee_tb.first_name, trainee_tb.last_name, trainee_tb.gender, trainee_tb.class,
	trainee_tb.class_group, trainee_tb.room, trainee_tb.team, 
	trainee_tb.status, trainee_tb.locality, trainee_tb.region,
	users_tb.username, users_tb.password
	 FROM trainee_tb INNER JOIN users_tb ON trainee_tb.user_id = users_tb.user_id";

	$result = mysqli_query($conn, $sql);
 ?>



<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Trainees</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container-fluid">
	<main class="mt-5">
		<div class="text-center">
			<a href="add_trainee.php"><button class="btn btn-default">Add Trainee</button></a>
		</div>
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">ID
						</th>
						<th class="th-sm">Full Name
						</th>
						<th class="th-sm">Class
						</th>
						<th class="th-sm">ID Name / Username
						</th>
						<th class="th-sm">Password
						</th>
						<th class="th-sm">More Info
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$trainee_id = $row['trainee_id'];
							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							$username = $row['username'];
							$password = $row['password'];
							$gender = $row['gender'];
							$class = $row['class'];
							$class_group = $row['class_group'];
							$room = $row['room'];
							$team = $row['team'];
							$status = $row['status'];
						 ?>
					<tr>
						<td>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-6 mb-3">
									<a href="edit_trainee.php?id=<?php echo $trainee_id; ?>">
										<button class="btn btn-block btn-primary"><i class="fas fa-edit"></i></button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $trainee_id ?>"><i class="fas fa-trash-alt"></i></button>
								</div>
							</div>
						</td>
						<td class="font-weight-bold"><?php echo $trainee_id;; ?></td>
						<td><?php echo $gender ?>. <?php echo $last_name . ", " . $first_name; ?></td>
						<td><?php echo $class ?></td>
						<td><?php echo $username; ?></td>
						<td><?php echo $password; ?></td>
						<td><button class="btn btn-block btn-info">More Info</button></td>
					</tr>
					<?php include("delete_trainee_modal.php"); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">ID
						</th>
						<th class="th-sm">Full Name
						</th>
						<th class="th-sm">ID Name / Username
						</th>
						<th class="th-sm">More Info
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</main>
</div>

<?php include("footer.php"); ?>
</body>
</html>