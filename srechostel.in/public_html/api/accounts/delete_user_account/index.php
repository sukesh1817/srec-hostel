<?php
# check the user is admin.
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

# receive the input from the admin and see what kind of of inputs is received.

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

} else {
    header("Content-Type: application/json");
    echo'{"error":"Method not allowed"}';

}
