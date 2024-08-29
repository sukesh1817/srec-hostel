<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download pass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
    <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
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

.container {
  text-align: center;
  max-width: 40em;
  padding: 2em;
}

    </style>
</head>
<body>
    

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-stud.php";
use Dompdf\Dompdf;
use Dompdf\Options;
include_once $_SERVER['DOCUMENT_ROOT'] . "/../composer/vendor/autoload.php";
if(isset($_SESSION['yourToken'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/pass.class.php";
    $pass = new Pass_class();
    $passBooked = $pass->alreadyBooked($_SESSION['yourToken']);
    if($passBooked[0] or $passBooked[1] or $passBooked[2]) {
        $passType="";
        $isValid=false;
        $row=[];
        $rollNo = $_SESSION['yourToken'];
        if($passBooked[0]) {
            $passType="gate_pass";
            if($pass->isPassAccepted("gate_pass")){
                $row = $pass->getMyPass("gate_pass");
                $isValid=true;
            }
        } else if($passBooked[1]){
            $passType="working_pass";
            $sqlQuery = "SELECT * FROM working_days_pass WHERE roll_no=$rollNo;";
            if($pass->isPassAccepted("working_day_pass")){
                $row = $pass->getMyPass("working_pass");
                $isValid=true;
            }
        } else if($passBooked[2]){
            $passType="general_pass";
            $sqlQuery = "SELECT * FROM general_home_pass WHERE roll_no=$rollNo;";
            if($pass->isPassAccepted("general_pass")){
                $row = $pass->getMyPass("general_pass");
                $isValid=true;
            }
        }
        if($isValid){
            $name = $row['stud_name'];
            $dept = $row['department'];
            $timeLeave=$row['time_of_leave'];
            $timeEnter=$row['time_of_entry'];
            $address=$row['address_name'];
            $rollNo = $_SESSION['yourToken'];

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            
            $dompdf = new Dompdf($options);
            
            // HTML content
            $htmlContent = <<<EOL
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Contact Information Table</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                    crossorigin="anonymous">
                    <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <style>
              body {
              font-family: "Poppins", sans-serif;
              font-weight: 400;
              font-style: normal;
              font-size:35px
            }
            </style>
            </head>
            
            <body class="bg-light vh-100 m-2">
                <div class="container d-flex justify-content-center align-items-center mt-4">
            
            
                    <div class="card shadow-sm" style="max-width: 600px; width: 100%;">
                    <h2 class="display-5 text-center">Gate Pass</h2>
                        <div class="card-body">
                            <div class="row mb-3 ">
                                <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex align-items-center border-bottom">
                                    <!-- <img src="user-icon.png" alt="User Icon" class="me-2" style="width: 16px; height: 16px;"> -->
                                    <div>
                                        <p class="mb-0 fw-bold">Student Name</p>
                                        <p class="mb-0 text-muted">$name</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 d-flex align-items-center border-bottom">
                                    <!-- <img src="company-icon.png" alt="Company Icon" class="me-2" style="width: 16px; height: 16px;"> -->
                                    <div> 
                                        <p class="mb-0 fw-bold">Rollno</p>
                                        <p class="mb-0 text-muted">$rollNo</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6 mb-3 mb-md-0 border-bottom">
                                    <div class="fw-bold">From</div>
                                    <div>
                                        <p class="mb-0 text-muted ">$timeLeave</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 border-bottom">
                                    <div class="fw-bold">To</div>
                                    <div>
                                        <p class="mb-0 text-muted ">$timeEnter</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6 mb-3 mb-md-0 border-bottom">
                                    <div class=" fw-bold">Address</div>
                                    <div>
                                        <p class="mb-0 text-muted">$address</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 ">
                                    <div class="fw-bold">Department</div>
                                    <div>
                                        <p class="mb-0 text-muted ">$dept</p>
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                    crossorigin="anonymous"></script>
            </body>
            
            </html>
            
EOL;
    echo "Hello";
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            // print_r($dompdf);
            $dompdf->stream("pass.pdf", array("Attachment" => 1));
        } else {
            // header("Content-Type:application/json");
            if($passBooked[0]){
                ?>
<div class="container mt-4">

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
        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z" fill="black" />
      </svg>
    </div>
    <div class="details-modal-title">
      <h1>out pass not approved</h1>
    </div>
    <div class="details-modal-content">
      <p>
        You booked your out pass successfully, But unfortunately the admin did not accepted your out pass, please contact the admin and tell about your out pass booking and approve it
      </p>
      <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
    </div>
  </div>
</details>
</div>
                <?php
                // echo '{"Pass Type":"Out Pass","Messgae":"Admin not accepted"}';
            } else if($passBooked[1]){
                ?>
<div class="container mt-4">

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
        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z" fill="black" />
      </svg>
    </div>
    <div class="details-modal-title">
      <h1>working day pass not approved</h1>
    </div>
    <div class="details-modal-content">
      <p>
        You booked your out pass successfully, But unfortunately the admin did not accepted your out pass, please contact the admin and tell about your working day pass booking and approve it
      </p>
      <a class="btn btn-dark rounded-1" href="/stud-panel/gate-pass/">Go back</a>
    </div>
  </div>
</details>
</div>
                <?php

            } else if($passBooked[2]){
                ?>
<div class="container mt-4">

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
        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z" fill="black" />
      </svg>
    </div>
    <div class="details-modal-title">
      <h1>out pass not approved</h1>
    </div>
    <div class="details-modal-content">
      <p>
        You booked your general home pass successfully, But unfortunately the admin did not accepted your out pass, please contact the admin and tell about your general home pass booking and approve it
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
<div class="container mt-4">

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
        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z" fill="black" />
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

</body>
</html>

