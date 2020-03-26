<?php
require("./includes/header.php");
include("logic/utility.php");

if(!isset($_SESSION["user_id"])) {
    header("location: /scis/");
}

// $user_id = $_SESSION["user_id"];

if (isset($_GET["id"])) {
    $complaint = getComplaint($user_id, base64_decode($_GET["id"]));
    $complaint = json_decode($complaint, true);
}

if (isset($_POST["edit_post"])) {
    updateComplaint($user_id, base64_decode($_GET["id"]), $_POST["complaint_title"], $_POST["complaint_body"]);
    $_SESSION["edit_success_alert"] = true;
    header("location: view_complaint?id=" . $_GET["id"]);
}

?>

<div class="container-fluid">
    <div class="row" style="margin-top: 56px;">
        <?php include("./includes/side_nav.php") ?>
        <div class="col-9 col-lg-5 offset-lg-2 mt-4 mb-4 dashboard_card">
            <form method="post">
                <div class="form-group">
                    <label for="complaint_title" style="margin-bottom: -5px;">Complaint title</label>
                    <input type="text" name="complaint_title" class="form-control" id="complaint_title" placeholder="Short but brief title" value="<?php echo $complaint[0]["complaint_title"] ?>" />
                </div>
                <div class="form-group">
                    <label for="complaint_body" style="margin-bottom: -5px;">Complaint body</label>
                    <textarea class="form-control" name="complaint_body" id="" cols="30" rows="5" placeholder="Detailed complaint" style="padding-top: -10px;"><?php echo $complaint[0]["complaint_body"] ?></textarea>
                </div>
                <button type="submit" name="edit_post" id="submit_btn" class="btn custom_bg text-white px-4">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include("./includes/scripts.php") ?>