<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "api/accounts/profile_photo/is-valid-person.php";


if (isset($_SESSION['yourToken'])) {
    header("Content-Type: image/jpg");
    $rollNo = $_SESSION['yourToken'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/" . $rollNo . '.jpg')) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/" . "../profile-photos/" . $rollNo . '.jpg';
    } else {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/dummy-profile.jpg";
    }
}

