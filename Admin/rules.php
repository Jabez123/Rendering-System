<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");

	$sql = "SELECT 
	rules_tb.rule_id, department_tb.department_name, 
	rules_tb.offense_code, rules_tb.offense_type, rules_tb.offense_input,
	rules_tb.offense_description FROM rules_tb INNER JOIN department_tb ON rules_tb.department_id = department_tb.department_id";

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
			<a href="add_rule.php"><button id="add_rules" class="btn btn-default">Add rule</button></a>
			
		</div>
		<div class="table-responsive">
			<table id="dtTable" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
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
						<th class="th-sm">Offense Input
						</th>
						<th class="th-sm">Description
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($result)) {
							$rule_id = $row['rule_id'];
							$department_name = $row['department_name'];
							$offense_code = $row['offense_code'];
							$offense_type = $row['offense_type'];
							$offense_input = $row['offense_input'];
							$offense_description = $row['offense_description'];
						 ?>
					<tr>
						<td>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-6 mb-3">
									<a href="edit_rule.php?id=<?php echo $rule_id; ?>&type_name=<?php echo $offense_type ?>">
										<button class="btn btn-block btn-primary"><i class="fas fa-edit"></i></button></a>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $rule_id ?>"><i class="fas fa-trash-alt"></i></button>
								</div>
							</div>
						</td>
						<td class="font-weight-bold"><?php echo $department_name;; ?></td>
						<td><?php echo $offense_code ?></td>
						<td><?php echo $offense_type; ?></td>
						<td><?php echo $offense_input ?></td>
						<td><?php echo $offense_description; ?></td>
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
						<th class="th-sm">Offense Input
						</th>
						<th class="th-sm">Description
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</main>
</div>

<?php include("footer.php"); ?>
<script> 
    window.onload = function() { 
        document.getElementById("add_rules").focus(); 
    } 
</script>
</body>
</html>