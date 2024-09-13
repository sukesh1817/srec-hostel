<?php

// qr code utilities.
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// check the login user is student.
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download pass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
    <style>
        .details-modal {
            background: #ffffff;
            border-radius: 0.5em;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            left: 50%;
            max-width: 90%;
            pointer-events: none;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 30em;
            text-align: left;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .details-modal .details-modal-close {
            align-items: center;
            color: #111827;
            display: flex;
            height: 4.5em;
            justify-content: center;
            pointer-events: none;
            position: absolute;
            right: 0;
            top: 0;
            width: 4.5em;
        }

        .details-modal .details-modal-close svg {
            display: block;
        }

        .details-modal .details-modal-title {
            color: #111827;
            padding: 1.5em 2em;
            pointer-events: all;
            position: relative;
            width: calc(100% - 4.5em);
        }

        .details-modal .details-modal-title h1 {
            font-size: 1.25rem;
            font-weight: 600;
            line-height: normal;
        }

        .details-modal .details-modal-content {
            border-top: 1px solid #e0e0e0;
            padding: 2em;
            pointer-events: all;
            overflow: auto;
        }

        .details-modal-overlay {
            transition: opacity 0.2s ease-out;
            pointer-events: none;
            background: rgba(15, 23, 42, 0.8);
            position: fixed;
            opacity: 0;
            bottom: 0;
            right: 0;
            left: 0;
            top: 0;
        }

        details[open] .details-modal-overlay {
            pointer-events: all;
            opacity: 0.5;
        }

        details summary {
            list-style: none;
        }

        details summary:focus {
            outline: none;
        }

        details summary::-webkit-details-marker {
            display: none;
        }

        code {
            font-family: Monaco, monospace;
            line-height: 100%;
            background-color: #2d2d2c;
            padding: 0.1em 0.4em;
            letter-spacing: -0.05em;
            word-break: normal;
            border-radius: 7px;
            color: white;
            font-weight: normal;
            font-size: 1.75rem;
            position: relative;
            top: -2px;
        }

        .container-1 {
            text-align: center;
            max-width: 40em;
            padding: 2em;
        }
    </style>
</head>

<body>

    <?php

    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // include the composer autoload function.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/../../composer/vendor/autoload.php";

    // include the pass class files.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/../../class-files/pass.class.php";

    // check the session is exists.
    if (isset($_SESSION['yourToken'])) {
        $pass = new Pass_class();
        $passBooked = $pass->alreadyBooked($_SESSION['yourToken']);
        if ($passBooked[0] or $passBooked[1] or $passBooked[2]) {
            $passType = "";
            $isValid = false;
            $row = [];
            $rollNo = $_SESSION['yourToken'];
            if ($passBooked[0]) {
                $passType = "gate_pass";
                if ($pass->isPassAccepted("gate_pass")) {

                    $row = $pass->getMyPass("gate_pass");
                    $isValid = true;
                }
            } else if ($passBooked[1]) {
                $passType = "working_pass";
                $sqlQuery = "SELECT * FROM working_days_pass WHERE roll_no=$rollNo;";
                if ($pass->isPassAccepted("working_day_pass")) {
                    $row = $pass->getMyPass("working_pass");
                    $isValid = true;
                }
            } else if ($passBooked[2]) {
                $passType = "general_pass";
                $sqlQuery = "SELECT * FROM general_home_pass WHERE roll_no=$rollNo;";
                if ($pass->isPassAccepted("general_home_pass")) {
                    $row = $pass->getMyPass("general_pass");
                    $isValid = true;
                }
            }
            if ($isValid) {
                $status = $row['allowed_or_not'];
                $options = new QROptions(
                    [
                        'eccLevel' => QRCode::ECC_L,
                        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                        'version' => 10,
                    ]
                );

                $domainName = "srechostel.in";
                $data = $_SESSION['yourToken'];

                // Define the secret key
                $key = "secret";

                // Define the encryption method
                $method = "AES-256-CBC";

                // Generate a random initialization vector (IV)
                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

                // Encrypt the data
                $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);

                // Concatenate the IV and the encrypted data
                $encrypted = base64_encode($iv . $encrypted);
                $encrypted = str_replace("+", "sk", $encrypted);



                // Display the encrypted data
    
                // Decode the encrypted data
    
                $qrcode = (new QRCode($options))->render("https://$domainName/api/entry/?auth_token_id=$encrypted");
                ?>
                <style>
                    /* styles.css */
                    /*body {*/
                    /*  display: flex;*/
                    /*  justify-content: center;*/
                    /*  align-items: center;*/
                    /*  height: 100vh;*/
                    /*  background-color: #f0f0f0;*/
                    /*}*/

                    .container-fluid {
                        position: relative;
                        text-align: center;
                    }

                    #reader {
                        width: 300px;
                        height: 300px;
                        margin-top: 20px;
                    }

                    #success-animation {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        color: green;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }

                    .hidden {
                        display: none;
                    }

                    .checkmark {
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        display: inline-block;
                        border: 5px solid green;
                        position: relative;
                        animation: success-animation 0.5s ease-in-out;
                    }

                    .checkmark::after {
                        content: '';
                        width: 25px;
                        height: 10px;
                        border: 5px solid green;
                        border-top: none;
                        border-right: none;
                        transform: rotate(-45deg);
                        position: absolute;
                        top: 50%;
                        left: 15%;
                        transform-origin: left bottom;
                    }

                    @keyframes success-animation {
                        0% {
                            transform: scale(0);
                        }

                        70% {
                            transform: scale(1.1);
                        }

                        100% {
                            transform: scale(1);
                        }
                    }
                </style>
                <div class="container-fluid my-5">
                    <div class="p-5 text-center bg-body-secondary rounded-3">
                        <img class="rounded img-fluid" src='<?= $qrcode ?>' alt='QR Code' width='300' height='300'>
                        <div class='mt-3'>
                            <h1 class="text-body-emphasis">Scan QR</h1>
                            <p class="col-lg-8 mx-auto fs-5 text-muted">
                                Scan this QR to
                                <?php if ($row['allowed_or_not'] == 1) {
                                    echo "check out";
                                } else if ($row['allowed_or_not'] == 2) {
                                    echo "check in";
                                } ?>
                                the student
                            </p>
                        </div>
                    </div>

                </div>

                <?php

            } else {
                if ($passBooked[0]) {
                    ?>
                    <div class="container-1 mt-4">
                        <h1>
                            Hello, your out pass booked successfully.
                        </h1>
                        <p>Your out pass booked successfully , click the below button for more information.</p>
                        <details>
                            <summary>
                                <div class="btn btn-dark rounded-1">
                                    What is the problem ?
                                </div>
                                <div class="details-modal-overlay"></div>
                            </summary>
                            <div class="details-modal">
                                <div class="details-modal-close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z"
                                            fill="black" />
                                    </svg>
                                </div>
                                <div class="details-modal-title">
                                    <h1>out pass not approved</h1>
                                </div>
                                <div class="details-modal-content">
                                    <p>
                                        You booked your out pass successfully, But unfortunately the admin did not accepted your out
                                        pass, please contact the admin and tell about your out pass booking and approve it
                                    </p>
                                    <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
                                </div>
                            </div>
                        </details>
                    </div>
                    <?php
                } else if ($passBooked[1]) {
                    ?>
                        <div class="container-1 mt-4">
                            <h1>
                                Hello, your working day pass booked successfully.
                            </h1>
                            <p>Your out pass booked successfully , click the below button for more information.</p>
                            <details>
                                <summary>
                                    <div class="btn btn-dark rounded-1">
                                        What is the problem ?
                                    </div>
                                    <div class="details-modal-overlay"></div>
                                </summary>
                                <div class="details-modal">
                                    <div class="details-modal-close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="details-modal-title">
                                        <h1>working day pass not approved</h1>
                                    </div>
                                    <div class="details-modal-content">
                                        <p>
                                            You booked your out pass successfully, But unfortunately the admin did not accepted your out
                                            pass, please contact the admin and tell about your working day pass booking and approve it
                                        </p>
                                        <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
                                    </div>
                                </div>
                            </details>
                        </div>
                    <?php

                } else if ($passBooked[2]) {
                    ?>
                            <div class="container-1 mt-4">

                                <h1>
                                    Hello, your general home pass booked successfully.
                                </h1>
                                <p>Your general home pass booked successfully , click the below button for more information.</p>
                                <details>
                                    <summary>
                                        <div class="btn btn-dark rounded-1">
                                            What is the problem ?
                                        </div>
                                        <div class="details-modal-overlay"></div>
                                    </summary>
                                    <div class="details-modal">
                                        <div class="details-modal-close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z"
                                                    fill="black" />
                                            </svg>
                                        </div>
                                        <div class="details-modal-title">
                                            <h1>out pass not approved</h1>
                                        </div>
                                        <div class="details-modal-content">
                                            <p>
                                                You booked your general home pass successfully, But unfortunately the admin did not accepted
                                                your out pass, please contact the admin and tell about your general home pass booking and
                                                approve it
                                            </p>
                                            <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
                                        </div>
                                    </div>
                                </details>
                            </div>
                    <?php
                } else {
                    header("Content-Type:application/json");
                    echo '{"Messgae":"Something went wrong"}';
                }
            }
        } else {

            ?>
            <div class="container-1 mt-4">
                <h1>
                    Nothing is booked
                </h1>
                <p>None of the gate passes is booked.</p>

                <details>
                    <summary>
                        <div class="btn btn-dark rounded-1">
                            What is the problem ?
                        </div>
                        <div class="details-modal-overlay"></div>
                    </summary>
                    <div class="details-modal">
                        <div class="details-modal-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z"
                                    fill="black" />
                            </svg>
                        </div>
                        <div class="details-modal-title">
                            <h1>Nothing is booked error</h1>
                        </div>
                        <div class="details-modal-content">
                            <p>
                                You do not booked any gate passes, please book the gate pass before download it.
                            </p>
                            <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
                        </div>
                    </div>
                </details>
            </div>
            <?php

        }
    } else {
        header("Content-Type:application/json");
        echo '{"Messgae":"Please login again"}';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>