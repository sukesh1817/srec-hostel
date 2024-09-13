<?php
// qr code packages.
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// check the login person is student.
require_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/../../config/domain.php";
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
    // include poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
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

        .msg-container {
            text-align: center;
            max-width: 40em;
            padding: 2em;
        }
    </style>
    <style>
        .container-1 {
            max-width: 95%;
            margin: 5px auto;
            border: 1px solid #ccc;
            padding: 20px;
            background-color: white;
        }

        .box {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; */
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 1px;
            text-align: center;
            background-color: #fafafa;
            /* box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); */
        }

        .box .icon {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .box .title {
            font-weight: bold;
        }

        .box .subtitle {
            color: gray;
        }

        @media (max-width: 768px) {
            .mt-6 {
                margin-top: 100px !important;
            }
        }

        .avatar {
            vertical-align: middle;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .rounded-sharp {
            border-radius: 1px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>

    <?php
    // include poppins font.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // include autoload file in composer.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/../../composer/vendor/autoload.php";

    // include the class files of pass class.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/../../class-files/pass.class.php";

    // check the session is exits.
    if (isset($_SESSION['yourToken'])) {
        $pass = new Pass_class();
        $passBooked = $pass->alreadyBooked($_SESSION['yourToken']);
        if ($passBooked[0] or $passBooked[1] or $passBooked[2]) {
            $passType = "";
            $isValid = false;
            $row = [];
            $rollNo = $_SESSION['yourToken'];
            if ($passBooked[0]) {
                $passType = "Out pass";
                if ($pass->isPassAccepted("gate_pass")) {
                    $row = $pass->getMyPass("gate_pass");
                    $isValid = true;
                }
            } else if ($passBooked[1]) {
                $passType = "Working day pass";
                $sqlQuery = "SELECT * FROM working_days_pass WHERE roll_no=$rollNo;";
                if ($pass->isPassAccepted("working_day_pass")) {
                    $row = $pass->getMyPass("working_pass");
                    $isValid = true;
                }
            } else if ($passBooked[2]) {
                $passType = "General Holiday pass";
                $sqlQuery = "SELECT * FROM general_home_pass WHERE roll_no=$rollNo;";
                if ($pass->isPassAccepted("general_home_pass")) {
                    $row = $pass->getMyPass("general_pass");
                    $isValid = true;
                }
            }
            if ($isValid) {
                $name = $row['stud_name'];
                $dept = $row['department'];
                $timeLeave = $row['time_of_leave'];
                $timeEnter = $row['time_of_entry'];
                $address = $row['address_name'];
                $rollNo = $_SESSION['yourToken'];
                $time = new DateTime($timeLeave);
                $dateLeave = $time->format('j-n-Y');
                $timeLeave = $time->format('h:i A');
                $time = new DateTime($timeEnter);
                $dateEnter = $time->format('j-n-Y');
                $timeEnter = $time->format('h:i A');
                $a = $pass->getRoomAndHostel($_SESSION['yourToken']);
                $acceptedBy = $row['accepted_by'];
                $room = $a[0];
                $hostel = $a[1];
                $status = $row['allowed_or_not'];
                $options = new QROptions(
                    [
                        'eccLevel' => QRCode::ECC_L,
                        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                        'version' => 10,
                    ]
                );
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

                $qrcode = (new QRCode($options))->render("$domain/api/entry/?auth_token_id=$encrypted");

                $img_url = $domain."api/accounts/profile_photo/";
                // included the gate pass theme.
                require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/modules/download_pass_theme.php";
                $data = array(
                    "pass_type"=>$passType,
                    "name"=>$name,
                    "roll_no"=>$rollNo,
                    "dept"=>$dept,
                    "room_no"=>$room,
                    "hostel"=>$hostel,
                    "address"=>$address,
                    "time_leave"=>$timeLeave,
                    "date_leave"=>$dateLeave,
                    "time_enter"=>$timeEnter,
                    "date_enter"=>$dateEnter,
                    "accepted_by"=>$acceptedBy,
                    "img_url"=>$img_url
                );
                pass_theme($data);

//                 $htmlContent = <<<EOL
//                 <div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
//                     <div class="box">
//                         <div class="icon mb-2"><img style="width: 40px;height:40px;" src="/images/layout-image/download.png" alt="">
//                         </div>
//                         <div class="title mb-2"><button style="border-radius:2px;" class="btn btn-dark " id="download-button">download</button>
//                         </div>
//                         <div class="subtitle">click to download</button>
//                         </div>
//                     </div>
//                 </div>
//                 <div id="html-content">
//                     <div class="container-1">
//                         <h3 class="text-center title fw-bold">$passType</h3>
//                         <div class="row">
//                             <div class="col-lg-12 col-md-12 col-md-12 mt-1">
//                                 <div class="box">
//                                     <div class="icon">
//                                         <img class="avatar img-fluid" src='/profile-photo/' alt='profile-img' width='100' height='100'>
//                                     </div>
//                                     <div class="title">Student profile</div>
//                                     <div class="subtitle">Image</div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="row">
//                             <div class="col-lg-6 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/name.png" alt=""></div>
//                                     <div class="title">$name</div>
//                                     <div class="subtitle">Name</div>
//                                 </div>
//                             </div>
//                             <div class="col-lg-6 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/rollno.png" alt=""></div>
//                                     <div class="title">$rollNo</div>
//                                     <div class="subtitle">Rollno</div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="row">
//                         <div class="col-lg-6 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/dept.png" alt=""></div>
//                                     <div class="title">$dept</div>
//                                     <div class="subtitle">Department</div>
//                                 </div>
//                             </div>
//                         <div class="col-lg-6 col-md-6 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/room.png" alt=""></div>
//                                     <div class="title">$room</div>
//                                     <div class="subtitle">Room no</div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="row">
//                                 <div class="col-lg-6 col-md-12 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/hostel.png" alt=""></div>
//                                     <div class="title">$hostel</div>
//                                     <div class="subtitle">Hostel</div>
//                                 </div>
//                             </div>
//                             <div class="col-lg-6 col-md-12 mt-6">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/address.png" alt=""></div>
//                                     <div class="title">$address</div>
//                                     <div class="subtitle">Address</div>
//                                 </div>
//                         </div>
//                         </div>
//                         <div class="row">
                            
//                             <div class="col-lg-6 col-md-12 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/from.png" alt=""></div>
//                                     <div class="title">$timeLeave | $dateLeave</div>
//                                     <div class="subtitle">From</div>
//                                 </div>
//                             </div>
//                             <div class="col-lg-6 col-md-12 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/to.png" alt=""></div>
//                                     <div class="title">$timeEnter | $dateEnter</div>
//                                     <div class="subtitle">To</div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="row">
//                             <div class="col-lg-12 col-md-12 col-md-12 mt-1">
//                                 <div class="box">
//                                     <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/approvedby.png" alt=""></div>
//                                     <div class="title">$acceptedBy</div>
//                                     <div class="subtitle">Accepted by</div>
//                                 </div>
//                             </div>
//                         </div>
//                         <div class="row">
//                             <div class="col-lg-12 col-md-12 col-md-12 mt-1">
//                                 <div class="box">
//                                     <div class="icon">
//                                         <img class="img-fluid" src='$qrcode' alt='QR Code' width='100' height='100'>
//                                     </div>
//                                     <div class="title"><a class="text-dark" href="https://srechostel.in/stud-panel/gate-pass/qr-entry/">click to entry with qr</a></div>
//                                     <div class="subtitle">Qr Link</div>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>        
// EOL;
                // echo $htmlContent;
            } else {
                // header("Content-Type:application/json");
                if ($passBooked[0]) {
                    ?>
                    <div class="msg-container container mt-4">

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
                                        pass, please
                                        contact the admin and tell about your out pass booking and approve it
                                    </p>
                                    <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
                                </div>
                            </div>
                        </details>
                    </div>
                    <?php
                    // echo '{"Pass Type":"Out Pass","Messgae":"Admin not accepted"}';
                } else if ($passBooked[1]) {
                    ?>
                        <div class="msg-container container mt-4">

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
                                            pass, please
                                            contact the admin and tell about your working day pass booking and approve it
                                        </p>
                                        <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
                                    </div>
                                </div>
                            </details>
                        </div>
                    <?php

                } else if ($passBooked[2]) {
                    ?>
                            <div class="msg-container container mt-4">

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
                                                your out pass,
                                                please contact the admin and tell about your general home pass booking and approve it
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
            <div class="msg-container container container mt-4">

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

    <script>
        const button = document.getElementById('download-button');

        function generatePDF() {
            // Choose the element that your content will be rendered to.
            const element = document.getElementById('html-content');
            // Choose the element and save the PDF for your user.
            const opt = {
                margin: 0.5,           // Define the margins (in inches)
                html2canvas: { scale: 2 }, // Increase the scale to zoom in
            };
            html2pdf().from(element).set(opt).save("$rollNo");
        }

        button.addEventListener('click', generatePDF);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>