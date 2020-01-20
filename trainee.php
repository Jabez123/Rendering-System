<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("config/connectServer.php");
	require_once("config/connectDatabase.php");

	$sql = "SELECT * FROM trainee_tb";

	$result = mysqli_query($conn, $sql);
 ?>



<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-header">Trainees</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container">
	<main class="mt-5">
		<div class="text-center">
			<a href="add_trainee.php"><button class="btn btn-primary">Add a Trainee</button></a>
		</div>
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">ID
						</th>
						<th class="th-sm">Full Name
						</th>
						<th class="th-sm">ID NAme
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
						<td><?php echo $trainee_id;; ?></td>
						<td><?php echo $last_name . " " . $first_name; ?></td>
						<td><?php echo $id_name; ?></td>
						<td><?php echo $gender; ?></td>
						<td><?php echo $class; ?></td>
						<td><?php echo $class_group; ?></td>
						<td><?php echo $room; ?></td>
						<td><?php echo $team; ?></td>
						<td><?php echo $status; ?></td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">ID
						</th>
						<th class="th-sm">Full Name
						</th>
						<th class="th-sm">ID NAme
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
	</div>

	
</main>

<?php include("footer.php"); ?>
</body>
</html>