<?php
//this file get the connection from the database
include_once ("connection.class.php");

class accommodation
{
    public function createAccom($details,$file) //this function create the new accomodation
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $name = $details["name"];
        $staffId = $details["staffId"];
        $check_in_date = $details["checkInDate"];
        $check_out_date = $details["checkOutDate"];
        $femaleStudentRoom = $details["femaleStudentRoom"];
        $maleStudentRoom = $details["maleStudentRoom"];
        $femaleStaffRoom = $details["femaleStaffRoom"];
        $maleStaffRoom = $details["maleStaffRoom"];
        $femaleStudent = $details["femaleStudentCount"];
        $maleStudent = $details["maleStudentCount"];
        $femaleStaff = $details["femaleStaffCount"];
        $maleStaff = $details["maleStaffCount"];

        $currentDate= "";
        $sqlQuery = "SELECT CURRENT_DATE;";
        $result = $sqlConn->query($sqlQuery); 
        if($result) {
            $row = $result->fetch_assoc();
            if(isset($row["CURRENT_DATE"])) {
                $currentDate=$row["CURRENT_DATE"];
            }
        }

        if($file['error']==0){
           
            $pdfName=$staffId.'-'.$currentDate;
            chdir($_SERVER["DOCUMENT_ROOT"].'/..');
            $dir = "files/accomodation/authorization-pdf/" . $pdfName . ".pdf";
            $tmp = $file['tmp_name'];
            if (move_uploaded_file($tmp, $dir)) {
               
            } 
        }
       

