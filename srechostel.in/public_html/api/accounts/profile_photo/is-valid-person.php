<?php
/*
This file helps to check wheather the person is student 
if the person is student allow them
else do not allow 
*/

if (isset($_COOKIE["SessId"])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/mainconn.class.php";
    $cookie = $_COOKIE["SessId"];
    $conn = new MainConnection();
    $sqlConn = $conn->returnConn();
    $sqlQuery = "SELECT student_session_id,student_rollno,sur_name FROM `student_session` WHERE student_session_id='$cookie'";
    if ($sqlConn->query($sqlQuery)) {
        $result = $sqlConn->query($sqlQuery);
        $row = $result->fetch_assoc();
        if (isset($row["student_session_id"])) {
            if (isset($_SESSION["yourToken"]) and isset($_SESSION['name'])) {
                //do nothing
            } else {
                session_start();
                $_SESSION["yourToken"] = $row["student_rollno"];
                $_SESSION["name"] = $row["sur_name"];
            }

        } else {
            $sqlQuery = "SELECT staff_session_id,staff_id,sur_name FROM `staff_session` WHERE staff_session_id='$cookie'";
            if ($sqlConn->query($sqlQuery)) {
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["staff_session_id"])) {
                    if (isset($_SESSION["yourToken"]) and isset($_SESSION['name'])) {
                        //do nothing
                    } else {
                        session_start();
                        $_SESSION["yourToken"] = $row["staff_id"];
                        $_SESSION["name"] = $row["sur_name"];
                    }
                } else {
                    do_redirection();
                }
            } else {
                do_redirection();
            }
        }
    } else {
        do_redirection();
    }
} else {
    do_redirection();
}

function do_redirection()
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../config/domain.php";
    header("Location:  https://$domain");
}