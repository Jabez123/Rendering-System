<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT render_tb.render_id, rules_tb.rule_id, 
	trainee_tb.trainee_id, trainee_tb.first_name, trainee_tb.last_name, trainee_tb.id_name,
	department_tb.department_name,
	rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_description,
	rules_tb.is_grounded, rules_tb.summaries, rules_tb.words, rules_tb.levitical_service,
	render_tb.render_date
	FROM render_tb 
	INNER JOIN trainee_tb ON trainee_tb.trainee_id = render_tb.trainee_id
	INNER JOIN rules_tb ON rules_tb.rule_id = render_tb.rule_id
	INNER JOIN department_tb ON department_tb.department_id = render_tb.department_id";

	$result = mysqli_query($conn, $sql);
 ?>



<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8 col-lg-12">
				<div class="card text-white bg-dark pt-3 pb-3">
				  	<div class="card-body text-center">
				    	<h1 class="card-title">Render</h1>
				  	</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
<div class="container-fluid">
	<main class="mt-5">
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Trainee ID
						</th>
						<th class="th-sm">Date
						</th>
						<th class="th-sm">Name
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
							$render_id = $row['render_id'];
							$trainee_id = $row['trainee_id'];
							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							$render_date = $row['render_date'];
							$id_name = $row['id_name'];
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
									<a href="edit_render.php?id=<?php echo $render_id; ?>">
										<button class="btn btn-block btn-primary">Edit</button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $render_id ?>">Delete</button>
								</div>
							</div>
						</td>
						<td class="font-weight-bold"><?php echo $trainee_id; ?></td>
						<td><?php echo $render_date; ?></td>
						<td><?php echo $last_name; ?>, <?php echo $first_name; ?></td>
						<td><?php echo $offense_code ?></td>
						<td><?php echo $offense_type; ?></td>
						<td><?php echo $offense_description; ?></td>
						<td><?php echo $is_grounded; ?></td>
						<td><?php echo $summaries; ?></td>
						<td><?php echo $words; ?></td>
						<td><?php echo $levitical_service; ?></td>
					</tr>
					<?php include("delete_render_modal.php"); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Trainee ID
						</th>
						<th class="th-sm">Date
						</th>
						<th class="th-sm">Name
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