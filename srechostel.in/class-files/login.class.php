<?php
// this file get the connection from the database
include_once ("connection.class.php");

class login
{

    public static function loginAuth($username, $password)
    {
        
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlOuery = "SELECT user_id FROM `login_auth` WHERE user_id='$username';";
        $result = $sqlConn->query($sqlOuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["user_id"])) {
                $sqlOuery = "SELECT pass_word FROM `login_auth` WHERE pass_word='$password';";
                $result = $sqlConn->query($sqlOuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["pass_word"])) {
                        $sqlOuery = "SELECT * FROM `login_auth` WHERE pass_word='$password' AND user_id='$username';";
                        $result = $sqlConn->query($sqlOuery);
                        if ($result) {
                            $row = $result->fetch_assoc();
                            if (isset($row['who_is'])) {
                                $myObj = new stdClass();
                                $myObj->authtication_status = "success";
                                $myObj->whois = $row['who_is'];
                                $myJSON = json_encode($myObj);
                                return $myJSON;
                            } else {
                                // while something went wrong
                            }
                        } else {
                            // while something went wrong
                        }

                    } else {
                        $myObj = new stdClass();
                        $myObj->authtication_status = "failure";
                        $myObj->reason = "Wrong password";
                        $myJSON = json_encode($myObj);
                        return $myJSON;
                    }
                }
            } else {
                $myObj = new stdClass();
                $myObj->authtication_status = "failure";
                $myObj->reason = "Username not found";
                $myJSON = json_encode($myObj);
                return $myJSON;
            }
        }
    }
}



