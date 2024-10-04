<?php
/*
this code checks wheather the person is admin or not,
if admin allow them ,
else do not allow them
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

// if(isset($_SESSION["yourToken"])){
if(isset($_GET['roll-no']) && isset($_GET['w'])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../class-files" . "/common.class.php";
    $complaint = new commonClass();
    $result = $complaint->addressComplaint($_GET['roll-no'],$_GET['w']);
    if($result){
        $ip = $_SERVER['SERVER_ADDR'];
        header("Location: /admin-panel/complaint/");
    } else {
        
        echo "something went wrong";
    }
} else {
    echo "bad url request";
}
// } else {
//     echo "something went wrong";
// }