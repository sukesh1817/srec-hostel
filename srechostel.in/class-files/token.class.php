<?php
//this file get the connection from the database
include_once ("connection.class.php");
class Token
{
    public $isTokenIdPresent = false;
    public function __construct($tokenId = "none")
    {
        // this constructor helps to find the token-id is already present or not
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT roll_no FROM `token_system` WHERE roll_no='$tokenId' ;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["roll_no"])) {
                $this->isTokenIdPresent = true;
            }
        }

    }
    // private function bookingMessage()
    // {
    //     require_once $_SERVER['DOCUMENT_ROOT'] . "/.." . '/composer/vendor/autoload.php'; // include Composer's autoloader
    //     $client = new MongoDB\Client('mongodb://127.0.0.1:27017/');
    //     $database = $client->selectDatabase('hostelmanagment');

    //     //create collection if collection is not exists
    //     try {
    //         $createCollection = $database->createCollection($_SESSION['yourToken']);
    //     } catch (Exception $e) {

    //     }

    //     //current time finder
    //     $kolkataTimeZone = new DateTimeZone('Asia/Kolkata');
    //     $dateTimeKolkata = new DateTime('now', $kolkataTimeZone);
    //     $id=md5(time());
    //     $collection = $database->selectCollection("c_".$_SESSION['yourToken']);
    //     $insertOneResult = $collection->insertOne([
    //         'notiId' => $id,
    //         'rollno' => $_SESSION['yourToken'],
    //         'message' => 'Hey, ' . $_SESSION['name'] . ', you booked your food token successfully',
    //         'time' => $dateTimeKolkata->format('Y-m-d H:i:s A'),
    //         'timestamp'=>time(),
    //         'checked' => 0
    //     ]);
    // }

    public function createNewToken($arrayData) // this helps to create new token records in database
    {
        $tuesday = $arrayData["tuesdayCount"];
        $tuesdayDate = $arrayData["tuesdayDate"];

        $wednesday = $arrayData["wednesdayCount"];
        $wednesdayDate = $arrayData["wednesdayDate"];

        $thursday = $arrayData["thursdayCount"];
        $thursdayDate = $arrayData["thursdayDate"];

        $sunday = $arrayData["sundayCount"];
        $sundayDate = $arrayData["sundayDate"];


        $rollNo = $arrayData["rollNo"];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "INSERT INTO `token_system` VALUES($rollNo,$tuesday,'$tuesdayDate',$wednesday,
        '$wednesdayDate',$thursday,'$thursdayDate',$sunday,'$sundayDate',1,0,0,0,0) ;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $sqlQuery = "SELECT roll_no FROM `token_system` WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row["roll_no"])) {
                // $this->bookingMessage();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateToken($arrayData)  //this helps to update  the token records in database
    {
        $sundayDate = $arrayData["sundayDate"];
        $thursdayDate = $arrayData["thursdayDate"];
        $wednesdayDate = $arrayData["wednesdayDate"];
        $tuesdayDate = $arrayData["tuesdayDate"];
        $tuesday = $arrayData["tuesdayCount"];
        $wednesday = $arrayData["wednesdayCount"];
        $thursday = $arrayData["thursdayCount"];
        $sunday = $arrayData["sundayCount"];
        $rollNo = $arrayData["rollNo"];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery="SELECT token_booked FROM token_system WHERE roll_no=$rollNo;";
        $result=$sqlConn->query($sqlQuery);
        $booked=0;
        if($result){
            $row = $result->fetch_assoc();
            if(isset($row['token_booked'])){
                if($row['token_booked']==0){
                    $booked=1;
                }
            }
        }
        $sqlQuery = "UPDATE `token_system` SET tuesday_token_count=$tuesday,wednesday_token_count=$wednesday,
        thursday_token_count=$thursday,sunday_token_count=$sunday,token_booked=1,tuesday_date='$tuesdayDate',wednesday_date='$wednesdayDate',thursday_date='$thursdayDate',sunday_date='$sundayDate',tuesday_status=0,wednesday_status=0,thursday_status=0,sunday_status=0 WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $sqlQuery = "SELECT token_booked FROM `token_system` WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if ($row["token_booked"] == 1) {
                if($booked){
                    // $this->bookingMessage();
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function isTokenBooked($rollNo) //this helps to check wheather the token is booked or not
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT token_booked FROM `token_system` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["token_booked"])) {
                if ($row["token_booked"] == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }

    }

    public function fetchMyToken($rollNo)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `token_system` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["token_booked"])) {
                if ($row["token_booked"] == 1) {
                    return $row;
                } else {
                    return "none";
                }
            }
        }

    }

    public function checkTheToken($rollNo,$which){
       
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "UPDATE token_system_backup set $which=1 WHERE roll_no=$rollNo;";
        $result=$sqlConn->query($sqlQuery);
        if ($result) {
            $sqlQuery = "SELECT * FROM `token_system_backup` WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row["token_booked"])) {
                if($row['token_booked']==1){
                    if ($row["$which"] == 1) {
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
}