<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT * FROM department_tb";

	$result = mysqli_query($conn, $sql);
 ?>
<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Departments</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container">
	<main class="mt-5">
		<div class="text-center">
			<a href="add_department.php"><button class="btn btn-default">Add Department</button></a>
		</div>
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Department Name
						</th>
						<th class="th-sm">Username
						</th>
						<th class="th-sm">Password
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$department_id = $row['department_id'];
							$department_name = $row['department_name'];
							$username = $row['username'];
							$password = $row['password'];
						 ?>
					<tr>
						<td>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-6 mb-3">
									<a href="edit_department.php?id=<?php echo $department_id; ?>">
										<button class="btn btn-block btn-primary">Edit</button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $department_id ?>">Delete</button>
								</div>
							</div>
						</td>
						<td><?php echo $department_name; ?></td>
						<td><?php echo $username; ?></td>
						<td><?php echo $password; ?></td>
					</tr>
					<?php include("delete_department_modal.php"); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Department Name
						</th>
						<th class="th-sm">Username
						</th>
						<th class="th-sm">Password
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