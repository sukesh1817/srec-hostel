<?php
/*
This file helps to check wheather the person is staff 
if the person is staff allow them
else do not allow 
*/
if(isset($_COOKIE["SessId"])) {
    include_once $_SERVER["DOCUMENT_ROOT"] ."/"."../class-files/connection.class.php";
    $cookie =  isset($_COOKIE["SessId"])?$_COOKIE["SessId"]:"none";
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $sqlQuery = "SELECT staff_session_id,staff_id,sur_name FROM `staff_session` WHERE staff_session_id='$cookie'";
    if($sqlConn->query($sqlQuery)) {
        $result = $sqlConn->query($sqlQuery);
        $row = $result->fetch_assoc();
        if(isset($row["staff_session_id"])) {
            if(isset($_SESSION["yourToken"]) and isset($_SESSION['name'])) {
                //do nothing
            } else {
                session_start();
                $_SESSION["yourToken"] = $row["staff_id"];
                $_SESSION["name"] = $row["sur_name"];
            }
        } else {
            $ip = $_SERVER["SERVER_ADDR"];
            header("Location:  /");
        }
    } else {
        $ip = $_SERVER["SERVER_ADDR"];
        header("Location:  /");
    }
} else {
    $ip = $_SERVER["SERVER_ADDR"];
    header("Location:  /");
}
