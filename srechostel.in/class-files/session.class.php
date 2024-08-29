<?php
//this file get the connection from the database
include_once ("connection.class.php");
class session
{
    public $isSessionExist;
    public $whoIs;

    public function __construct($staffId = "none", $whoIs ="none")
    {
        // this constructor helps us to find the session is already exist or not
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $this->whoIs = $whoIs;
        if ($this->whoIs == "Staff") {
            $sqlQuery = "SELECT staff_id FROM `staff_session` WHERE staff_id='$staffId';";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                if (isset($row["staff_id"])) {
                    $this->isSessionExist = true;
                } else {
                    $this->isSessionExist = false;
                }
            } else {
                // if query is not executed then some went wrong in server side 
            }
        } else {
            $sqlQuery = "SELECT student_rollno FROM `student_session` WHERE student_rollno='$staffId' ";
            try {
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["student_rollno"])) {
                        $this->isSessionExist = true;
                    } else {
                        $this->isSessionExist = false;
                    }
                } else {
                    // if query is not executed then some went wrong in server side 
                }
            } catch (Exception $e) {
                // echo $e;
                $this->isSessionExist = false;
            }
        }

    }

    public function updateSession($staffId, $staffPass)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $staffIp = $_SERVER["REMOTE_ADDR"];
        $currentTime = "";
        $sqlQuery = "SELECT CURRENT_TIMESTAMP";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row["CURRENT_TIMESTAMP"])) {
                $currentTime = $row["CURRENT_TIMESTAMP"];
            }
        }
        $sessionId = md5($staffId . $staffPass . $staffIp.$currentTime);
        if ($this->whoIs == "Staff") {
            $sqlQuery = "UPDATE `staff_session` SET staff_session_id='$sessionId',login_ip='$staffIp',
            last_login_time='$currentTime'  WHERE staff_id='$staffId' ";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/");
                return true;
            } else {
                return false;
            }
        } else {
            try {

                $sqlQuery = "UPDATE `student_session` SET student_session_id='$sessionId',login_ip='$staffIp',
                last_login_time='$currentTime'  WHERE student_rollno='$staffId' ";

                if ($sqlConn->query($sqlQuery)) {
                    setcookie("SessId", $sessionId, time() + 2630000, "/");
                    return true;
                }
            } catch (Exception $e) {
                return false;
            }
        }

    }

    public function createSession($staffId, $staffPass)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $staffIp = $_SERVER["REMOTE_ADDR"];
        $currentTime = "";
        $sqlQuery = "SELECT CURRENT_TIMESTAMP";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row["CURRENT_TIMESTAMP"])) {
                $currentTime = $row["CURRENT_TIMESTAMP"];
            }
        }
        $sessionId = md5($staffId.$staffPass.$staffIp.$currentTime);
        if ($this->whoIs == "Staff") {
            $sqlQuery = "INSERT INTO `staff_session` 
            VALUES('$staffId','$sessionId','$staffIp','$currentTime','staff')";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/");
                return true;
            } else {
                return false;
            }
        } else {
            $sqlQuery = "INSERT INTO `student_session` 
            VALUES('$staffId','$sessionId','$staffIp','$currentTime','student')";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/");
                return true;
            } else {
                return false;
            }
        }

    }

    public function isSessionPresent($cookie, $whose)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if ($whose == "Student") {
            $sqlQuery = "SELECT student_session_id,student_rollno FROM `student_session` WHERE student_session_id='$cookie'";
            if ($sqlConn->query($sqlQuery)) {
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["student_session_id"])) {
                    $_SESSION["yourToken"] = $row["student_rollno"];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } else if ($whose = "Staff") {
            $sqlQuery = "SELECT staff_session_id,staff_id FROM `staff_session` WHERE staff_session_id='$cookie'";
            if ($sqlConn->query($sqlQuery)) {
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["staff_session_id"])) {
                    $_SESSION["yourToken"] = $row["staff_id"];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }


        } else {
            return false;
        }

    }
}