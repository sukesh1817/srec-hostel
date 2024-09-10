<?php
/*
This file helps to check wheather the person is student 
if the person is student allow them
else do not allow 
*/
if (isset($_COOKIE["SessId"])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../../class-files/connection.class.php";
    $cookie = $_COOKIE["SessId"];
    $conn = new Connection();
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
            do_redirection();
        }
    } else {
        do_redirection();
    }
} else {
    do_redirection();
}

function do_redirection()
{
    $ip = $_SERVER["SERVER_ADDR"];
    header("Location:  /");
}