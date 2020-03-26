<?php
include("logic/utility.php");
require("./includes/header.php");

if(!isset($_SESSION["user_id"])) {
    header("location: /scis/");
}

// $user_id = $_SESSION["user_id"];



if (isset($_GET["p"])) {
    $page = $_GET["p"];
} else {
    $page = 1;
}

$num_per_page = 8;
$start = ($page - 1) * $num_per_page;

// $complaints = getComplaints($user_id, $start, $num_per_page);
$complaints = getreviewedComplaints($user_id);
$complaints = json_decode($complaints, true);

?>

<div class="container-fluid">
    <div class="row" style="margin-top: 56px;">
        <?php include("./includes/side_nav.php") ?>
        <div class="col-9 col-lg-10 mb-4 dashboard_card">
            <div class="row mx-auto">
                <div class="col-12 col-md-4 my-3 ml-1 offset-lg-10">
                    <button class="btn custom_bg text-white" data-toggle="modal" data-target="#exampleModal">New complaint</button>
                </div>

                <!-- Modal -->
                <?php //include("includes/modal.php"); ?>

                <!-- Body -->
                <?php if (!empty($complaints)) { ?>
                    <div class="my-3 ml-auto mr-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                //die(var_dump(json_decode(paginateComplaints(), true)));
                                paginateReviewedComplaints($page, $num_per_page)

                                ?>
                                <!-- <li class="page-item"><a class="page-link" href="#" style="color: #011627;">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#" style="color: #011627;">1</a></li>
                                <li class="page-item"><a class="page-link" href="#" style="color: #011627;">Next</a></li> -->
                            </ul>
                        </nav>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <?php for($i=0; $i < count($complaints); $i++) { ?>
                            <div class="col-12 col-lg-3 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                    <h6 class="card-title" style="margin-top: -10px;"><a href="view_complaint?id=<?php echo base64_encode($complaints[$i]["id"]) ?>" style="color: #011627;"><?php echo ucwords($complaints[$i]["complaint_title"]) ?></a></h6>
                                        <span class="badge badge-success card-subtitle mb-1 text-muted" style="color: white !important;">reviewed</span>
                                        <p class="card-text text-muted"><?php echo substr($complaints[$i]["complaint_body"], 0, 95) ?>...</p>
                                        <a href="view_complaint?id=<?php echo base64_encode($complaints[$i]["id"]) ?>" class="card-link" style="color: #011627; border: 0.8px solid #011627; border-radius: 3px; padding: 7px 12px;">View</a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-12 text-center h5" style="color: #8e959a; margin-top: 12%;">No reviewed complaints created yet</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include("./includes/scripts.php") ?>