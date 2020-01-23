<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectDatabase.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT * FROM trainee_tb";

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
						<th class="th-sm">ID Name
						</th>
						<th class="th-sm">Gender
						</th>
						<th class="th-sm">Class
						</th>
						<th class="th-sm">Class Group
						</th>
						<th class="th-sm">Room
						</th>
						<th class="th-sm">Team
						</th>
						<th class="th-sm">Status
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$trainee_id = $row['trainee_id'];
							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							$id_name = $row['id_name'];
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
										<button class="btn btn-block btn-primary">Edit</button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $trainee_id ?>">Delete</button>
								</div>
							</div>
						</td>
						<td class="font-weight-bold"><?php echo $trainee_id;; ?></td>
						<td><?php echo $last_name . ", " . $first_name; ?></td>
						<td><?php echo $id_name; ?></td>
						<td><?php echo $gender; ?></td>
						<td><?php echo $class; ?></td>
						<td><?php echo $class_group; ?></td>
						<td><?php echo $room; ?></td>
						<td><?php echo $team; ?></td>
						<td><?php echo $status; ?></td>
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
						<th class="th-sm">ID Name
						</th>
						<th class="th-sm">Gender
						</th>
						<th class="th-sm">Class
						</th>
						<th class="th-sm">Class Group
						</th>
						<th class="th-sm">Room
						</th>
						<th class="th-sm">Team
						</th>
						<th class="th-sm">Status
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