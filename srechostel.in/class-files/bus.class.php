<?php
//this file get the connection from the database
include_once ("connection.class.php");

class Bus{
public function insertPass($data){
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $name = $data["name"];
    $rollNo = $data["rollno"];
    $destination = $data["destination"];
    $bookDate = $data["bookdate"];
    try{
       
        $sqlQuery="UPDATE `bus_pass` SET leave_date='$bookDate' , destination='$destination', booked=1 WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if($result) {
            $sqlQuery="SELECT leave_date FROM `bus_pass` WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $row = $result->fetch_assoc();
                if(isset($row["leave_date"])) {
                    if($row["leave_date"]==$bookDate){
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    throw new Exception("Record Not Found");
                }
            }
        }
    }

    catch(Exception $exception) {
        $sqlQuery="INSERT INTO `bus_pass` VALUES('$name',$rollNo,'$destination','$bookDate',1);";
        $result = $sqlConn->query($sqlQuery);
        if($result) {
            $sqlQuery="SELECT leave_date FROM `bus_pass` WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $row = $result->fetch_assoc();
                if(isset($row["leave_date"])) {
                    if($row["leave_date"]==$bookDate){
                        return true;
                    } else {
                        return false;
                    }
                } 
            }
        }
    }

}
public function isPassBooked($rollNo){
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $sqlQuery="SELECT booked FROM `bus_pass` WHERE roll_no=$rollNo;";
    $result = $sqlConn->query($sqlQuery);
    if($result) {
        $row = $result->fetch_assoc();
        if(isset($row["booked"])) {
            if($row["booked"]==1){
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

public function retrivePass(){

}
}