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
    if ($resultValue == "ACCOUNT_DELETED_SUCCESS_STUDENT") {
        header("Content-Type: application/json");
        echo '{"Message":"Account deletion success","code":1}';
    } else if ($resultValue == "ACCOUNT_DELETED_FAILED_STUDENT") {
        header("Content-Type: application/json");
        echo '{"Message":"Wrong payload values","code":0}';
    } else {
        header("Content-Type: application/json");
        echo '{"error":"Wrong payload values","code":0}';
    }
} else {
    header("Content-Type: application/json");
    echo '{"error":"Method not allowed","code":0}';
}
