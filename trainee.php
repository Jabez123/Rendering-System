<?php include("header.php"); ?>
<div class="container">
	<main class="mt-5">
		<div class="text-center">
			<button class="btn btn-primary">Add a Trainee</button>
		</div>
		<div class="table-responsive">
			<table id="dtTrainees" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">Name
						</th>
						<th class="th-sm">Position
						</th>
						<th class="th-sm">Office
						</th>
						<th class="th-sm">Age
						</th>
						<th class="th-sm">Start date
						</th>
						<th class="th-sm">Salary
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Donna Snider</td>
						<td>Customer Support</td>
						<td>New York</td>
						<td>27</td>
						<td>2011/01/25</td>
						<td>$112,000</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th>Name
						</th>
						<th>Position
						</th>
						<th>Office
						</th>
						<th>Age
						</th>
						<th>Start date
						</th>
						<th>Salary
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	
</main>

<script type="text/javascript" src="dist/js/jquery.js"></script>
<script type="text/javascript" src="dist/js/popper.js"></script>
<script type="text/javascript" src="dist/js/bootstrap.js"></script>
<script type="text/javascript" src="dist/js/mdb.js"></script>
<!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="dist/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="dist/js/other.js"></script>
</body>
</html>