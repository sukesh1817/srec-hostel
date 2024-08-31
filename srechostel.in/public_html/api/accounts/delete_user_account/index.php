<?php
# check the user is admin.
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

# receive the input from the admin and see what kind of of inputs is received.

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../class-files/" . "admin.class.php";
    $admin = new Admin();
    $keys = array_keys($_GET);
    $values = array_values($_GET);
    if ($admin->deleteUser($keys, $values)) {

    } else {
        header("Content-Type: application/json");
        echo '{"error":"Wrong payload values"}';
    }
} else {
    header("Content-Type: application/json");
    echo '{"error":"Method not allowed"}';
}
