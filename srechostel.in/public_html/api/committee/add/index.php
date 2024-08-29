<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-admin.php";

if (isset($_POST['roll_no']) and isset($_POST['which_committee'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/committe.class.php";
    $committee = new Committe_class();
    if ($committee->insertCommitteeMember($_POST['roll_no'], $_POST['which_committee'])) {
        header("Content-Type:application/json");
        echo '{"Message":"Success"}';
    } else {
        header("Content-Type:application/json");
        echo '{"Message":"Failed"}';
    }
} else {
    header("Content-Type:application/json");
    echo '{"Message":"Request not valid"}';
}
