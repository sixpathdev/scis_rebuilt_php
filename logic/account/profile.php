<?php

function getComplaints($user_id, $start, $num_per_page)
{
    global $db;
    // global $user_id;
    return $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints` WHERE auth_id = ? LIMIT $start,$num_per_page", array($user_id));
}

function numOfComplaints($user_id) {
    global $db;
    return $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints`");
}

function paginateComplaints($page, $num_per_page)
{
    global $db;
    $totalRecords = $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints`");
    $totalRecords = json_decode($totalRecords);
    $totalPages = ceil(count($totalRecords) / $num_per_page);

    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="complaints?p=' . (int) ($page - 1) . '">Previous</a></li>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='complaints?p=" . $i . "'>" . $i . "</a></li>";
    }

    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="complaints?p=' . (int) ($page + 1) . '">Next</a></li>';
    }
}

function paginateReviewedComplaints($page, $num_per_page)
{
    global $db;
    $totalRecords = $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints` WHERE reviewed = ?", array(1));
    $totalRecords = json_decode($totalRecords);
    $totalPages = ceil(count($totalRecords) / $num_per_page);

    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="complaints?p=' . (int) ($page - 1) . '">Previous</a></li>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='complaints?p=" . $i . "'>" . $i . "</a></li>";
    }

    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="complaints?p=' . (int) ($page + 1) . '">Next</a></li>';
    }
}

function paginateUnReviewedComplaints($page, $num_per_page)
{
    global $db;
    $totalRecords = $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints` WHERE reviewed = ?", array(0));
    $totalRecords = json_decode($totalRecords);
    $totalPages = ceil(count($totalRecords) / $num_per_page);

    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="complaints?p=' . (int) ($page - 1) . '">Previous</a></li>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='complaints?p=" . $i . "'>" . $i . "</a></li>";
    }

    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="complaints?p=' . (int) ($page + 1) . '">Next</a></li>';
    }
}

function getComplaint($user_id, $complaint_id)
{
    global $db;
    return $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints` WHERE auth_id = ? AND id = ?", array($user_id, $complaint_id));
}

function getreviewedComplaints($user_id)
{
    global $db;
    return $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints` WHERE reviewed = ? AND auth_id = ?", array(1, $user_id));
}

function getunreviewedComplaints($user_id)
{
    global $db;
    return $db->JsonBuilder()->rawQuery("SELECT * FROM `complaints` WHERE reviewed = ? AND auth_id = ?", array(0, $user_id));
}

function insertComplaint($user_id, $complaint_title, $complaint_body)
{
    global $db;

    $complaint_array = array(
        "auth_id" => $user_id,
        "complaint_title" => $complaint_title,
        "complaint_body" => $complaint_body
    );
    $db->insert('complaints', $complaint_array);
    return true;
}

function updateComplaint($user_id, $complaint_id, $complaint_title, $complaint_body)
{
    global $db;
    // global $user_id;
    return $db->JsonBuilder()->rawQuery("UPDATE `complaints` SET complaint_title = ?, complaint_body = ? WHERE auth_id = ? AND id = ?", array($complaint_title, $complaint_body, $user_id, $complaint_id));
}

function tickReviewed($auth_id, $complaint_id)
{
    global $db;
    return $db->JsonBuilder()->rawQuery("UPDATE `complaints` SET reviewed = ? WHERE auth_id = ? AND id = ?", array(1, $auth_id, $complaint_id));
}

function deleteComplaint($user_id, $complaint_id)
{
    global $db;
    return $db->JsonBuilder()->rawQuery("DELETE FROM `complaints` WHERE auth_id = ? AND id = ?", array($user_id, $complaint_id));
}
