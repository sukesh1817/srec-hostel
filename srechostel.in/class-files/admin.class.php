<?php
// this file get the connection from the database
include_once("connection.class.php");

class Admin
{

    // this function delete the user by using the user data.
    // it do deletion in two ways.
    // 1 ) single user deletion (using the rollno of the student).
    // 2 ) multi user deletion (using some of the data of the students). 
    public function deleteUser($keys, $values)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();

        $pointer = 0;
        // foreach($values as $value) {
        //     $values[$pointer] = mysqli_real_escape_string($sqlConn, $value);
        //     $pointer++;
        // }
        print_r($values);
        exit;
        if (in_array("dept", $keys) and in_array("year", $keys)) {

        } else if (in_array("group_of_roll_no", $keys)) {

        } else if ($keys[0] == "roll_no") {

        } else if ($keys[0] == "year") {

        } else {

        }
    }
}