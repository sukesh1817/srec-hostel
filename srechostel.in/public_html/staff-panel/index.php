<?php
/*
this code check wheather the login person is staff or not,
if staff proceed next,
else do not allow the person
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-staff.php";

//this is the header of the page
include_once $_SERVER['DOCUMENT_ROOT']. "/../template/staff-template/header.php";

//this is the body of the page
include_once $_SERVER['DOCUMENT_ROOT']. "/../template/staff-template/body.php";

//this is the footer of the page
include_once $_SERVER['DOCUMENT_ROOT']. "/../template/staff-template/footer.php";

?>

