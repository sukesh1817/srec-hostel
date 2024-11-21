<?php
//this file get the connection from the database
include_once("mainconn.class.php");
class session
{
    public $isSessionExist;
    public $whoIs;

    public function __construct($id = NULL, $whoIs = NULL)
    {
        // this constructor helps us to find the session is already exist or not
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();
        $this->whoIs = $whoIs;
        if ($this->whoIs == "Staff") {
            $sqlQuery = "SELECT staff_id FROM `staff_session` WHERE staff_id='$id';";
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
        } else if ($this->whoIs == "Student") {
            $sqlQuery = "SELECT student_rollno FROM `student_session` WHERE student_rollno='$id';";
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

        } else if ($this->whoIs == "Mens-1" or $this->whoIs == "Mens-2" or $this->whoIs == "Women") {
            $sqlQuery = "SELECT admin_id FROM `admin_session` WHERE admin_id='$id';";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                if (isset($row["admin_id"])) {
                    $this->isSessionExist = true;
                } else {
                    $this->isSessionExist = false;
                }
            } else {
                // if query is not executed then some went wrong in server side 
            }
        } else if ($this->whoIs == "Watchman") {
            $sqlQuery = "SELECT watchman_number	 FROM `watchman_session` WHERE watchman_number='$id';";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                if (isset($row["watchman_number"])) {
                    $this->isSessionExist = true;
                } else {
                    $this->isSessionExist = false;
                }
            } else {
                // if query is not executed then some went wrong in server side 
            }
        } else {

        }

    }

    public function updateSession($id, $password)
    {
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();
        $ip = $_SERVER["REMOTE_ADDR"];
        $currentTime = "";
        $sqlQuery = "SELECT CURRENT_TIMESTAMP";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row['CURRENT_TIMESTAMP'])) {
                $currentTime = $row['CURRENT_TIMESTAMP'];
            }
        }

        $sessionId = md5($id . $password . $ip . $currentTime);
        if ($this->whoIs == "Staff") {
            $sqlQuery = "UPDATE `staff_session` SET staff_session_id='$sessionId',login_ip='$ip',
            last_login_time='$currentTime'  WHERE staff_id='$id' ";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            } else {
                return false;
            }
        } else if ($this->whoIs == "Student") {

            $sqlQuery = "UPDATE `student_session` SET student_session_id='$sessionId',login_ip='$ip',
                last_login_time='$currentTime'  WHERE student_rollno='$id' ";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            }

        } else if ($this->whoIs == "Mens-1" or $this->whoIs == "Mens-2" or $this->whoIs == "Women") {
            $sqlQuery = "UPDATE `admin_session` SET admin_session_id='$sessionId',login_ip='$ip',
            last_login_time='$currentTime'  WHERE admin_id='$id' ";

            if ($sqlConn->query($sqlQuery)) {
                $subdomain = strtolower($this->whoIs);
                setcookie("auth_session_id", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            }
        } else if ($this->whoIs == "Watchman") {
            $sqlQuery = "UPDATE `watchman_session` SET session_id='$sessionId',login_ip='$ip',
            last_login_time='$currentTime'  WHERE session_id='$id' ";

            if ($sqlConn->query($sqlQuery)) {
                $subdomain = strtolower($this->whoIs);
                setcookie("auth_session_id", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            }
        }

    }

    public function createSession($id, $password)
    {
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();
        $ip = $_SERVER["REMOTE_ADDR"];
        $currentTime = "";
        $sqlQuery = "SELECT CURRENT_TIMESTAMP";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row['CURRENT_TIMESTAMP'])) {
                $currentTime = $row['CURRENT_TIMESTAMP'];
            }
        }
        $sessionId = md5($id . $password . $ip . $currentTime);
        if ($this->whoIs == "Staff") {
            $sqlQuery = "INSERT INTO `staff_session` 
            VALUES('$id','$sessionId','$ip','$currentTime','staff')";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            } else {
                return false;
            }
        } else if ($this->whoIs == "Student") {
            $sqlQuery = "INSERT INTO `student_session` 
            VALUES('$id','$sessionId','$ip','$currentTime','student')";

            if ($sqlConn->query($sqlQuery)) {
                setcookie("SessId", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            } else {
                return false;
            }
        } else if ($this->whoIs == "Women" or $this->whoIs == "Mens-1" or $this->whoIs == "Mens-2") {

            $sqlQuery = "INSERT INTO `admin_session` 
            VALUES('$id','$sessionId','$ip','$currentTime')";

            if ($sqlConn->query($sqlQuery)) {
                $subdomain = strtolower($this->whoIs);
                setcookie("auth_session_id", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            } else {
                return false;
            }
        } else if ($this->whoIs == "Watchman") {
            $sqlQuery = "INSERT INTO `watchman_session` 
            VALUES('$id','$sessionId','$ip','$currentTime', 'WATCH_MAN' )";
            exit;
            if ($sqlConn->query($sqlQuery)) {
                $subdomain = strtolower($this->whoIs);
                setcookie("auth_session_id", $sessionId, time() + 2630000, "/", "srechostel.in", true, true);
                return true;
            } else {
                return false;
            }
        }

    }

    public function isSessionPresent($cookie, $whose)
    {
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();
        if ($whose == "Student") {
            $sqlQuery = "SELECT student_session_id,student_rollno FROM `student_session` WHERE student_session_id='$cookie';";
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

        } else if ($whose == "Staff") {
            $sqlQuery = "SELECT staff_session_id,staff_id FROM `staff_session` WHERE staff_session_id='$cookie';";
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


        } else if ($whose == "Admin") {
            $sqlQuery = "SELECT admin_session_id,admin_id FROM `admin_session` WHERE admin_session_id='$cookie';";
            if ($sqlConn->query($sqlQuery)) {
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["admin_session_id"])) {
                    $userId = $row['admin_id'];
                    $_SESSION["yourToken"] = $row["admin_id"];
                    $sqlQuery2 = "SELECT who_is FROM `login_auth` WHERE user_id='$userId';";
                    $result = $sqlConn->query($sqlQuery2);
                    $row = $result->fetch_assoc();
                    if (isset($row['who_is'])) {
                        return $row['who_is'];
                    } else {
                        return false;
                    }

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if ($whose == "Watchman") {
            $sqlQuery = "SELECT session_id,watchman_number FROM `watchman_session` WHERE session_id='$cookie';";
            if ($sqlConn->query($sqlQuery)) {
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["session_id"])) {
                    $userId = $row['watchman_number'];
                    $_SESSION["yourToken"] = $row["watchman_number"];
                    $sqlQuery2 = "SELECT who_is FROM `login_auth` WHERE user_id='$userId';";
                    $result = $sqlConn->query($sqlQuery2);
                    $row = $result->fetch_assoc();
                    if (isset($row['who_is'])) {
                        return $row['who_is'];
                    } else {
                        return false;
                    }

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