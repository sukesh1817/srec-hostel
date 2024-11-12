<?php
/*
This file helps to check wheather the person is admin 
if the person is admin allow them
else do not allow 
*/

if (isset($_COOKIE["auth_session_id"])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../../class-files/connection.class.php";
    $cookie = $_COOKIE["auth_session_id"];
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $sqlQuery = "SELECT admin_id,admin_session_id FROM `admin_session` WHERE admin_session_id='$cookie'";
    if ($sqlConn->query($sqlQuery)) {
        $result = $sqlConn->query($sqlQuery);
        $row = $result->fetch_assoc();
        if (isset($row["admin_session_id"])) {
            $id = $row['admin_id'];
            $sqlQuery = "SELECT who_is,user_id FROM `login_auth` WHERE user_id='$id'";
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row['who_is'])) {

                if ($row['who_is'] == "Women") {
                    if (isset($_SESSION["yourToken"])) {
                        //do nothing
                    } else {
                        session_start();
                        $_SESSION["yourToken"] = $row["user_id"];
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
    } else {
        do_redirection();

    }
} else {
    do_redirection();

}

function do_redirection()
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../../config/domain.php";
    header("Location:  $domain");
}


