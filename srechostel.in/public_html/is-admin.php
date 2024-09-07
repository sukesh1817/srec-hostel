<?php
/*
This file helps to check wheather the person is admin 
if the person is admin allow them
else do not allow 
*/

if (isset($_COOKIE["auth_session_id"])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
    $cookie = $_COOKIE["auth_session_id"];
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $sqlQuery = "SELECT admin_id,admin_session_id FROM `admin_session` WHERE admin_session_id='$cookie'";
    if ($sqlConn->query($sqlQuery)) {
        $result = $sqlConn->query($sqlQuery);
        $row = $result->fetch_assoc();
        if (isset($row["admin_session_id"])) {
            if (isset($_SESSION["yourToken"])) {
                //do nothing
            } else {
                session_start();
                $_SESSION["yourToken"] = $row["admin_id"];
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


