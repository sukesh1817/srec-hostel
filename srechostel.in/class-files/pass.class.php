<?php
//this file get the connection from the database
include_once ("connection.class.php");

class Pass_class
{

    public function setGatePass($array) //this helps to set gate_pass record in database
    {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $name = $array["name"];
        $rollNo = $array["roll_no"];
        $dept = $array["department"];
        $time_out = $array["time_out"];
        $time_in = $array["time_in"];
        $addr = $array["address"];
        $reason = $array['reason'];
        $sqlQuery="SELECT already_booked FROM gate_pass WHERE roll_no=$rollNo;";
        $result=$sqlConn->query($sqlQuery);
        $booked=0;
        if($result){
            $row = $result->fetch_assoc();
            if(isset($row['already_booked'])){
                if($row['already_booked']==0){
                    $booked=1;
                }
            }
        }
        
        try {
            $sqlQuery = "UPDATE gate_pass SET  time_of_leave='$time_out',time_of_entry='$time_in',
            address_name='$addr',already_booked=1,allowed_or_not=0,reason='$reason' WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT already_booked FROM `gate_pass` WHERE roll_no=$rollNo ;";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["already_booked"])) {
                        if($row["already_booked"]==1){
                            if($booked){
                                // $this->bookingPassMessage("<strong>gate pass</strong>");
                            }
                            return true;
                        }

                    } else {
                        throw new Exception("Record Not Found");
                    }
                }
            }
        } catch (Exception $exe) {
            $sqlQuery = "INSERT INTO `gate_pass` VALUES('$name',$rollNo,'$dept',
            '$time_out','$time_in','$addr',1,0,'','$reason','','');";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT roll_no FROM `gate_pass` WHERE roll_no='$rollNo';";
                $result = $sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if (isset($row["roll_no"])) {
                    // $this->bookingPassMessage("<strong>gate pass</strong>");
                    return true;
                } else {
                    throw new Exception("Record Not Found");
                }
            } else {
                return "record not found";
            }
        }
    }

    public function setWorkingDayPass($array) {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
    
        // Extract and sanitize inputs
        $name = $sqlConn->real_escape_string($array["name"]);
        $rollNo = intval($array["roll_no"]);
        $dept = $sqlConn->real_escape_string($array["department"]);
        $tutor_name = $sqlConn->real_escape_string($array["tutor_name"]);
        $ac_name = $sqlConn->real_escape_string($array["ac_name"]);
        $time_out = $sqlConn->real_escape_string($array["time_of_leaving"]);
        $time_in = $sqlConn->real_escape_string($array["time_of_entry"]);
        $addr = $sqlConn->real_escape_string($array["address"]);
        $reason = $sqlConn->real_escape_string($array['reason']);
    
        if (isset($array['file']) && $array['file']['error'] === UPLOAD_ERR_OK) {
            $file = $array['file'];
            $file_name = md5($rollNo) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $tmp = $file['tmp_name'];
            echo getcwd();
            system("ls");
            exec('ls', $output, $retval);
            echo $output;
            $dir = $_SERVER["DOCUMENT_ROOT"]."/../../".'files/student-files/working-day-auth-letter/' . $file_name;
    
            if (!move_uploaded_file($tmp, $dir)) {
                throw new Exception("Failed to move uploaded file.");
            }
    
            $file_path = $file_name;
        } else {
            $file_path = ''; // Or handle the case where no file is uploaded
        }
    
        try {
            // Prepare the SQL statement
            $stmt = $sqlConn->prepare("
                INSERT INTO `working_days_pass` 
                (name, roll_no, department, tutor_name, ac_name, time_of_leave, time_of_entry, address_name, already_booked, allowed_or_not, reason, file_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, 0, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    ac_name = VALUES(ac_name),
                    tutor_name = VALUES(tutor_name),
                    time_of_leave = VALUES(time_of_leave),
                    time_of_entry = VALUES(time_of_entry),
                    address_name = VALUES(address_name),
                    reason = VALUES(reason),
                    file_path = VALUES(file_path)
            ");
    
            $stmt->bind_param("sissssssss", $name, $rollNo, $dept, $tutor_name, $ac_name, $time_out, $time_in, $addr, $reason, $file_path);
    
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query: " . $stmt->error);
            }
    
            return true;
        } catch (Exception $e) {
            // Log error or handle it as needed
            return "Error: " . $e->getMessage();
        }
    }
    
    public function setGeneralDayPass($array)  //this helps to set general_holiday_pass record in database
    {

        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $name = $array["name"];
        $rollNo = $array["roll_no"];
        $dept = $array["department"];
        $time_out = $array["time_of_leaving"];
        $time_in = $array["time_of_entry"];
        $addr = $array["address"];
        $reason = $array['reason'];

        try {
            $sqlQuery = "UPDATE `general_home_pass` SET time_of_leave='$time_out',time_of_entry='$time_in',
            address_name='$addr',already_booked=1,allowed_or_not=0,reason='$reason' WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT roll_no FROM `general_home_pass` WHERE roll_no=$rollNo ;";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["roll_no"])) {
                        return true;
                    } else {
                        throw new Exception("Record Not Found");
                    }
                }

            }
        } catch (Exception $exe) {

            $sqlQuery = "INSERT INTO `general_home_pass` VALUES('$name',$rollNo,'$dept',
           '$time_out','$time_in','$addr',1,0,'','$reason','','')";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                return true;
            } else {
                return "record not found";
            }
        }

    }

    public function setPassExtension($array) //this helps to set pass_extension record in database
    {
        $name = $array["name"];
        $rollNo = $array["rollNo"];
        $dept = $array["dept"];
        $daysToExtend = $array["daysToExtend"];
        $fromDate = $array["fromDate"];
        $toDate = $array["toDate"];
        $reason = $array["reason"];

        $conn = new Connection();
        $sqlConn = $conn->returnConn();
       
        try {
            $sqlQuery = "UPDATE `pass_extension` SET from_date='$fromDate',to_date='$toDate'
            ,already_booked=1,no_of_days=$daysToExtend WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                $sqlQuery = "SELECT roll_no FROM `pass_extension` WHERE roll_no=$rollNo ;";
                $result = $sqlConn->query($sqlQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    if (isset($row["roll_no"])) {
                        return true;
                    } else {
                       
                        throw new Exception("Record Not Found");
                    }
                }

            }
        } catch (Exception $exe) {
            $sqlQuery = "INSERT INTO `pass_extension` VALUES('$name',$rollNo,'$dept',$daysToExtend,
            '$fromDate','$toDate','$reason',1)";
            $result = $sqlConn->query($sqlQuery);
            if ($result) {
                return true;
            } else {
                return "record not found";
            }
        }


    }

    public function alreadyBooked($rollNo) //this check the any pass is booked already
    {
        $res1 = 0;
        $res2 = 0;
        $res3 = 0;
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT already_booked FROM `gate_pass` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["already_booked"])) {
                if ($row["already_booked"] == 1) {
                    global $res1;
                    $res1 = 1;
                }

            }
        }
        $sqlQuery = "SELECT already_booked FROM `working_days_pass` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["already_booked"])) {
                if ($row["already_booked"] == 1) {
                    global $res2;
                    $res2 = 1;
                }

            }
        }


        $sqlQuery = "SELECT already_booked FROM `general_home_pass` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["already_booked"])) {
                if ($row["already_booked"] == 1) {
                    global $res3;
                    $res3 = 1;
                }

            }
        }

        return array($res1, $res2, $res3);

    }

    public function isPassExtensionBooked($rollNo) {
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT already_booked FROM `pass_extension` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row["already_booked"])) {
                if ($row["already_booked"] == 1) {
                    return true;
                } else {
                    return false;
                }

            }
        }
    }

    public function getAllGatePass($status,$dept,$hostel,$year){
        $row=[];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery="";
        $row_1=[];
        
        // if($day=="today"){
        //     $date = date("d-m-Y");
        //     $from = $date."T00:00";
        //     $to = $date."T23:59";
            
        // }
        // else if($day=="tommorow"){
        //      $date= date("Y-m-d", strtotime("+ 1 day"));
        //      $from = $date."T00:00";
        //      $to = $date."T23:59";
        // }

         if($hostel=="Mens-1"){
            $sqlQuery = "SELECT roll_no FROM `stud_details` WHERE hostel='Mens 1' and year_of_study='$year';";

        } else if($hostel=="Mens-2"){
            $sqlQuery = "SELECT roll_no FROM `stud_details` WHERE hostel='Mens 2' and year_of_study='$year';";
        }

        $result = $sqlConn->query($sqlQuery);
        if($result){
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            
        }
      
        $arr=0;
        $dateFrom = date("Y-m-d")."T00:00";
        $dateTo = date("Y-m-d")."T24:00";
        while(isset($row[$arr])) {
            $rollNo = $row[$arr]['roll_no'];
            

            if($status=="pending") {
            $sqlQuery = "SELECT * FROM `gate_pass` WHERE already_booked=1 AND allowed_or_not=0 AND department='$dept' AND roll_no='$rollNo';";
        }
        else {
            $sqlQuery = "SELECT * FROM `gate_pass` WHERE already_booked=1 AND allowed_or_not=1 AND department='$dept' AND roll_no='$rollNo';";
        }
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            while ($sam = $result->fetch_assoc()) {
                $row_1[] = $sam;
            }
        }
    $arr++;
    //end of loop        
    }

        // return $row;
        //   echo "<pre>";
        // print_r($row_1);
        //  echo "</pre>";
        //  exit;

        
        return $row_1;
    }

    public function getAllHomePass($status,$dept,$hostel,$year){
        $row=[];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery="";
        $row_1=[];
         if($hostel=="Mens-1"){
            $sqlQuery = "SELECT roll_no FROM `stud_details` WHERE hostel='Mens 1' and year_of_study='$year';";

        } else if($hostel=="Mens-2"){
            $sqlQuery = "SELECT roll_no FROM `stud_details` WHERE hostel='Mens 2' and year_of_study='$year';";
        }

        $result = $sqlConn->query($sqlQuery);
        if($result){
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            
        }
      
        $arr=0;
         $dateFrom = date("Y-m-d")."T00:00";
        $dateTo = date("Y-m-d")."T24:00";
        while(isset($row[$arr])) {
            $rollNo = $row[$arr]['roll_no'];
            if($status=="pending") {

            $sqlQuery = "SELECT * FROM `general_home_pass` WHERE already_booked=1 AND allowed_or_not=0 AND department='$dept' AND roll_no='$rollNo'" ;
        }
        else {
            $sqlQuery = "SELECT * FROM `general_home_pass` WHERE already_booked=1 AND allowed_or_not=1 AND department='$dept' AND roll_no='$rollNo' ;";
        }
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            while ($sam = $result->fetch_assoc()) {
                $row_1[] = $sam;
            }
        }
    $arr++;
    //end of loop        
    }

        // return $row;
        //   echo "<pre>";
        // print_r($row_1);
        //  echo "</pre>";
        //  exit;

        
        return $row_1;
    }

    public function getAllWorkingDayPass($status,$dept,$hostel,$year){
        $row=[];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery="";
        $row_1=[];

         if($hostel=="Mens-1"){
            $sqlQuery = "SELECT roll_no FROM `stud_details` WHERE hostel='Mens 1' and year_of_study='$year';";

        } else if($hostel=="Mens-2"){
            $sqlQuery = "SELECT roll_no FROM `stud_details` WHERE hostel='Mens 2' and year_of_study='$year';";
        }

        $result = $sqlConn->query($sqlQuery);
        if($result){
            while ($sam = $result->fetch_assoc()) {
                $row[] = $sam;
            }
            
        }
      
        $arr=0;
         $dateFrom = date("Y-m-d")."T00:00";
        $dateTo = date("Y-m-d")."T24:00";
        while(isset($row[$arr])) {
            $rollNo = $row[$arr]['roll_no'];
            if($status=="pending") {

            $sqlQuery = "SELECT * FROM `working_days_pass` WHERE already_booked=1 AND allowed_or_not=0 AND department='$dept' AND roll_no='$rollNo' and  time_of_leave>='$dateFrom' and time_of_leave<='$dateTo' ;";
        }
        else {
            $sqlQuery = "SELECT * FROM `working_days_pass` WHERE already_booked=1 AND allowed_or_not=1 AND department='$dept' AND roll_no='$rollNo' and  time_of_leave>='$dateFrom' and time_of_leave<='$dateTo';";
        }
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            while ($sam = $result->fetch_assoc()) {
                $row_1[] = $sam;
            }
        }
    $arr++;
    //end of loop        
    }

        // return $row;
        //   echo "<pre>";
        // print_r($row_1);
        //  echo "</pre>";
        //  exit;

        
        return $row_1;
    }

    public function acceptThePass($rollNo,$type,$whois){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        date_default_timezone_set("Asia/Kolkata");
        $time = date('Y-m-d h:i:s', time());
        if($type=="gate-pass"){
            $sqlQuery = "UPDATE `gate_pass` SET allowed_or_not=1,accepted_by='$whois',time_of_approval='$time' WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $sqlQuery = "SELECT allowed_or_not FROM `gate_pass` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(isset($row["allowed_or_not"])){
                        if($row["allowed_or_not"]==1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        } else if($type=="home-pass"){
            $sqlQuery = "UPDATE `general_home_pass` SET allowed_or_not=1,accepted_by='$whois',time_of_approval='$time' WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $sqlQuery = "SELECT allowed_or_not FROM `general_home_pass` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(isset($row["allowed_or_not"])){
                        if($row["allowed_or_not"]==1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        } else if($type=="working-day-pass") {
            $sqlQuery = "UPDATE `working_days_pass` SET allowed_or_not=1,accepted_by='$whois',time_of_approval='$time' WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $sqlQuery = "SELECT allowed_or_not FROM `working_days_pass` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(isset($row["allowed_or_not"])){
                        if($row["allowed_or_not"]==1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function declineThePass($rollNo,$type){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if($type=="gate-pass"){
            $sqlQuery = "UPDATE `gate_pass` SET allowed_or_not=0,already_booked=0 WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $sqlQuery = "SELECT allowed_or_not FROM `gate_pass` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(isset($row["allowed_or_not"])){
                        if($row["allowed_or_not"]==0) {
                          
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        } else if($type=="home-pass"){
            $sqlQuery = "UPDATE `general_home_pass` SET allowed_or_not=0,already_booked=0 WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $sqlQuery = "SELECT allowed_or_not FROM `general_home_pass` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(isset($row["allowed_or_not"])){
                        if($row["allowed_or_not"]==0) {
                          
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        } else if($type=="working-day-pass") {
            $sqlQuery = "UPDATE `working_days_pass` SET allowed_or_not=0,already_booked=0 WHERE roll_no=$rollNo;";
            $result = $sqlConn->query($sqlQuery);
            if($result) {
                $sqlQuery = "SELECT allowed_or_not FROM `working_days_pass` WHERE roll_no=$rollNo;";
                $result = $sqlConn->query($sqlQuery);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(isset($row["allowed_or_not"])){
                        if($row["allowed_or_not"]==0) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function isPassAccepted($type){
     
        $roll_no=$_SESSION['yourToken'];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if($type=="general_home_pass") {
            $sqlQuery="SELECT allowed_or_not,already_booked FROM general_home_pass WHERE roll_no=$roll_no;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['allowed_or_not']) and isset($row['already_booked'])){
                        if(($row['allowed_or_not']==1 or $row['allowed_or_not']==2)and($row['already_booked']==1)){
                            return true;
                        }
                } else {
                    return false;
                }
            }
        } else if($type=="gate_pass") {
            
            $sqlQuery="SELECT allowed_or_not,already_booked FROM gate_pass WHERE roll_no=$roll_no;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
               if(isset($row['allowed_or_not']) and isset($row['already_booked'])){
                       if(($row['allowed_or_not']==1 or $row['allowed_or_not']==2)and($row['already_booked']==1)){
                            return true;
                        }
                } else {
                    return false;
                }
            }
        } else if($type=="working_day_pass") {
            $sqlQuery="SELECT allowed_or_not,already_booked FROM working_days_pass WHERE roll_no=$roll_no;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['allowed_or_not']) and isset($row['already_booked'])){
                        if(($row['allowed_or_not']==1 or $row['allowed_or_not']==2)and($row['already_booked']==1)){
                            return true;
                        }
                } else {
                    echo "sample";
                    return false;
                }
            }
        }
    }

    public function getMyPass($type){
        $rollNo = $_SESSION['yourToken'];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if($type=="general_pass") {
            $sqlQuery="SELECT * FROM general_home_pass WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return $row;
                } else {
                    return "record_not_found";
                }
            }
        }
        else if($type=="working_pass") {
            $sqlQuery="SELECT * FROM working_days_pass WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return $row;
                } else {
                    return "record_not_found";
                }
            }
        } 
        else if($type=="gate_pass") {
            $sqlQuery="SELECT * FROM gate_pass WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return $row;
                } else {
                    return "record_not_found";
                }
            }
        }
    }

    public function entryThePass($rollNo,$which){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery = "SELECT allowed_or_not,already_booked FROM `$which` WHERE roll_no=$rollNo;";
        $result = $sqlConn->query($sqlQuery);
        if($result){
            $row = $result->fetch_assoc();
            if(isset($row['allowed_or_not']) and isset($row['already_booked'])){
                if($row['allowed_or_not']==1 and $row['already_booked']==1){
                    $sqlQuery = "UPDATE `$which` SET allowed_or_not=2 WHERE roll_no=$rollNo;";
                    if($sqlConn->query($sqlQuery)) {
                        return '{"Message":"Successfully Checkout","action":"success"}';
                    } else {
                        return '{"Message":"Admin accepted but Checkout failed","action":"success"}';

                    }
                } else if($row['allowed_or_not']==2 and $row['already_booked']==1){
                    $sqlQuery = "UPDATE `$which` SET already_booked=0,allowed_or_not=0 WHERE roll_no=$rollNo;";
                    if($sqlConn->query($sqlQuery)) {
                            return '{"Message":"Successfully Checkin","action":"success"}';
                    } else {
                        return '{"Message":"Admin accepted but Checkin failed","action":"success"}';
                    }
                } else if($row['allowed_or_not']==0 and $row['already_booked']==0){
                        return '{"Message":"Nothing is booked","action":"failure"}';
                }
                else if($row['allowed_or_not']==0 and $row['already_booked']==1){
                    return '{"Message":"Admin not accepted","action":"failure"}';
            }
            } else {
                return '{"Message":"Student data not found","action":"failure"}';
            }
        } else {
                return '{"Message":"Something went wrong","action":"failure"}';
        }

        
       
    }



    public function editPass($array,$type) {
        $rollNo = $_SESSION['yourToken'];
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $from = $array['from'];
        $to = $array['to'];
        $address = $array['address'];
        $reason = $array['reason'];
        if($type=="general_pass") {
            $sqlQuery="UPDATE general_home_pass SET time_of_leave='$from',time_of_entry='$to',address_name='$address',reason='$reason' WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $sqlQuery="SELECT * FROM general_home_pass WHERE roll_no='$rollNo';";
                $result=$sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return true;
                } else {
                    return false;
                }
            }
        }
        else if($type=="working_pass") {
            $ac_name=$array['ac_name'];
            $tutor_name=$array['tutor_name'];
            $sqlQuery="UPDATE working_days_pass SET time_of_leave='$from',time_of_entry='$to',address_name='$address',ac_name='$ac_name',tutor_name='$tutor_name',reason='$reason' WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $sqlQuery="SELECT * FROM working_days_pass WHERE roll_no='$rollNo';";
                $result=$sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return true;
                } else {
                    return false;
                }
            }
        } 
        else if($type=="gate_pass") {
            $sqlQuery="UPDATE gate_pass SET time_of_leave='$from',time_of_entry='$to',address_name='$address',reason='$reason' WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $sqlQuery="SELECT * FROM gate_pass WHERE roll_no='$rollNo';";
                $result=$sqlConn->query($sqlQuery);
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    
    
    
    
       public function isPassAcceptedWatch($type,$rollNo){
     
            $roll_no=$rollNo;
        
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if($type=="general_pass") {
            $sqlQuery="SELECT allowed_or_not FROM general_home_pass WHERE roll_no=$roll_no;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['allowed_or_not'])){
                        if($row['allowed_or_not']==1 or $row['allowed_or_not']==2 ){
                            return true;
                        }
                } else {
                    return false;
                }
            }
        } else if($type=="gate_pass") {
            $sqlQuery="SELECT allowed_or_not FROM gate_pass WHERE roll_no=$roll_no;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['allowed_or_not'])){
                    if($row['allowed_or_not']==1 or $row['allowed_or_not']==2){
                        return true;
                    }
                } else {
                    return false;
                }
            }
        } else if($type=="working_day_pass") {
            $sqlQuery="SELECT allowed_or_not FROM working_days_pass WHERE roll_no=$roll_no;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['allowed_or_not'])){
                    if($row['allowed_or_not']==1 or $row['allowed_or_not']==2){
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }
    }
     public function getMyPassWatch($type,$rollNo){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        if($type=="general_pass") {
            $sqlQuery="SELECT * FROM general_home_pass WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return $row;
                } else {
                    return "record_not_found";
                }
            }
        }
        else if($type=="working_pass") {
            $sqlQuery="SELECT * FROM working_days_pass WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return $row;
                } else {
                    return "record_not_found";
                }
            }
        } 
        else if($type=="gate_pass") {
            $sqlQuery="SELECT * FROM gate_pass WHERE roll_no=$rollNo;";
            $result=$sqlConn->query($sqlQuery);
            if($result){
                $row = $result->fetch_assoc();
                if(isset($row['roll_no'])){
                    return $row;
                } else {
                    return "record_not_found";
                }
            }
        }
    }
    
    public function getRoomAndHostel($rollNo){
        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        $sqlQuery_1 = "SELECT room_no FROM stud_personal_details WHERE roll_no=$rollNo;";
        $sqlQuery_2 = "SELECT hostel FROM stud_details WHERE roll_no=$rollNo;";
        $result_1=$sqlConn->query($sqlQuery_1);
        $result_2=$sqlConn->query($sqlQuery_2);

        if($result_1 and $result_2 ) {
            $row_1 = $result_1->fetch_assoc();
            $row_2 = $result_2->fetch_assoc();
            if(isset($row_1['room_no']) and isset($row_2['hostel'])){
                return array($row_1['room_no'],$row_2['hostel']);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    
}