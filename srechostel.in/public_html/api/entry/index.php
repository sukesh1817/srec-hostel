<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/is-watch-man.php";
//session_start();

if (isset($_SESSION['yourToken']) and isset($_GET['auth_token_id'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/common.class.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/pass.class.php";
    $common = new commonClass();
    // Extract the IV and the encrypted data
    $encrypted = urldecode($_GET['auth_token_id']);
    $encrypted = str_replace("sk", "+", $encrypted);
    $encrypted = base64_decode($encrypted);
    $method = "AES-256-CBC";
    $key = "secret";
    $iv = substr($encrypted, 0, openssl_cipher_iv_length($method));
    $encrypted = substr($encrypted, openssl_cipher_iv_length($method));
    $rollNo = openssl_decrypt($encrypted, $method, $key, 0, $iv);
    $pass = new Pass_class();
    $passBooked = $pass->alreadyBooked($rollNo);
    if ($passBooked[0] or $passBooked[1] or $passBooked[2]) {
        $passType = "";
        $isValid = false;
        $row = [];
        if ($passBooked[0]) {
            $passType = "gate_pass";
            if ($pass->isPassAcceptedWatch("gate_pass", $rollNo)) {
                $row = $pass->getMyPassWatch("gate_pass", $rollNo);
                $isValid = true;
            }
        } else if ($passBooked[1]) {
            $passType = "working_pass";
            $sqlQuery = "SELECT * FROM working_days_pass WHERE roll_no=$rollNo;";
            if ($pass->isPassAcceptedWatch("working_day_pass", $rollNo)) {
                $row = $pass->getMyPassWatch("working_pass", $rollNo);
                $isValid = true;
            }
        } else if ($passBooked[2]) {
            $passType = "general_pass";
            $sqlQuery = "SELECT * FROM general_home_pass WHERE roll_no=$rollNo;";
            if ($pass->isPassAcceptedWatch("general_pass", $rollNo)) {
                $row = $pass->getMyPassWatch("general_pass", $rollNo);
                $isValid = true;
            }
        }
        if ($isValid) {
            if ($passBooked[0]) {
                $orginal_json = $pass->entryThePass($rollNo, "gate_pass");
                $entry = json_decode($orginal_json, true);
                if ($entry) {
                    if ($entry['action'] == 'success') {
                        $msg = $entry['Message'];
                        $action = $entry['action'];
                        $profile = "https://srechostel.in/api/profile/?auth_token_id=".$_GET['auth_token_id'];
                        $name = $row['stud_name'];
                        $dept = $row['department'];
                        $timeLeave = $row['time_of_leave'];
                        $timeEnter = $row['time_of_entry'];
                        $address = $row['address_name'];
                        $time = new DateTime($timeLeave);
                        $dateLeave = $time->format('j-n-Y');
                        $timeLeave = $time->format('h:i A');
                        $time = new DateTime($timeEnter);
                        $dateEnter = $time->format('j-n-Y');
                        $timeEnter = $time->format('h:i A');
                        $a = $pass->getRoomAndHostel($rollNo);
                        $acceptedBy = $row['accepted_by'];
                        $room = $a[0];
                        $hostel = $a[1];
                        $passType = "Out pass";
                        header("Content-Type:application/json");
                        // echo '["status:"'.$entry.',"details":'.']';
                        $htmlContent = <<<EOL
                        {
  "status": {
    "Message": "$msg",
    "action": "$action"
  },
  "details": {
    "name": "$name",
    "dept": "$dept",
    "profile_url":"$profile",
    "timeLeave": "$timeLeave",
    "timeEnter": "$timeEnter",
    "dateLeave": "$dateLeave",
    "dateEnter": "$dateEnter",
    "address": "$address",
    "rollNo": "$rollNo",
    "acceptedBy": "$acceptedBy",
    "roomNo": "$room",
    "hostel": "$hostel",
    "passType": "$passType"
  }
}

EOL;
                        echo $htmlContent;
                    }
                } else {
                    header("Content-Type:application/json");
                    echo '{"Message":"something went wrong","action":"failure"}';
                }
            } else if ($passBooked[1]) {
                $orginal_json = $pass->entryThePass($rollNo, "working_days_pass");
                $entry = json_decode($orginal_json, true);

                if ($entry) {
                    if ($entry['action'] == 'success') {
                        $msg = $entry['Message'];
                        $action = $entry['action'];
                        $profile = "https://srechostel.in/api/profile/?auth_token_id=".$_GET['auth_token_id'];
                        $name = $row['stud_name'];
                        $dept = $row['department'];
                        $timeLeave = $row['time_of_leave'];
                        $timeEnter = $row['time_of_entry'];
                        $address = $row['address_name'];
                        $time = new DateTime($timeLeave);
                        $dateLeave = $time->format('j-n-Y');
                        $timeLeave = $time->format('h:i A');
                        $time = new DateTime($timeEnter);
                        $dateEnter = $time->format('j-n-Y');
                        $timeEnter = $time->format('h:i A');
                        $a = $pass->getRoomAndHostel($rollNo);
                        $acceptedBy = $row['accepted_by'];
                        $room = $a[0];
                        $hostel = $a[1];
                        $passType = "Out pass";
                        header("Content-Type:application/json");
                        // echo '["status:"'.$entry.',"details":'.']';
                        $htmlContent = <<<EOL
                        {
  "status": {
    "Message": "$msg",
    "action": "$action"
  },
  "details": {
    "name": "$name",
    "dept": "$dept",
    "profile_url":"$profile",
    "timeLeave": "$timeLeave",
    "timeEnter": "$timeEnter",
    "dateLeave": "$dateLeave",
    "dateEnter": "$dateEnter",
    "address": "$address",
    "rollNo": "$rollNo",
    "acceptedBy": "$acceptedBy",
    "roomNo": "$room",
    "hostel": "$hostel",
    "passType": "$passType"
  }
}

EOL;
                        echo $htmlContent;
                    }
                } else {
                    header("Content-Type:application/json");
                    echo '{"Message":"something went wrong","action":"failure"}';
                }
            } else if ($passBooked[2]) {
                $orginal_json = $pass->entryThePass($rollNo, "general_home_pass");
                $entry = json_decode($orginal_json, true);

                if ($entry) {
                    if ($entry['action'] == 'success') {
                        $msg = $entry['Message'];
                        $action = $entry['action'];
                        $name = $row['stud_name'];
                        $profile = "https://srechostel.in/api/profile/?auth_token_id=".$_GET['auth_token_id'];
                        $dept = $row['department'];
                        $timeLeave = $row['time_of_leave'];
                        $timeEnter = $row['time_of_entry'];
                        $address = $row['address_name'];
                        $time = new DateTime($timeLeave);
                        $dateLeave = $time->format('j-n-Y');
                        $timeLeave = $time->format('h:i A');
                        $time = new DateTime($timeEnter);
                        $dateEnter = $time->format('j-n-Y');
                        $timeEnter = $time->format('h:i A');
                        $a = $pass->getRoomAndHostel($rollNo);
                        $acceptedBy = $row['accepted_by'];
                        $room = $a[0];
                        $hostel = $a[1];
                        $passType = "Out pass";
                        header("Content-Type:application/json");
                        // echo '["status:"'.$entry.',"details":'.']';
                        $htmlContent = <<<EOL
                        {
  "status": {
    "Message": "$msg",
    "action": "$action"
  },
  "details": {
    "name": "$name",
    "dept": "$dept",
    "profile_url":"$profile",
    "timeLeave": "$timeLeave",
    "timeEnter": "$timeEnter",
    "dateLeave": "$dateLeave",
    "dateEnter": "$dateEnter",
    "address": "$address",
    "rollNo": "$rollNo",
    "acceptedBy": "$acceptedBy",
    "roomNo": "$room",
    "hostel": "$hostel",
    "passType": "$passType"
  }
}

EOL;
                        echo $htmlContent;
                    }
                } else {
                    header("Content-Type:application/json");
                    echo '{"Message":"something went wrong","action":"failure"}';
                }
            }
        } else {
            // header("Content-Type:application/json");
            if ($passBooked[0]) {
                header("Content-Type:application/json");
                echo '{"status":{"Message":"admin not accepted out pass","action":"failure"}}';
            } else if ($passBooked[1]) {
                header("Content-Type:application/json");
                echo '{"status":{"Message":"admin not accepted working day pass","action":"failure"}}';
            } else if ($passBooked[2]) {
                header("Content-Type:application/json");
                echo '{"status":{"Message":"admin not accepted general home pass","action":"failure"}}';
            } else {
                header("Content-Type:application/json");
                echo '{"status":{"Message":"Something went wrong","action":"failure"}}';
            }
        }
    } else {

        header("Content-Type:application/json");
        echo '{"status":{"Message":"none of the pass is booked","action":"failure"}}';
    }
} else {
    header("Content-Type:application/json");
    echo '{"Message":"you are unable to access the resources","action":"failure"}';
}
