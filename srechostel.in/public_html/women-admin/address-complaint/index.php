<?php
/*
this code checks wheather the person is admin or not,
if admin allow them ,
else do not allow them
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-women-admin.php";

// if(isset($_SESSION["yourToken"])){
if(isset($_GET['roll-no']) && isset($_GET['w'])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../../class-files" . "/common.class.php";
    $header = "";
    $complaint = new commonClass();
    $result = $complaint->addressComplaint($_GET['roll-no'],$_GET['w']);
    if($_GET['w'] == 'i') {
        $header = "?c_type=individual_c";
    } else if($_GET['w'] == 'c') {
        $header = "?c_type=common_c";
    }
    if($result){
        header("Location: /complaint/$header");
    } else {
        
        echo "something went wrong";
    }
} else {
    echo "bad url request";
}
