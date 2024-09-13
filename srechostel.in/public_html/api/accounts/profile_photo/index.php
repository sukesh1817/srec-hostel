<?php
session_start();
if (isset($_SESSION['yourToken'])) {
    // header("Content-Type: image/jpg");
    $rollNo = $_SESSION['yourToken'];
    echo "hello";
    echo $_SERVER['DOCUMENT_ROOT'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/" . $rollNo . '.jpg')) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/" . "../profile-photos/" . $rollNo . '.jpg';
    } else {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/dummy-profile.jpg";
    }

}

