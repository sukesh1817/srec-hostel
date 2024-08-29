<?php
include_once ("connection.class.php");

class Food_class
{

    public function putFoodOrder($data)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $staffId = $_SESSION["yourToken"];
        $foodDate = $data['eventDate'];
        $eventName = $data['eventName'];
        $foodCombo = $data['foodType'];
        $cost = 0;
        $qty = $data['foodQuantity'];
        if($foodCombo=="Vegetarian"){
            $cost=200*$qty;
        } if($foodCombo=="Non-Vegetarian"){
            $cost=350*$qty;
        }
        if($foodCombo=="Normal"){
            $cost=100*$qty;
        }
        try {

            $sqlQuery = "UPDATE `event_food` SET event_date='$foodDate' , event_name='$eventName',food_combo='$foodCombo' ,cost=$cost,quantity=$qty,booked=1 WHERE staff_id=$staffId;";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT * FROM `event_food` WHERE staff_id=$staffId;";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row['staff_id'])) {
                        return true;
                    } else {
                        throw new Exception('record not found');
                    }
                } else {
                    return "something went wrong";
                }
            }
        } catch (Exception $exc) {
            $sqlQuery = "INSERT INTO `event_food` VALUES('$staffId','$eventName','$foodDate','$foodCombo','$cost',$qty,1);";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT * FROM `event_food` WHERE staff_id=$staffId";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["staff_id"])) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return "data maybe wrong";
                }
            } else {
                return "someting went wrong";
            }

        }


    }
    public function getAllFoodOrder()
    {
        $row=[];
        $sqlQuery = "SELECT * FROM `event_food` WHERE booked=1;";
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $result = $sqlConn->query($sqlQuery);
        if($result){
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            return $row;
        }
    }

    function getStaffDetails($id){
        $row=[];
        $sqlQuery = "SELECT * FROM `staff_details` WHERE staff_id=$id;";
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $result = $sqlConn->query($sqlQuery);
        if($result){
           $row=$result->fetch_assoc();
            return $row;
        }
    }

    function isFoodBooked($id){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery="SELECT booked FROM `event_food` WHERE staff_id=$id;";
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

    function getStaffFoodDetails($id){
        $row=[];
        $sqlQuery = "SELECT * FROM `event_food` WHERE staff_id=$id;";
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $result = $sqlConn->query($sqlQuery);
        if($result){
           $row=$result->fetch_assoc();
            return $row;
        }
    }
    

}
