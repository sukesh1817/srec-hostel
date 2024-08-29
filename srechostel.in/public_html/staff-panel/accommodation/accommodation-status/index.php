<?php
/*
this code check wheather the login person is staff or not,
if staff proceed next,
else do not allow the person
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-staff.php";

include_once $_SERVER['DOCUMENT_ROOT']. "/../template/staff-template/accomodation-template/check-accomodation/header.php";

//this is the body of the page
include_once $_SERVER['DOCUMENT_ROOT']. "/../template/staff-template/accomodation-template/check-accomodation/body.php";

//this is the footer of the page
include_once $_SERVER['DOCUMENT_ROOT']. "/../template/staff-template/accomodation-template/check-accomodation/footer.php";



