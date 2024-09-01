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
        foreach ($values as $value) {
            $values[$pointer] = mysqli_real_escape_string($sqlConn, $value);
            $pointer++;
        }

        if (in_array("dept", $keys) and in_array("year", $keys)) {

        } else if (in_array("group_of_roll_no", $keys)) {

        } else if ($keys[0] == "user_id") {
           
            # this code first check who is the user student or staff or watch man.
            # then it backup the data to another table before deletion in the main table.
            # if the user accounts deleted successfully then give the success message.
            # else give the message account deletion failed.
            $rollNo = $values[0];
            $query0 = "SELECT who_is FROM `login_auth` WHERE user_id='$rollNo';";
            $whois = $sqlConn->query($query0);
            if ($whois == "Student") {
                $query1 = "DELETE FROM `login_auth` WHERE user_id='$rollNo';";
                $query2 = "DELETE FROM `stud_details` WHERE roll_no='$rollNo';";
                $query3 = "DELETE FROM `stud_personal_details` WHERE roll_no='$rollNo';";
                $query4 = "DELETE FROM `stud_gurdian_details` WHERE roll_no='$rollNo';";
                $query5 = "DELETE FROM `student_session` WHERE student_rollno='$rollNo';";
                if (
                    $sqlConn->query($query1) == TRUE and $sqlConn->query($query2) == TRUE and
                    $sqlConn->query($query3) == TRUE and $sqlConn->query($query4) == TRUE and
                    $sqlConn->query($query5) == TRUE
                ) {
                    
                    $query1 = "SELECT user_id FROM `login_auth` WHERE user_id='$rollNo';";
                    $query2 = "SELECT roll_no FROM `stud_details` WHERE roll_no='$rollNo';";
                    $query3 = "SELECT roll_no FROM `stud_personal_details` WHERE roll_no='$rollNo';";
                    $query4 = "SELECT roll_no FROM `stud_gurdian_details` WHERE roll_no='$rollNo';";
                    $query5 = "SELECT student_rollno FROM `student_session` WHERE student_rollno='$rollNo';";
                    $result1 = $sqlConn->query($query1);
                    $result2 = $sqlConn->query($query2);
                    $result3 = $sqlConn->query($query3);
                    $result4 = $sqlConn->query($query4);
                    $result5 = $sqlConn->query($query5);
                    $row1 = $result1->fetch_assoc();
                    $row2 = $result2->fetch_assoc();
                    $row3 = $result3->fetch_assoc();
                    $row4 = $result4->fetch_assoc();
                    $row5 = $result5->fetch_assoc();
                    if (
                        isset($row1['user_id']) or isset($row2['roll_no']) or
                        isset($row3['roll_no']) or isset($row4['roll_no']) or
                        isset($row1['student_rollno'])
                    ) {
                        return "ACCOUNT_DELETED_FAILED_STUDENT";
                    } else {
                        return "ACCOUNT_DELETED_SUCCESS_STUDENT";
                    }
                } else {
                    return "ACCOUNT_DELETED_FAILED_STUDENT";
                }
            } else if ($whois == "Staff") {
                # TODO : deletion of the staff accounts
            } else {
                # TODO : deletion of the other accounts such as watch man. 
            }


        } else if ($keys[0] == "year") {

        } else {

        }
    }
}