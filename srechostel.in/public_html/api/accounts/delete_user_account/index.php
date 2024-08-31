<?php
# check the user is admin.
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

# receive the input from the admin and see what kind of of inputs is received.

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    print_r($_GET);
    $keys = array_keys($_GET);
    if ($keys[0] == "roll_no") {

    } else if ($keys[0] == "year") {

    } else if (in_array("dept", $keys) and in_array("year", $keys)) {

    } else if (in_array("group_of_roll_no", $keys)) {

    } else {
        header("Content-Type: application/json");
        echo '{"error":"Wrong payload values"}';
    }
} else {
    header("Content-Type: application/json");
    echo '{"error":"Method not allowed"}';
}
