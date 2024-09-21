<?php
//this file get the connection from the database
include_once ("connection.class.php");

class commonClass
{
    // private function bookingComplaintMessage($type)
    // {
    //     require_once $_SERVER['DOCUMENT_ROOT'] . "/.." . '/composer/vendor/autoload.php'; // include Composer's autoloader
    //     $client = new MongoDB\Client('mongodb://srv1474.hstgr.io/');
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
    //         'message' => 'Hey, ' . $_SESSION['name'] . ', you booked your '.$type.' successfully',
    //         'time' => $dateTimeKolkata->format('Y-m-d H:i:s A'),
    //         'timestamp'=>time(),
    //         'checked' => 0
    //     ]);
    // }
    public function putCommonComplaint($data, $file) // this helps to put common complaints
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $date = "";
        $sqlQuery = "SELECT current_date;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['current_date'])) {
                $date = $row['current_date'];
            }
        }
        $dept = $data["dept"];
        $text = $data["text"];
        $imagePath="none";

        if(isset($file['name'])) {
            $rollNo = $data["rollNo"];
            chdir($_SERVER["DOCUMENT_ROOT"] . '/../../');
            chdir("files/student-files/complaints/common-complaints/");
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $imagePath = $rollNo . '-' . trim($date);
            $dir = $imagePath . '.' . $extension;
            $imagePath = $imagePath . ".$extension";
            // echo getcwd();
            $tmp = $file['tmp_name'];
            // echo $tmp;
            if (move_uploaded_file($tmp, $dir)) {
    
            }
        }
        
        $sqlQuery="SELECT complaint_satisfied FROM common_complaint WHERE roll_no=$rollNo;";
        $result=$sqlConn->query($sqlQuery);
        $booked=0;
        if($result){
            $row = $result->fetch_assoc();
            if(isset($row['already_booked'])){
                if($row['already_booked']==1){
                    $booked=1;
                }
            }
        }
        try {
            $sqlQuery = "UPDATE `common_complaint` SET department='$dept', date_of_complaint='$date',complaint_summary='$text',image_path='$imagePath',complaint_satisfied=0 WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT date_of_complaint FROM `common_complaint` WHERE roll_no=$rollNo; ";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["date_of_complaint"])) {
                        if ($row["date_of_complaint"] == $date) {
                            if($booked){
                                // $this->bookingComplaintMessage("Common complaint");
                            }
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        throw new Exception("record not found");
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {

            $sqlQuery = "INSERT INTO common_complaint VALUES('$rollNo','$dept','$date','$text','$imagePath',0);";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                // $this->bookingComplaintMessage("Common complaint");
                return true;
            } else {
                return false;
            }
        }


    }



    public function putindividualComplaint($data, $file)  // this helps to put individual complaints
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $date = "";
        $sqlQuery = "SELECT current_date;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['current_date'])) {
                $date = $row['current_date'];
            }
        }
        $name = $data["name"];
        $roomNo = $data["roomNo"];
        $dept = $data["dept"];
        $text = $data["text"];
        $rollNo = $data["rollNo"];
        $imagePath="none";
        if(isset($file['name'])){
            $imagePath = $rollNo . '-' . trim($date);
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            chdir($_SERVER["DOCUMENT_ROOT"] . '/../../');
            $dir = "files/student-files/complaints/individual-complaints/" . $imagePath . '.' . $extension;
            $tmp = $file['tmp_name'];
            $imagePath = $imagePath . ".$extension";
            if (move_uploaded_file($tmp, $dir)) {
    
            }
        }
        $sqlQuery="SELECT complaint_satisfied FROM individual_complaint WHERE roll_no=$rollNo;";
        $result=$sqlConn->query($sqlQuery);
        $booked=0;
        if($result){
            $row = $result->fetch_assoc();
            if(isset($row['already_booked'])){
                if($row['already_booked']==1){
                    $booked=1;
                }
            }
        }
        try {
            $sqlQuery = "UPDATE `individual_complaint` SET date_of_complaint='$date',complaint_summary='$text',image_path='$imagePath',complaint_satisfied=0 WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT date_of_complaint FROM `individual_complaint` WHERE roll_no=$rollNo; ";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["date_of_complaint"])) {
                        if ($row["date_of_complaint"] == $date) {
                            if($booked){
                                // $this->bookingComplaintMessage("Individual complaint");
                            }
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        throw new Exception("record not found");
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {

            $sqlQuery = "INSERT INTO individual_complaint VALUES('$name',$roomNo,'$rollNo','$date','$dept','$text','$imagePath',0);";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                // $this->bookingComplaintMessage("Individual complaint");
                return true;
            } else {
                return false;
            }
        }



    }

    public function retriveComplaint($whoseData)  // this helps to retrive all the  complaints
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $row = [];
        $sqlQuery = "SELECT * FROM $whoseData;";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            return $row;
        } else {
            return false;
        }
    }
    // public function attachTheFile($data, $whose)  // this helps to get the file from client  
    // {
    //     $name = $_SESSION["yourToken"];
    //     if ($whose == "common") {


    //     } else {
    //         $dir = $_SERVER["DOCUMENT_ROOT"] . "/" . "admin/individualComplaintPdf/" . $name . ".jpg";
    //         $tmp = $data['tmp_name'];
    //         if (move_uploaded_file($tmp, $dir)) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }
    // }

    public function alreadyBooked($rollNo)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `common_complaint` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['complaint_satisfied'])) {
                if ($row['complaint_satisfied'] == 0) {
                    return 1;
                } else {
                    $sqlQuery = "SELECT * FROM `individual_complaint` WHERE roll_no='$rollNo';";
                    $result = $sqlConn->query($sqlQuery);
                    $row = $result->fetch_assoc();
                    if (isset($row['complaint_satisfied'])) {
                        if ($row['complaint_satisfied'] == 0) {
                            return 2;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
    
    

    public function getStudDetails($rollNo)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `stud_details` WHERE roll_no='$rollNo'";

        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["roll_no"])) {

                return $row;
            }
        }
    }
     public function getLoginDetails($rollNo)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `login_auth` WHERE user_id='$rollNo'";

        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["user_id"])) {
                return $row;
            }
        }
    }

    public function getFullStudDetails($rollNo)
    {
        $row_1 = [];
        $row_2 = [];
        $row_3 = [];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `stud_details` WHERE roll_no=$rollNo";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["roll_no"])) {
                $row_1 = $row;
            }
        }

        $sqlQuery = "SELECT * FROM `stud_personal_details` WHERE roll_no=$rollNo";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["roll_no"])) {
                $row_2 = $row;
            }
        }

        $sqlQuery = "SELECT * FROM `stud_gurdian_details` WHERE roll_no=$rollNo";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["roll_no"])) {
                $row_3 = $row;
            }
        }
        return array($row_1, $row_2, $row_3);
    }


    public function addressComplaint($rollNo, $w)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if ($w == 'c') {
            $sqlQuery = "UPDATE `common_complaint` SET complaint_satisfied=1 WHERE roll_no=$rollNo;";
            if ($sqlConn->query($sqlQuery)) {
                $sqlQuery = "SELECT * FROM `common_complaint` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row['complaint_satisfied'])) {
                        if ($row['complaint_satisfied'] == 1) {
                            return true;
                        }
                    }
                }
            }
        } else if ($w == 'i') {

            $sqlQuery = "UPDATE `individual_complaint` SET complaint_satisfied=1 WHERE roll_no=$rollNo;";
            if ($sqlConn->query($sqlQuery)) {
                $sqlQuery = "SELECT * FROM `individual_complaint` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {

                    $row = $result->fetch_assoc();
                    if (isset($row['complaint_satisfied'])) {

                        if ($row['complaint_satisfied'] == 1) {
                            return true;
                        }
                    }
                }
            }
        }
    }



    public function editSomeData($data)
    {
        $roll_no = $_SESSION['yourToken'];
        $surname = $data['sur-name'];
        $address = $data['address'];
        $mobile_no = $data['mobile-no'];
        $post_code = $data['post-code'];
        $room_no = $data['room-no'];
        $study_year = $data['study-year'];
        $tutor_name = $data['tutor-name'];
        $ac_name = $data['ac-name'];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "UPDATE stud_details SET year_of_study=$study_year,tutor_name='$tutor_name',ac_name='$ac_name' WHERE roll_no='$roll_no';";
        if ($sqlConn->query($sqlQuery)) {
            $sqlQuery = "UPDATE stud_personal_details SET room_no=$room_no,pincode=$post_code,phone_no=$mobile_no,stud_address='$address' WHERE roll_no='$roll_no';";
            if ($sqlConn->query($sqlQuery)) {
                $sqlQuery = "UPDATE student_session SET sur_name='$surname' WHERE student_rollno='$roll_no';";
                if ($sqlConn->query($sqlQuery)) {
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

    public function getSurname()
    {
        $rollNo = $_SESSION['yourToken'];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT sur_name FROM student_session WHERE student_rollno='$rollNo';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['sur_name'])) {
                return $row['sur_name'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function retriveMyComplaint($whose)  // this helps to retrive all the  complaints
    {
            $roll_no = $_SESSION['yourToken'];
            $conn = new Connection();
            $sqlConn = $conn->returnConn();
                $sqlQuery = "SELECT * FROM $whose WHERE roll_no='$roll_no';";
                $result = $sqlConn->query($sqlQuery);
                if($result){
                    $row=$result->fetch_assoc();
                    return $row;
        } else {
            return array("error"=>"this is error");
        }
       
    }
    public function getstaffDetails($rollNo)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `staff_details` WHERE staff_id='$rollNo';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["staff_id"])) {
                return $row;
            } else {
                return array();
            }
        }

      
    }

    public function getSurnameStaff()
    {
        $rollNo = $_SESSION['yourToken'];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT sur_name FROM staff_session WHERE staff_id='$rollNo';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['sur_name'])) {
                return $row['sur_name'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    

    public function editSomeDataStaff($data)
    {
        $roll_no = $_SESSION['yourToken'];
        $surname = $data['sur-name'];
        // $mobile_no = $data['mobile-no'];
       
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        // $sqlQuery = "UPDATE staff_details SET phone_no='$mobile_no' WHERE staff_id='$roll_no';";
        // if ($sqlConn->query($sqlQuery)) {
                $sqlQuery = "UPDATE staff_session SET sur_name='$surname' WHERE staff_id='$roll_no';";
                if ($sqlConn->query($sqlQuery)) {
                    return true;
                } 
             else {
                return false;
            // }
        } 

    }
    public function ChangePass($rollNo,$data)
    {

       
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "UPDATE login_auth SET pass_word='$data' WHERE user_id=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
        $sqlQuery = "SELECT * FROM login_auth  WHERE user_id = $rollNo;";
        $result = $sqlConn->query($sqlQuery);
        $row = $result->fetch_assoc();
            if(isset($row['pass_word'])){
                if($row['pass_word']==$data){
                    return true;
                }
            } else {
                return false;
            }
                } 
             else {
                return false;
            }
        

    }
    
    
     public function GetRollNoUsingSessId($sessId)
    {

        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM student_session  WHERE student_session_id='$sessId';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
        $row = $result->fetch_assoc();
            if(isset($row['student_rollno'])){
                return $row['student_rollno'];
            } else {
                return 0;
            }
                } 
             else {
                return 0;
            }
        

    }








    

}

