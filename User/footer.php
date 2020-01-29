<!-- Footer -->
<footer class="page-footer font-small unique-color mt-5 footer text-center pt-4">

  <!-- Footer Links -->
  <div class="container-fluid text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-6 mt-md-0 mt-3">

        <!-- Content -->
        <h5 class="text-uppercase">Verses:</h5>
        <p id="verses"></p>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none pb-3">

      <!-- Grid column -->
      <div class="col-md-3 mb-md-0 mb-3">

      <!-- Grid column -->
      <div class="col-md-3 mb-md-0 mb-3">

        <!-- Links -->
        <h5 class="text-uppercase">Links</h5>

        <ul class="list-unstyled">
          <li>
        	<a href="index.php">Home</a>
          </li>
          <li>
            <a href="render.php">Render</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="index.php"> Render System</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->


<script type="text/javascript" src="../dist/js/jquery.js"></script>
<script type="text/javascript" src="../dist/js/popper.js"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<script type="text/javascript" src="../dist/js/mdb.js"></script>
<!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="../dist/js/addons/datatables.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript" src="../dist/js/other.js"></script>
<script type="text/javascript">
	var verses = [
    'Sample 1',
    'Sample 2',
    'Sample 3'
];
var randomNumber = Math.floor(Math.random() * verses.length);
	document.getElementById("verses").innerHTML = verses[randomNumber];
</script>