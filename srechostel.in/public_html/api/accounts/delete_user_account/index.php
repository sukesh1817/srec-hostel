<?php
# check the user is admin.
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

# receive the input from the admin and see what kind of of inputs is received.

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../class-files/" . "admin.class.php";
    $admin = new Admin();
    $keys = array_keys($_POST);
    $values = array_values($_POST);
    $resultValue = $admin->deleteUser($keys, $values);
    if ($resultValue[0] == "ACCOUNT_DELETED_SUCCESS_STUDENT") {
        $rollNo = $resultValue[1];
        header("Content-Type: application/json");
        echo '{"Message":"Account deletion success for' . (string)$rollNo . ' ","code":1}';
    } else if ($resultValue[0] == "ACCOUNT_DELETED_SUCCESS_STUDENT_GROUP") {
        header("Content-Type: application/json");
        echo '{"Message":"Account deletion success for group","code":1}';
    } else if ($resultValue[0] == "ACCOUNT_DELETED_FAILED_STUDENT") {
        $rollNo = $resultValue[1];
        header("Content-Type: application/json");
        echo '{"Message":"Account deletion failed for' . $rollNo . ' ","code":0}';

    } else if ($resultValue[0] == "ACCOUNT_DELETED_FAILED_STUDENT_GROUP") {
        header("Content-Type: application/json");
        echo '{"Message":"Account deletion failed for group","code":0}';

    } else {
        header("Content-Type: application/json");
        echo '{"error":"Wrong payload values","code":0}';
    }
} else {
    header("Content-Type: application/json");
    echo '{"error":"Method not allowed","code":0}';
}
