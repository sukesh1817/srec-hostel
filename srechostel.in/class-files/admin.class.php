<?php
// this file get the connection from the database
include_once("connection.class.php");

class Admin
{

    // this function delete the user by using the user data.
    // it do deletion in two ways.
    // 1. single user deletion (using the rollno of the student).
    // 2. multi user deletion (using some of the data of the students). 
    public function deleteUser($keys, $values)
    {
        # getting connection from mysql
        $conn = new Connection();
        $sqlConn = $conn->returnConn();

        # sanitize the input values
        $pointer = 0;
        foreach($values as $value) {
            $values[$pointer] = mysqli_real_escape_string($sqlConn, $value);
            $pointer++;
        }

        if (in_array("dept", $keys) and in_array("year", $keys)) {

        } else if (in_array("group_of_roll_no", $keys)) {

        } else if ($keys[0] == "roll_no") {
            $query = "DELETE FROM `login_auth` WHERE user_id='$keys[0]'";
            if($sqlConn->query($query) == TRUE) {
                return "ACCOUNT_DELETED_SUCCESS";
            } else {
                return "ACCOUNT_DELETED_FAILED";
            }

        } else if ($keys[0] == "year") {

        } else {

        }
    }
}