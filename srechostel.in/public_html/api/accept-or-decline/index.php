<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
/*
this part of the code check the request is made by admin ,
if yes accept , else decline the request
*/
?>

<?php
/*
this file takes input staff_id and accomodation_status ,
and it change the accomdation_status from pending to (acceted or declined) ,
based on the request.
*/
if (isset($_SESSION['yourToken'])) {
    if (isset($_REQUEST["id"]) and isset($_REQUEST["status"])) {
        include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/accommodation.class.php";
        $accom = new accommodation();
        $staffId = $_REQUEST["id"];
        if ($_REQUEST["status"] == "true") {
            //accept if status is equal to true
            $result = $accom->acceptAccom($staffId);
        } else if ($_REQUEST["status"] == "false") {
            //decline if status is equal to false
            $result = $accom->declineAccom($staffId);
        } else {
            //else do nothing
        }
    } else {
        echo "bad url request";
    }
}

