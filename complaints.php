<?php
include("logic/utility.php");
require("./includes/header.php");

if(!isset($_SESSION["user_id"])) {
    header("location: /scis/");
}

if (isset($_GET["p"])) {
    $page = $_GET["p"];
} else {
    $page = 1;
}

$num_per_page = 8;
$start = ($page - 1) * $num_per_page;

$complaints = getComplaints($user_id, $start, $num_per_page);
$complaints = json_decode($complaints, true);

?>

<div class="container-fluid">
    <div class="row" style="margin-top: 56px;">
        <?php include("./includes/side_nav.php") ?>
        <div class="col-9 col-lg-10 mb-4 dashboard_card">
            <?php if (isset($_SESSION["success_alert"])) { ?>
                <div class="row">
                    <div class="col-12" id="success_alert">
                        <div class="mx-auto text-center mt-4 py-3" style="width: 300px; background-color: #00ff00; color: #fff;">Complaint created successfully</div>
                    </div>
                </div>
            <?php
                echo "<script>setTimeout(function() {
                document.getElementById('success_alert').style.display='none';
            }, 2000);</script>";
                unset($_SESSION["success_alert"]);
            } else if (isset($_SESSION["delete_success"])) { ?>
                <div class="row">
                    <div class="col-12" id="success_alert">
                        <div class="mx-auto text-center mt-4 py-3" style="width: 300px; background-color: #00ff00; color: #fff;">Complaint deleted successfully</div>
                    </div>
                </div>
            <?php
                echo "<script>setTimeout(function() {
            document.getElementById('success_alert').style.display='none';
        }, 2000);</script>";
                unset($_SESSION["delete_success"]);
            } ?>
            <div class="row mx-auto">
                <div class="col-12 col-md-4 my-3 ml-1 offset-lg-10">
                    <button class="btn custom_bg text-white" data-toggle="modal" data-target="#exampleModal">New complaint</button>
                </div>

                <!-- Modal -->
                <?php include("includes/modal.php"); ?>

                <!-- Body -->
                <?php if (!empty($complaints)) { ?>
                    <div class="my-3 ml-auto mr-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                //die(var_dump(json_decode(paginateComplaints(), true)));
                                paginateComplaints($page, $num_per_page)

                                ?>
                                <!-- <li class="page-item"><a class="page-link" href="#" style="color: #011627;">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#" style="color: #011627;">1</a></li>
                                <li class="page-item"><a class="page-link" href="#" style="color: #011627;">Next</a></li> -->
                            </ul>
                        </nav>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <?php for ($i = 0; $i < count($complaints); $i++) { ?>
                                <div class="col-12 col-lg-3 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title" style="margin-top: -10px;"><a href="view_complaint?id=<?php echo base64_encode($complaints[$i]["id"]) ?>" style="color: #011627;"><?php echo ucwords($complaints[$i]["complaint_title"]) ?></a></h6>
                                            <?php if ($complaints[$i]["reviewed"]) { ?>
                                                <span class="badge badge-success card-subtitle mb-1 text-muted" style="color: white !important;">reviewed</span>
                                            <?php } else { ?>
                                                <span class="badge badge-primary card-subtitle mb-1 text-muted" style="background-color: #0116279e; color: white !important;">not reviewed</span>
                                            <?php } ?>
                                            <p class="card-text text-muted"><?php echo substr($complaints[$i]["complaint_body"], 0, 95) ?>...</p>
                                            <a id="tickComplaint" href="view_complaint?id=<?php echo base64_encode($complaints[$i]["id"]) ?>" class="card-link" style="color: #011627; border: 0.8px solid #011627; border-radius: 3px; padding: 7px 12px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-12 text-center h5" style="color: #8e959a; margin-top: 12%;">No complaint created yet</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include("includes/scripts.php") ?>