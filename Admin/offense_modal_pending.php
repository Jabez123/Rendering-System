<!-- Central Modal Medium Info -->
<div class="modal fade" id="pendingModal<?php echo $trainee_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><?php echo $gender; ?> <?php echo $id_name; ?>'s Offenses</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          
          <?php while ($row = mysqli_fetch_assoc($result_offense_list)) { 
            $offense_code = $row['offense_code'];
            $offense_type = $row['offense_type'];
            $offense_description = $row['offense_description'];
          ?>
          <li class="list-group-item text-body">
            <p><?php echo $offense_code; ?>: <?php echo $offense_type ?> - <?php echo $offense_description ?></p>
          </li>
          <?php } ?>
        </ul>
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