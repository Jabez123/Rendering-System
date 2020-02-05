<?php 
	$sql = "SELECT DISTINCT trainee_tb.trainee_id, week_tb.week_num, 
		trainee_tb.first_name, trainee_tb.last_name, trainee_tb.gender, trainee_tb.id_name
		FROM current_render_tb 
		INNER JOIN trainee_tb ON current_render_tb.trainee_id = trainee_tb.trainee_id 
		INNER JOIN department_tb ON current_render_tb.department_id = department_tb.department_id
		INNER JOIN rules_tb ON current_render_tb.rule_id = rules_tb.rule_id
		INNER JOIN week_tb ON current_render_tb.week_id = week_tb.week_id";

	$result = mysqli_query($conn, $sql);
 ?>

<div class="table-responsive">
			<table id="dtAll" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Week
						</th>
						<th class="th-sm">Trainee ID
						</th>
						<th class="th-sm">Name
						</th>
						<th class="th-sm">See Offense
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$trainee_id = $row['trainee_id'];
							$week_num = $row['week_num'];
							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							$id_name = $row['id_name'];
							$gender = $row['gender'];

							if ($gender == "Brother") {
								$gender = "Bro.";
							}
							else if ($gender == "Sister") {
								$gender = "Sis.";
							}

							$sql_offense_list = "SELECT week_tb.week_num, trainee_tb.first_name, trainee_tb.last_name,
							rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_description, current_render_tb.render_num
							FROM current_render_tb 
							INNER JOIN trainee_tb ON current_render_tb.trainee_id = trainee_tb.trainee_id
							INNER JOIN rules_tb ON current_render_tb.rule_id = rules_tb.rule_id 
							INNER JOIN week_tb ON current_render_tb.week_id = week_tb.week_id
							WHERE trainee_tb.trainee_id = '$trainee_id'";

							$result_offense_list = mysqli_query($conn, $sql_offense_list);
						 ?>
					<tr>
						<td>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-6 mb-3">
									<a href="edit_render.php?id_rule=<?php echo $rule_id ?>&id_trainee=<?php echo $trainee_id ?>">
										<button class="btn btn-block btn-primary"><i class="fas fa-edit"></i></button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $trainee_id ?>"><i class="fas fa-trash-alt"></i></button>
								</div>
							</div>
						</td>
						<td><?php echo $week_num; ?></td>
						<td class="font-weight-bold"><?php echo $trainee_id; ?></td>
						<td><?php echo $last_name; ?>, <?php echo $first_name; ?></td>
						<td><?php if (mysqli_num_rows($result_offense_list) == 0) { ?>
							No Offenses
							<?php } else { ?>
								<button type="button" class="btn btn-block btn-secondary" data-toggle="modal" data-target="#allModal<?php echo $trainee_id ?>">Offense List</button>
							<?php } ?>
						</td>
					</tr>
					<?php include("delete_render_modal.php"); ?>
					<?php include("offense_modal_all.php"); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="th-sm">Action
						</th>
						<th class="th-sm">Week
						</th>
						<th class="th-sm">Trainee ID
						</th>
						<th class="th-sm">Name
						</th>
						<th class="th-sm">See Offense
						</th>
					</tr>
				</tfoot>
			</table>
		</div>