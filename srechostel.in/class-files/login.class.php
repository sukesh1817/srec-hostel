<?php
// This file gets the connection from the database
include_once("mainconn.class.php");

class Login
{
    public static function loginAuth($username, $password)
    {
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();
        // Prepare the statement to check if the username exists
        $stmt = $sqlConn->prepare("SELECT pass_word, who_is FROM login_auth WHERE user_id = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Verify the password
            if ($row['pass_word'] === $password) {
                $myObj = new stdClass();
                $myObj->authentication_status = "success";
                $myObj->whois = $row['who_is'];
                return json_encode($myObj);
            } else {
                return json_encode([
                    "authentication_status" => "failure",
                    "reason" => "Wrong password"
                ]);
            }
        } else {
            return json_encode([
                "authentication_status" => "failure",
                "reason" => "Username not found"
            ]);
        }
    }
}
