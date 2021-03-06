<form action="" method="post">
  <div class="modal fade" id="deleteModal<?php echo $trainee_id ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
  aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
      <!--Content-->
      <div class="modal-content text-center">
        <!--Header-->
        <div class="modal-header d-flex justify-content-center">
          <p class="heading">Do you want to delete <?php echo $first_name . ", " . $last_name; ?>?</p>
        </div>

        <div class="modal-body">

          <i class="fas fa-times fa-4x animated rotateIn"></i>

        </div>

        <div class="modal-footer flex-center">
          <a href="delete_trainee.php?id=<?php echo $trainee_id ?>&user_id=<?php echo $user_id ?>"><button type="button" class="btn btn-outline-danger">Yes</button></a>
          <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">No</a>
        </div>
      </div>
    </div>
  </div>
</form>
