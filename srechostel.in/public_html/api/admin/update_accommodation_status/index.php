<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
/*
This part of the code checks if the request is made by an admin.
If yes, accept; else decline the request.
*/

if (isset($_SESSION['yourToken'])) {
    if (isset($_POST["id"]) && isset($_POST["status"])) {
        include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/accommodation.class.php";

        // Sanitize and validate inputs
        $staffId = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);
        $status = filter_var($_POST["status"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($staffId && $status !== null) {
            $accom = new accommodation();
            if ($status === true) {
                // Accept if status is true
                $result = $accom->acceptAccom($staffId);
            } else if ($status === false) {
                // Decline if status is false
                $result = $accom->declineAccom($staffId);
            }
        }
    }
}
