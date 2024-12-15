<?php
// Check the watchman is login or not.
if (isset($_COOKIE["auth_session_id"])) {
    // echo "hello";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
    $cookie = $_COOKIE["auth_session_id"];
    $conn = new MainConnection();
    $sqlConn = $conn->returnConn();
    $sqlQuery = "SELECT session_id,watchman_number,name FROM `watchman_session` WHERE session_id='$cookie';";
    if ($sqlConn->query($sqlQuery)) {
        $result = $sqlConn->query($sqlQuery);
        $row = $result->fetch_assoc();
        if (isset($row["session_id"])) {
            if (isset($_SESSION["yourToken"]) and isset($_SESSION['name'])) {
                //do nothing
            } else {
                session_start();
                $_SESSION["yourToken"] = $row["watchman_number"];
                $_SESSION["name"] = $row["name"];
            }

        } else {
            //echo "1";
             do_redirection();
        }
    } else {
        //echo "2";

         do_redirection();
    }
} else {
    // echo "3";

     do_redirection();
}

function do_redirection()
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../../config/domain.php";
     header("Location:  $domain");
}