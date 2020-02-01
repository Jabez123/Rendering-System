<!-- Central Modal Medium Info -->
<div class="modal fade" id="modalInfo<?php echo $trainee_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><?php echo $gender; ?> <?php echo $username; ?>'s Info</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item text-body">Team: <?php echo $team ?></li>
              <li class="list-group-item text-body">Class: <?php echo $class ?></li>
              <li class="list-group-item text-body">Class Group: <?php echo $class_group ?></li>
              <li class="list-group-item text-body">Room: <?php echo $room ?></li>
              <li class="list-group-item text-body">Locality: <?php echo $locality ?></li>
              <li class="list-group-item text-body">Region: <?php echo $region ?></li>
            </ul>
          </div>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-dark waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Central Modal Medium Info-->