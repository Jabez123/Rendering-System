<?php include("header.php"); ?>
<?php 
	// Include configs
	require_once("../config/connectServer.php");
	require_once("../config/connectDatabase.php");

	
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
		<div class="text-center">
			<a href="select_department.php"><button id="add_render" class="btn btn-default">Add Render</button></a>
		</div>
		<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
      aria-selected="true">All</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending"
      aria-selected="false">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="recorded-tab" data-toggle="tab" href="#recorded" role="tab" aria-controls="recorded"
      aria-selected="false">Recorded</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
  	<?php include("all.php"); ?>
    </div>
  <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
    <?php include("pending.php"); ?>
    </div>
  <div class="tab-pane fade" id="recorded" role="tabpanel" aria-labelledby="recorded-tab">
  	<?php include("recorded.php"); ?>
    </div>
</div>
	</main>
</div>

<?php include("footer.php"); ?>
<script> 
    window.onload = function() { 
        document.getElementById("add_render").focus(); 
    } 
</script>
</body>
</html>