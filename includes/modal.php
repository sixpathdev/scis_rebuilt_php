<?php

if(isset($_POST["submit"])) {
    if(insertComplaint($user_id, $_POST["complaint_title"], $_POST["complaint_body"])) {
        $_SESSION["success_alert"] = true;
        echo "<script>window.location='complaints'</script>";
    }
}

?>

<div class="col-11 offset-1 mt-5 modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new complaint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="complaint_title" style="margin-bottom: -5px;">Complaint title</label>
                        <input type="text" name="complaint_title" class="form-control" id="complaint_title" placeholder="Short but brief title" />
                    </div>
                    <div class="form-group">
                        <label for="complaint_body" style="margin-bottom: -5px;">Complaint body</label>
                        <textarea class="form-control" name="complaint_body" id="" cols="30" rows="5" placeholder="Detailed complaint" style="padding-top: -10px;"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" id="submit_btn" class="btn custom_bg text-white px-4">Create</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
