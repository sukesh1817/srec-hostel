<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["roll-no"]) and isset($_POST['type']) and isset($_POST['action']) and $_POST['who_is']) {

        $pass = new Pass_class();
        if ($_POST['action']) {
        $result = $pass->acceptThePass($_POST['roll-no'],$_POST['type'],$_POST['who_is']);
        if($result){
            header("Content-Type: application/json");
            echo '{"Message":"Pass successfully accepted"}';
        } else {
            header("Content-Type: application/json");
            echo '{"Message":"Pass accepted failed"}';
        }
        } else {
            $result = $pass->declineThePass($_POST['roll-no'],$_POST['type'],$_POST['who_is']);
            if($result){
                header("Content-Type:application/json");
                echo '{"Message":"Pass successfully declined"}';
            } else {
                header("Content-Type:application/json");
                echo '{"Message":"Pass declined failed"}';
            }
        }  
    } else {
        header("Content-Type:application/json");
        echo '{"Message":"Defined wrong parameter"}';
    }
} else {
    header("Content-Type:application/json");
    echo '{"Message":"Wrong method call"}';
}