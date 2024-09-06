<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-admin.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input parameters
    $rollNo = filter_input(INPUT_POST, 'roll_no', FILTER_SANITIZE_STRING);
    $whichCommittee = filter_input(INPUT_POST, 'which_committee', FILTER_SANITIZE_STRING);

    if ($rollNo && $whichCommittee) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/committe.class.php";
        $committee = new Committe_class();

        // Insert committee member
        if ($committee->insertCommitteeMember($rollNo, $whichCommittee)) {
            header("Content-Type: application/json");
            echo json_encode(['Message' => 'Success']);
        } else {
            header("Content-Type: application/json");
            echo json_encode(['Message' => 'Failed']);
        }
    } else {
        header("Content-Type: application/json");
        echo json_encode(['Message' => 'Request not valid']);
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(['Message' => 'Invalid request method']);
}
