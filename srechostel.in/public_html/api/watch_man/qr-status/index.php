<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/is-watch-man.php";
//session_start();

if (isset($_SESSION['yourToken']) && isset($_GET['auth_token_id'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/common.class.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/pass.class.php";

    $common = new commonClass();
    $pass = new Pass_class();

    // Extract the IV and the encrypted data
    $encrypted = urldecode($_GET['auth_token_id']);
    $encrypted = str_replace("sk", "+", $encrypted);
    $encrypted = base64_decode($encrypted);

    $method = "AES-256-CBC";
    $key = "secret"; // Consider storing this key securely
    $ivLength = openssl_cipher_iv_length($method);
    $iv = substr($encrypted, 0, $ivLength);
    $encrypted = substr($encrypted, $ivLength);

    $rollNo = openssl_decrypt($encrypted, $method, $key, 0, $iv);

    if (!$rollNo) {
        header("Content-Type:application/json");
        echo json_encode(['Message' => 'Something went wrong in the server side.', 'action' => 'failure']);
        exit();
    }

    $passBooked = $pass->alreadyBooked($rollNo);

    if (in_array(true, $passBooked)) {
        $passType = "";
        $isValid = false;
        $row = [];

        if ($passBooked[0]) {
            $passType = "gate_pass";
            $isValid = $pass->isPassAcceptedWatch($passType, $rollNo);
            if ($isValid) {
                $row = $pass->getMyPassWatch($passType, $rollNo);
            }
        } elseif ($passBooked[1]) {
            $passType = "working_pass";
            $sqlQuery = "SELECT * FROM working_days_pass WHERE roll_no='$rollNo'";
            $isValid = $pass->isPassAcceptedWatch("working_day_pass", $rollNo);
            if ($isValid) {
                $row = $pass->getMyPassWatch($passType, $rollNo);
            }
        } elseif ($passBooked[2]) {
            $passType = "general_pass";
            $sqlQuery = "SELECT * FROM general_home_pass WHERE roll_no='$rollNo'";
            $isValid = $pass->isPassAcceptedWatch($passType, $rollNo);
            if ($isValid) {
                $row = $pass->getMyPassWatch($passType, $rollNo);
            }
        }

        if ($isValid) {
            $entry = $pass->entryThePass($rollNo, $passType);

            if ($entry) {
                $entry = json_decode($entry, true);
                header("Content-Type:application/json");
                if ($entry['action'] === 'success') {
                    $timeLeave = new DateTime($row['time_of_leave']);
                    $timeEnter = new DateTime($row['time_of_entry']);
                    $response = [
                        'status' => [
                            'Message' => $entry['Message'],
                            'action' => $entry['action']
                        ],
                        'details' => [
                            'name' => $row['stud_name'],
                            'dept' => $row['department'],
                            'timeLeave' => $timeLeave->format('h:i A'),
                            'timeEnter' => $timeEnter->format('h:i A'),
                            'dateLeave' => $timeLeave->format('j-n-Y'),
                            'dateEnter' => $timeEnter->format('j-n-Y'),
                            'address' => $row['address_name'],
                            'rollNo' => $rollNo,
                            'acceptedBy' => $row['accepted_by'],
                            'roomNo' => $pass->getRoomAndHostel($rollNo)[0],
                            'hostel' => $pass->getRoomAndHostel($rollNo)[1],
                            'passType' => "Out pass"
                        ]
                    ];
                    echo json_encode($response);
                } else {
                    echo json_encode(['Message' => 'Something went wrong', 'action' => 'failure']);
                }
            } else {
                echo json_encode(['Message' => 'Something went wrong', 'action' => 'failure']);
            }
        } else {
            $errorMessages = [
                "gate_pass" => "admin not accepted out pass",
                "working_pass" => "admin not accepted working day pass",
                "general_pass" => "admin not accepted general home pass"
            ];
            $message = $errorMessages[$passType] ?? "Something went wrong";
            echo json_encode(['Message' => $message, 'action' => 'failure']);
        }
    } else {
        echo json_encode(['Message' => 'None of the pass is booked', 'action' => 'failure']);
    }
} else {
    echo json_encode(['Message' => 'You are unable to access the resources', 'action' => 'failure']);
}
?>