<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input parameters
    $rollNo = filter_input(INPUT_POST, 'roll-no', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $action = filter_input(INPUT_POST, 'action', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    $whoIs = filter_input(INPUT_POST, 'who_is', FILTER_SANITIZE_STRING);

    if ($rollNo && $type && $action !== null && $whoIs) {
        $pass = new Pass_class();

        if ($action === true) {
            // Action to accept the pass
            $result = $pass->acceptThePass($rollNo, $type, $whoIs);
            header("Content-Type: application/json");
            echo json_encode(['Message' => $result ? 'Pass successfully accepted' : 'Pass acceptance failed']);
        } else {
            // Action to decline the pass
            $result = $pass->declineThePass($rollNo, $type, $whoIs);
            header("Content-Type: application/json");
            echo json_encode(['Message' => $result ? 'Pass successfully declined' : 'Pass decline failed']);
        }
    } else {
        header("Content-Type: application/json");
        echo json_encode(['Message' => 'Invalid parameters']);
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(['Message' => 'Invalid request method']);
}
