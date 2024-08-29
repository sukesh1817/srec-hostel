<?php

//this file get the connection from the database
include_once ("connection.class.php");

class Committe_class
{

    public function insertCommitteeMember($rollNo, $committeeName)
    {
        // try to insert the new data in the committee_member table. 
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        try {
            $sqlQuery = "INSERT INTO `committee_member_info` VALUES ('$rollNo', '$committeeName', 0);";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                // if insert is done code goes here.
                $sqlQuery = "SELECT * FROM `committee_member_info` WHERE roll_no='$rollNo';";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    // if select statment is executed successfully code goes here.
                    $row = $result->fetch_assoc();
                    if (isset($row['roll_no'])) {
                        // if the the roll_no value is set correctly code goes here.
                        return true;
                    } else {
                        // else data is not inserted successfully, failed in the insertion.
                        return false;
                    }
                } else {
                    // else select statment is not executed successfully.
                    return false;
                }
            } else {
                // else got some error in the server side. 
                return false;
            }
        } catch (Exception $e) {
            return false;
        }

    }

    public function GetCommitteMember($committe)
    {
        $conn = new Connection();
       
        $rollnos = [];
        $details = [];
        $roomno = [];
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT roll_no FROM `committee_member_info` WHERE committe_name='$committe'; ";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rollnos[] = $row;
            }
           
            foreach ($rollnos as $rollno) {

                $rollno = $rollno['roll_no'];
                
                $sqlQuery = "SELECT hostel,year_of_study,name,department FROM `stud_details` WHERE roll_no='$rollno';";
                $sqlQuery2 = "SELECT room_no FROM `stud_personal_details` WHERE roll_no='$rollno';";
                                                
                
                $result = $sqlConn->query($sqlQuery);
                $result2 = $sqlConn->query($sqlQuery2);


                while ($row = $result->fetch_assoc() and $row2 = $result2->fetch_assoc()) {
                    $details[] = $row;
                    $roomno[] = $row2;
                }
            }
            $pointer = 0;
            foreach ($roomno as $room) {
                
                $details[$pointer]['room_no'] = $room['room_no'];
                $pointer++;
            }
           
            return $details;
        }
    }
}