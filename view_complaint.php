<?php
include("logic/utility.php");
require("./includes/header.php");

if(!isset($_SESSION["user_id"])) {
    header("location: /scis/");
}

if (isset($_GET["id"])) {
    $complaint_id = base64_decode($_GET["id"]);
    tickReviewed($user_id, $complaint_id);
    $complaint = json_decode(getComplaint($user_id, $complaint_id), TRUE);
}

if (isset($_POST["delete"])) {
    $complaint_id = base64_decode($_POST["id"]);
    deleteComplaint($user_id, $complaint_id);
    $_SESSION["delete_success"] = true;
    echo "<script>window.location='complaints'</script>";
}

?>

<div class="container-fluid">
    <div class="row" style="margin-top: 56px;">
        <?php include("./includes/side_nav.php") ?>
        <div class="col-9 mx-auto col-lg-11" style="position: relative; left: 8%;">
            <div class="row">
                <div class="card col-12 col-lg-8 mt-3 mt-md-5 mx-auto pb-3">
                    <div class="card-body">
                        <h4 class="text-center"><?php echo $complaint[0]["complaint_title"] ?></h4>
                        <hr />
                        <p class="text-left"><?php echo $complaint[0]["complaint_body"] ?></p>
                        <small class="mt-4 float-right">Posted on <?php echo date("j, F Y", strtotime($complaint[0]["created_at"])) ?></small>
                    </div>
                    <div class="row">
                        <div class="col-5 col-lg-3 offset-1 offset-md-2 offset-lg-3">
                            <button class="btn custom_bg text-white px-4 ml-auto" onclick="window.location='edit_complaint?id=<?php echo base64_encode($complaint[0]['id']) ?>'">Edit</button>
                        </div>
                        <div class="col-5 col-lg-3">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo base64_encode($complaint[0]["id"]) ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("./includes/scripts.php") ?>