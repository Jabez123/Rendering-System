<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("config/connectServer.php");
	require_once("config/connectDatabase.php");

	$sql = "SELECT 
	rules_tb.rule_id, department_tb.department_name, 
	rules_tb.offense_code, rules_tb.offense_type, 
	rules_tb.offense_description, rules_tb.is_grounded, 
	rules_tb.summaries, rules_tb.words, rules_tb.levitical_service FROM rules_tb INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id";

	$result = mysqli_query($conn, $sql);
 ?>



<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Rules</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container-fluid">
	<main class="mt-5">
		<div class="text-center">
			<a href="add_rule.php"><button class="btn btn-default">Add rule</button></a>
			
		</div>
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Department Name
						</th>
						<th class="th-sm">Offense Code
						</th>
						<th class="th-sm">Offense Type
						</th>
						<th class="th-sm">Description
						</th>
						<th class="th-sm">Grounded
						</th>
						<th class="th-sm">Summary
						</th>
						<th class="th-sm">Words
						</th>
						<th class="th-sm">Levitical Service
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$rule_id = $row['rule_id'];
							$department_name = $row['department_name'];
							$offense_code = $row['offense_code'];
							$offense_type = $row['offense_type'];
							$offense_description = $row['offense_description'];
							$is_grounded = $row['is_grounded'];
							$summaries = $row['summaries'];
							$words = $row['words'];
							$levitical_service = $row['levitical_service'];
						 ?>
					<tr>
						<td>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-6 mb-3">
									<a href="edit_rule.php?id=<?php echo $rule_id; ?>">
										<button class="btn btn-block btn-primary">Edit</button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $rule_id ?>">Delete</button>
								</div>
							</div>
						</td>
						<td class="font-weight-bold"><?php echo $department_name;; ?></td>
						<td><?php echo $offense_code ?></td>
						<td><?php echo $offense_type; ?></td>
						<td><?php echo $offense_description; ?></td>
						<td><?php echo $is_grounded; ?></td>
						<td><?php echo $summaries; ?></td>
						<td><?php echo $words; ?></td>
						<td><?php echo $levitical_service; ?></td>
					</tr>
					<?php include("delete_rule_modal.php"); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Department Name
						</th>
						<th class="th-sm">Offense Code
						</th>
						<th class="th-sm">Offense Type
						</th>
						<th class="th-sm">Description
						</th>
						<th class="th-sm">Grounded
						</th>
						<th class="th-sm">Summary
						</th>
						<th class="th-sm">Words
						</th>
						<th class="th-sm">Levitical Service
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