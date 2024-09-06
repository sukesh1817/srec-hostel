<?php
// Check first if this is admin; if it is admin, allow it, else do not allow
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";


if ($isAdmin) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Filter and sanitize inputs
        $rollNo = filter_input(INPUT_POST, 'roll-no', FILTER_SANITIZE_STRING);
        $which = filter_input(INPUT_POST, 'which', FILTER_SANITIZE_STRING);

        if ($rollNo && $which) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/token.class.php";
            $token = new Token();
            $checked = $token->checkTheToken($rollNo, $which);

            header("Content-Type: application/json");
            if ($checked) {
                echo json_encode(['Message' => 'Token marked success']);
            } else {
                echo json_encode(['Message' => 'Token marked failed']);
            }
        } else {
            header("Content-Type: application/json");
            echo json_encode(['Message' => 'Wrong parameter']);
        }
    } else {
        header("Content-Type: application/json");
        echo json_encode(['Request' => 'Method not allowed']);
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(['Request' => 'Unauthorized']);
}