        $sqlQuery = "SELECT staff_id FROM `accom_accepted_request` WHERE staff_id='$staffId'";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row["staff_id"])) {
                return false;
            } else {
                $sqlQuery = "SELECT staff_id FROM `accom_declined_request` WHERE staff_id='$staffId'";
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["staff_id"])) {
                    return false;
                } else {
                    $sqlQuery = "INSERT INTO `accom_pending_request` VALUES('$staffId','$name','$check_in_date',' $check_out_date',$maleStudent,$femaleStudent,$maleStaff,$femaleStaff,$maleStudentRoom,$femaleStudentRoom,$maleStaffRoom,$femaleStaffRoom,'$pdfName')";
                    try {
                        if ($sqlConn->query($sqlQuery)) {
                            return true;
                        }
                    } catch (Exception $e) {
                        $sqlQuery="UPDATE `accom_pending_request` SET staff_name='$name',accom_check_in_date='$check_in_date',accom_check_out_date=' $check_out_date',no_of_male_student=$maleStudent,no_of_female_student=$femaleStudent,no_of_male_staff=$maleStaff,no_of_female_staff=$femaleStaff,no_of_male_student_room=$maleStudentRoom,no_of_female_student_room=$femaleStudentRoom,no_of_male_staff_room=$maleStaffRoom,no_of_female_staff_room=$femaleStaffRoom;";
                        if($file['error']==0){
                            $sqlQuery = "UPDATE `accom_pending_request` SET staff_name='$name',accom_check_in_date='$check_in_date',accom_check_out_date=' $check_out_date',no_of_male_student=$maleStudent,no_of_female_student=$femaleStudent,no_of_male_staff=$maleStaff,no_of_female_staff=$femaleStaff,no_of_male_student_room=$maleStudentRoom,no_of_female_student_room=$femaleStudentRoom,no_of_male_staff_room=$maleStaffRoom,no_of_female_staff_room=$femaleStaffRoom,pdf_name='$pdfName';";
                        }
                        if ($sqlConn->query($sqlQuery)) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

    }


    public function getPendingAccom() //this function get pending accommodation
    {
        $row = [];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_pending_request`; ";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            return $row;
        }
    }

    public function getAcceptedAccom() //this function get accepted accommodation
    {
        $row = [];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_accepted_request`; ";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            return $row;
        }
    }

    public function getDeclinedAccom() //this function get declined accommodation
    {
        $row = [];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_declined_request` ; ";
        if ($sqlConn->query($sqlQuery)) {
            $result = $sqlConn->query($sqlQuery);
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            return $row;
        }
    }

    public function acceptAccom($id) //this function accept the accomodation
    {
        $name = "";
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_pending_request` WHERE staff_id='$id';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["staff_name"])) {
                $name = $row["staff_name"];
                $staffId = $row["staff_id"];
                $check_in_date = $row["accom_check_in_date"];
                $check_out_date = $row["accom_check_out_date"];                
                $pdfName = $row["pdf_name"];
                $femaleStudentRoom=$row["no_of_female_student_room"];
                $maleStudentRoom=$row["no_of_male_student_room"];
                $femaleStaffRoom=$row["no_of_female_staff_room"];
                $maleStaffRoom=$row["no_of_male_staff_room"];
                $femaleStudent=$row["no_of_female_student"];
                $maleStudent=$row["no_of_male_student"];
                $femaleStaff=$row["no_of_female_staff"];
                $maleStaff=$row["no_of_male_staff"];
                $sqlQuery = "DELETE FROM `accom_pending_request` WHERE staff_id='$id';";
                if ($sqlConn->query($sqlQuery)) {
                    // $sqlQuery = "INSERT INTO `accom_accepted_request` VALUES('$id','$name','$date',
                    // '$combo','$price','$quantity') ; ";
                    
                    
                    $sqlQuery = "INSERT INTO `accom_accepted_request` VALUES('$staffId','$name','$check_in_date',' $check_out_date',$maleStudent,$femaleStudent,$maleStaff,$femaleStaff,$maleStudentRoom,$femaleStudentRoom,$maleStaffRoom,$femaleStaffRoom,'$pdfName')";
                    if ($sqlConn->query($sqlQuery)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {

            }
        }

    }

    public function declineAccom($id)  //this function decline the accomodation
    {
        $name = "";
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_pending_request` WHERE staff_id='$id';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["staff_name"])) {
                $name = $row["staff_name"];
                $staffId = $row["staff_id"];
                $check_in_date = $row["accom_check_in_date"];
                $check_out_date = $row["accom_check_out_date"];            
                $pdfName = $row["pdf_name"];
                $femaleStudentRoom=$row["no_of_female_student_room"];
                $maleStudentRoom=$row["no_of_male_student_room"];
                $femaleStaffRoom=$row["no_of_female_staff_room"];
                $maleStaffRoom=$row["no_of_male_staff_room"];
                $femaleStudent=$row["no_of_female_student"];
                $maleStudent=$row["no_of_male_student"];
                $femaleStaff=$row["no_of_female_staff"];
                $maleStaff=$row["no_of_male_staff"];
                $sqlQuery = "DELETE FROM `accom_pending_request` WHERE staff_id='$id';";
                if ($sqlConn->query($sqlQuery)) {
                    // $sqlQuery = "INSERT INTO `accom_declined_request` VALUES('$id','$name','$date',
                    // '$combo','$price','$quantity') ; ";
                    $sqlQuery = "INSERT INTO `accom_declined_request` VALUES('$staffId','$name','$check_in_date',' $check_out_date',$maleStudent,$femaleStudent,$maleStaff,$femaleStaff,$maleStudentRoom,$femaleStudentRoom,$maleStaffRoom,$femaleStaffRoom,'$pdfName');";

                    if ($sqlConn->query($sqlQuery)) {
                        return true;
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

    public function checkAccomStatus($staffId)  //this function check the accomodation status
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT staff_id FROM `accom_pending_request` WHERE staff_id='$staffId' ; ";
        if ($sqlConn->query($sqlQuery)) {

            $result = $sqlConn->query($sqlQuery);
            $row = $result->fetch_assoc();
            if (isset($row["staff_id"])) {
                return "pending";
            } else {

                $sqlQuery = "SELECT staff_id FROM `accom_accepted_request` WHERE staff_id='$staffId' ; ";
                if ($sqlConn->query($sqlQuery)) {

                    $result = $sqlConn->query($sqlQuery);
                    $row = $result->fetch_assoc();
                    if (isset($row["staff_id"])) {
                        
                        return "accepted";
                    } else {
                        $sqlQuery = "SELECT staff_id FROM `accom_declined_request` WHERE staff_id='$staffId' ; ";
                        if ($sqlConn->query($sqlQuery)) {
                            $result = $sqlConn->query($sqlQuery);
                            $row = $result->fetch_assoc();
                            if (isset($row["staff_id"])) {

                                return "declined";
                            } else {
                                return "none";
                            }
                        }
                    }
                }

            }
        }
    }


   

    public function getMyData($id)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_accepted_request` WHERE staff_id='$id';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["staff_id"])) {

                return $row;
            } else {

                return false;
            }
        }

    }

    public function getMyPendingData($id)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_pending_request` WHERE staff_id='$id';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["staff_id"])) {
                return $row;
            } else {
                return false;
            }
        }

    }
    public function getMyDeclinedData($id)
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT * FROM `accom_declined_request` WHERE staff_id='$id';";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["staff_id"])) {
                return $row;
            } else {
                return false;
            }
        }

    }

    public function getStaffDetails($id){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery ="SELECT * FROM  `staff_details` WHERE staff_id=$id;";
        $result = $sqlConn->query($sqlQuery);
        if($result) {
            $row = $result->fetch_assoc();
            if(isset($row['staff_id'])) {
                return $row;
            } else {
                return "none";
            }
        } else {
            return "none";
        }
    }

    public function clearAccom($id){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "DELETE FROM accom_accepted_request WHERE staff_id='$id';";
        $sqlQuery2 = "DELETE FROM accom_declined_request WHERE staff_id='$id';";
        if($sqlConn->query($sqlQuery) and $sqlConn->query($sqlQuery2)){
            return true;
        } else {
            return false;
        }

    }

    

}

