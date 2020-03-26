<?php 
include("logic/utility.php");
require("./includes/header.php");

if(!isset($_SESSION["user_id"])) {
    header("location: /scis/");
}

?>

<div class="container-fluid">
    <div class="row" style="margin-top: 56px;">
        <?php include("./includes/side_nav.php") ?>
        <div class="col-9 col-lg-10 mb-4 dashboard_card">
            <div class="row mx-auto">
                <div class="col-lg-4 mt-4">
                    <div class="card" style="height: 200px; box-shadow: 8px 8px 10px #e6e6e6, -11px -11px 15px #ffffff;">
                        <div class="card-body bg-warning">
                            <h6 class="text-white font-weight-bold">TOTAL COMPLAINTS</h6>
                            <h4 class="text-center mt-4 text-white font-weight-bold"><?php echo count(json_decode(numOfComplaints($user_id),true)) ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4">
                    <div class="card" style="height: 200px; box-shadow: 8px 8px 10px #e6e6e6, -11px -11px 15px #ffffff;">
                        <div class="card-body bg-primary">
                            <h6 class="text-white">REVIEWED COMPLAINTS</h6>
                            <h4 class="text-center mt-4 text-white font-weight-bold"><?php echo count(json_decode(getreviewedComplaints($user_id),true)) ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4">
                    <div class="card" style="height: 200px; box-shadow: 8px 8px 10px #e6e6e6, -11px -11px 15px #ffffff;">
                        <div class="card-body bg-success">
                            <h6 class="text-white font-weight-bold">UNREVIEWED COMPLAINTS</h6>
                            <h4 class="text-center mt-4 text-white font-weight-bold"><?php echo count(json_decode(getunreviewedComplaints($user_id),true)) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("./includes/scripts.php") ?>