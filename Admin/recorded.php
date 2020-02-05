<?php 
	$sql = "SELECT trainee_tb.trainee_id, week_tb.week_num, 
		trainee_tb.first_name, trainee_tb.last_name, trainee_tb.gender, trainee_tb.id_name,
		rules_tb.offense_type,
		MAX(trainee_render_tb.current_summaries), MAX(trainee_render_tb.words), trainee_render_tb.is_grounded,
		MAX(trainee_render_tb.levitical_service)
		FROM trainee_render_tb 
		INNER JOIN current_render_tb ON current_render_tb.c_render_id = trainee_render_tb.c_render_id
		INNER JOIN trainee_tb ON current_render_tb.trainee_id = trainee_tb.trainee_id 
		INNER JOIN department_tb ON current_render_tb.department_id = department_tb.department_id
		INNER JOIN rules_tb ON current_render_tb.rule_id = rules_tb.rule_id
		INNER JOIN week_tb ON current_render_tb.week_id = week_tb.week_id";

	$result = mysqli_query($conn, $sql);
 ?>

<div class="table-responsive">
			<table id="dtRecorded" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
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
						<th class="th-sm">Grounded
						</th>
						<th class="th-sm">Summaries
						</th>
						<th class="th-sm">Words
						</th>
						<th class="th-sm">Levitical Service
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
							$is_grounded = $row['is_grounded'];
							$current_summaries = $row['MAX(trainee_render_tb.current_summaries)'];
							$words = $row['MAX(trainee_render_tb.words)'];
							$levitical_service = $row['MAX(trainee_render_tb.levitical_service)'];

							if ($gender == "Brother") {
								$gender = "Bro.";
							}
							else if ($gender == "Sister") {
								$gender = "Sis.";
							}
							$offense_type = $row['offense_type'];

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
									<a href="edit_render.php?id_rule=<?php echo $rule_id ?>&id_trainee=<?php echo $trainee_id ?>&render_code=<?php echo $render_code ?>">
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
						<td><?php echo $is_grounded ?></td>
						<td><?php echo $current_summaries ?></td>
						<td><?php echo $words ?></td>
						<td><?php echo $levitical_service ?></td>
						<td><button type="button" class="btn btn-block btn-secondary" data-toggle="modal" data-target="#recordedModal<?php echo $trainee_id ?>">Offense List</button></td>
					</tr>
					<?php include("delete_render_modal.php"); ?>
					<?php include("offense_modal_recorded.php"); ?>
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
						<th class="th-sm">Grounded
						</th>
						<th class="th-sm">Summaries
						</th>
						<th class="th-sm">Words
						</th>
						<th class="th-sm">Levitical Service
						</th>
						<th class="th-sm">See Offense
						</th>
					</tr>
				</tfoot>
			</table>
		</div>