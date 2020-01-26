<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT * FROM type_tb";

	$result = mysqli_query($conn, $sql);
 ?>



<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Types</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container-fluid">
	<main class="mt-5">
		<div class="text-center">
			<a href="add_type.php"><button class="btn btn-default">Add type</button></a>
			
		</div>
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Type Name
						</th>
						<th class="th-sm">Offense
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$type_id = $row['type_id'];
							$type_name = $row['type_name'];
							$offense = $row['offense'];
						 ?>
					<tr>
						<td>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-6 mb-3">
									<a href="edit_type.php?id=<?php echo $type_id; ?>">
										<button class="btn btn-block btn-primary">Edit</button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $type_id ?>">Delete</button>
								</div>
							</div>
						</td>
						<td class="font-weight-bold"><?php echo $type_name;; ?></td>
						<td><?php echo $offense ?></td>
					</tr>
					<?php include("delete_type_modal.php"); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Type Name
						</th>
						<th class="th-sm">Offense
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