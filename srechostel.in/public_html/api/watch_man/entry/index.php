<?php
// Allow CORS for all origins
// Allow specific HTTP methods
// Allow specific headers

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// echo $_SERVER['DOCUMENT_ROOT'];

include_once $_SERVER['DOCUMENT_ROOT'] . "/is-watch-man.php";

if (isset($_GET['auth_session_id']) && isset($_GET['auth_token_id']) && isset($_GET['pass_id'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/api/common.class.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/api/pass.class.php";

    $common = new commonClass();

    // Sanitize input
    $authTokenId = filter_input(INPUT_GET, 'auth_token_id', FILTER_SANITIZE_STRING);

    // Decode and decrypt the token
    $encrypted = urldecode($authTokenId);
    $encrypted = str_replace("sk", "+", $encrypted);
    $encrypted = base64_decode($encrypted);
    $method = "AES-256-CBC";
    $key = "secret";
    $iv = substr($encrypted, 0, openssl_cipher_iv_length($method));
    $encrypted = substr($encrypted, openssl_cipher_iv_length($method));
    $rollNo = openssl_decrypt($encrypted, $method, $key, 0, $iv);

    $pass = new Pass_class();
    $passBooked = $pass->alreadyBooked($rollNo);

    if ($passBooked[0] || $passBooked[1] || $passBooked[2]) {
        $isValid = false;
        $row = [];

        if ($passBooked[0]) {
            $passType = "gate_pass";
            if ($pass->isPassAcceptedWatch("gate_pass", $rollNo)) {
                $row = $pass->getMyPassWatch("gate_pass", $rollNo);
                $isValid = true;
            }
        } elseif ($passBooked[1]) {
            $passType = "working_pass";
            if ($pass->isPassAcceptedWatch("working_day_pass", $rollNo)) {
                $row = $pass->getMyPassWatch("working_pass", $rollNo);
                $isValid = true;
            }
        } elseif ($passBooked[2]) {
            $passType = "general_pass";
            if ($pass->isPassAcceptedWatch("general_pass", $rollNo)) {
                $row = $pass->getMyPassWatch("general_pass", $rollNo);
                $isValid = true;
            }
        }

        if ($isValid) {
            $hostel = $pass->getRoomAndHostel($rollNo)[1];
            $pass_id = $_GET['pass_id'];
            // $orginal_json = $pass->entryThePass($rollNo, $passType,$hostel, $pass_id);
            $orginal_json = $pass->entryThePass($rollNo, $passType,"Women", $pass_id);
            $entry = json_decode($orginal_json, true);

            if ($entry && $entry['action'] == 'success') {
                $msg = $entry['Message'];
                $action = $entry['action'];
                $profile = "https://srechostel.in/api/profile/?auth_token_id=" . $authTokenId;
                $name = $row['stud_name'];
                $dept = $row['department'];
                $timeLeave = (new DateTime($row['time_of_leave']))->format('h:i A');
                $dateLeave = (new DateTime($row['time_of_leave']))->format('j-n-Y');
                $timeEnter = (new DateTime($row['time_of_entry']))->format('h:i A');
                $dateEnter = (new DateTime($row['time_of_entry']))->format('j-n-Y');
                $address = $row['address_name'];
                $acceptedBy = $row['accepted_by'];
                $room = $pass->getRoomAndHostel($rollNo)[0];
                $passType = "Out pass";

                $response = [
                    "status" => [
                        "Message" => $msg,
                        "action" => $action,
                    ],
                    "details" => [
                        "name" => $name,
                        "dept" => $dept,
                        "profile_url" => $profile,
                        "timeLeave" => $timeLeave,
                        "timeEnter" => $timeEnter,
                        "dateLeave" => $dateLeave,
                        "dateEnter" => $dateEnter,
                        "address" => $address,
                        "rollNo" => $rollNo,
                        "acceptedBy" => $acceptedBy,
                        "roomNo" => $room,
                        "hostel" => $hostel,
                        "passType" => $passType,
                    ]
                ];

                header("Content-Type: application/json");
                echo json_encode($response);
            } else {
                header("Content-Type: application/json");
                echo json_encode(["Message" => "something went wrong", "action" => "failure"]);
            }
        } else {
            header("Content-Type: application/json");
            echo json_encode(["status" => ["Message" => "admin not accepted pass", "action" => "failure"]]);
        }
    } else {
        header("Content-Type: application/json");
        echo json_encode(["status" => ["Message" => "none of the pass is booked", "action" => "failure"]]);
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(["Message" => "you are unable to access the resources", "action" => "failure"]);
}
