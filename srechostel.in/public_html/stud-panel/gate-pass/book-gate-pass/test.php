<?php
//this helps to provide unauthorized access to others
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-stud.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pass Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">



  <style>
  body {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-style: normal;
}
</style>

    <style>
        .btn-orange {
            --bs-btn-color: #fff;
            --bs-btn-bg: #eb901a;
            --bs-btn-border-color: #eb901a;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #e99c38;
            --bs-btn-hover-border-color: #eb901a;
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #eb901a;
            --bs-btn-active-border-color: #eb901a;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #eb901a;
            --bs-btn-disabled-border-color: #eb901a
        }
    </style>
</head>

<body>

    <?php
    if (isset($_SESSION["yourToken"])) {
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
        $pass = new Pass_class();
        $alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);
        // $isPassExt = $pass->isPassExtension($_SESSION["yourToken"]);
        // $alreadyBooked = 1 == 2;
        if ($alreadyBooked[0] || $alreadyBooked[1] || $alreadyBooked[2]) {
            $allowed = $pass->isPassAccepted("general_pass");
            ?>
            <div class="p-5 m-3 bg-body-tertiary rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 mb-2 fw-bold">You Already Booked Your<?php

                    if ($alreadyBooked[2]) {
                        echo " Home ";
                    } else if ($alreadyBooked[1]) {
                        echo " Gate ";
                    } else {
                        echo " Working ";
                    }
                    ?>

                        Pass</h1>

                    <?php
                    if ($alreadyBooked[1] || $alreadyBooked[2] && $allowed) {
                        ?>
                        <p class="col-md-8 fs-4">Need Leave Extension ? </p>
                        <a href="../extra-leave/" class="btn btn-orange btn-lg text-white mb-2" type="button">Click to book</a>
                        <?php
                    } else {
                        ?>
                        <p class="col-md-8 fs-4">Please wait for accept</p>
                        <a href=".." class="btn btn-orange btn-lg text-white mb-2" type="button">Go back</a>
                        <?php
                    }

                    if ($alreadyBooked[1] || $alreadyBooked[2] && $allowed) {
                        $studDet = $pass->getMyPass("general_pass");
                        // print_r($studDet);
                        echo "<style>
                                .col-width{
                                    width:auto;                                    
                                }
                                </style>"
                            ?>

                        <div id="pageprint">
                            <div class="col-width">
                                <div class="card shadow-sm">
                                    <!-- <img class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> -->
                                    <div class="card-body w-100">
                                        <h1>GatePass</h1>
                                        <p class="card-text">
                                            Name : <b><?php echo $studDet['stud_name'] ?></b> <br>
                                            Roll No : <b><?php echo $studDet['roll_no'] ?></b> <br>
                                            Department : <b><?php echo $studDet['department'] ?></b> <br>
                                            From Date : <b><?php echo $studDet['from_date'] ?></b> <br>
                                            To Date : <b><?php echo $studDet['to_date'] ?></b> <br>
                                            <?php
                                            $date = strtotime($studDet['time_of_leave']);
                                            $time = date('H:i:s', $date);
                                            ?>
                                            Time of Leave : <b><?php echo $time ?></b> <br>
                                            <?php
                                            $date = strtotime($studDet['time_of_enter']);
                                            $time = date('H:i:s', $date);
                                            ?>
                                            Time of Enter : <b><?php echo $time ?></b> <br>
                                            Address : <b><?php echo $studDet['address_name'] ?></b> <br>


                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success">Approved By Poovaiah</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo "     <button class='btn btn-orange btn-lg mt-2' type='button' onclick='downloadCode();'>Download Pass</button>
                                <script>
                                function generatePDF() {
                                
                                const element = document.getElementById('pageprint');
                                
                                html2pdf().from(element).save('download.pdf'); 
                                }
                                
                                function downloadCode(){
                                var x = document.getElementById('reportbox');  
                                generatePDF();
                                setTimeout(function() { window.location=window.location;},8000);}
                            </script>
                                ";

                    }
                    ?>

                </div>
            </div>
            <?php

        } else {
            ?>
            <?php
            //this checks the passtype is set or not
            if (isset($_POST["passType"])) {
                include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
                include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
                $studDetail = new commonClass();
                $details = $studDetail->getStudDetails($_SESSION["yourToken"]);
                $pass = new Pass_class();
                $passType = $_POST["passType"];
                if ($passType == "gatePass") {
                    if (
                        isset($details["name"]) and
                        isset($details["roll_no"]) and
                        isset($details["department"]) and
                        isset($_POST["time_out"]) and
                        isset($_POST["time_in"]) and
                        isset($_POST["address"])
                        // this if check the all values are correctly set 
                    ) {
                        // this is the place inside the gatepass if all the values are set correctly
                        $array = array(
                            "name" => $details["name"],
                            "roll_no" => $details["roll_no"],
                            "department" => $details["department"],
                            "time_out" => $_POST["time_out"],
                            "time_in" => $_POST["time_in"],
                            "address" => $_POST["address"]
                        );
                        $result = $pass->setGatePass($array);
                        if ($result) {
                            ?>
                            <div class="p-5 m-3 bg-body-tertiary rounded-3">
                                <div class="container-fluid py-5">
                                    <h1 class="display-5 mb-2 fw-bold">Gatepass Booked Successfully</h1>
                                    <p class="col-md-8 fs-4">Enjoy Your Day :)</p>
                                    <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // this is print in the frontend when the record is not added in fornt page
                        ?>
                        <div class="p-5 m-4 bg-body-tertiary rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="display-5 mb-2 fw-bold">Record Not Added</h1>
                                <p class="col-md-8 fs-4">Please Contact Hostel Warden</p>
                                <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                            </div>
                        </div>
                        <?php
                    }


                } 
                else if ($passType == "workingDays") {
                    if (
                        isset($details["name"]) and
                        isset($details["roll_no"]) and
                        isset($details["department"]) and
                        isset($_POST["tutor_name"]) and
                        isset($_POST["academic_coordinator_name"]) and
                        isset($_POST["time_of_leaving"]) and
                        isset($_POST["time_of_entry"]) and
                        isset($_POST["address"])
                        // this if check the all values are correctly set 
                    ) {
                        // this is the place inside the workingday if all the values are set correctly
                        $array = array(
                            "name" => $details["name"],
                            "roll_no" => $details["roll_no"],
                            "department" => $details["department"],
                            "tutor_name" => $_POST["tutor_name"],
                            "ac_name" => $_POST["academic_coordinator_name"],
                            "time_of_leaving" => $_POST["time_of_leaving"],
                            "time_of_entry" => $_POST["time_of_entry"],
                            "address" => $_POST["address"]
                        );
                        $result = $pass->setWorkingDayPass($array);
                        if ($result) {
                            ?>
                                <div class="p-5 m-3 bg-body-tertiary rounded-3">
                                    <div class="container-fluid py-5">
                                        <h1 class="display-5 mb-2 fw-bold">Pass Booked Successfully</h1>
                                        <p class="col-md-8 fs-4">You Booked It</p>
                                        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                                    </div>
                                </div>
                            <?php
                        }
                    } else {
                        // this is print in the frontend when the record is not added in fornt page
    
                        ?>
                            <div class="p-5 m-4 bg-body-tertiary rounded-3">
                                <div class="container-fluid py-5">
                                    <h1 class="display-5 mb-2 fw-bold">Record Not Added</h1>
                                    <p class="col-md-8 fs-4">Please Contact Hostel Warden</p>
                                    <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                                </div>
                            </div>
                        <?php
                    }

                }
                 else if ($passType == "generalDays") {
                    if (
                        isset($details["name"]) and
                        isset($details["roll_no"]) and
                        isset($details["department"]) and
                        isset($_POST["time_of_leaving"]) and
                        isset($_POST["time_of_entry"]) and
                        isset($_POST["address"])
                        // this if check the all values are correctly set 
                    ) {
                        // this is the place inside the generalday if all the values are set correctly
                        $array = array(
                            "name" => $details["name"],
                            "roll_no" => $details["roll_no"],
                            "department" => $details["department"],
                            "time_of_leaving" => $_POST["time_of_leaving"],
                            "time_of_entry" => $_POST["time_of_entry"],
                            "address" => $_POST["address"]
                        );
                        $result = $pass->setGeneralDayPass($array);
                        if ($result) {
                            // $name = $details['name'];
                            // $roll_no = $details['roll_no'];
                            // $dept = $details['department'];
                            // $studyYear=$details['year_of_study'];
                            // $json = "{'name':'$name','rollNo':$roll_no,'department':'$dept','studyYear':$studyYear}";
                            // chdir($_SERVER['DOCUMENT_ROOT']);
                            // $a=exec("python call.py $json");
                            ?>
                                    <div class="p-5 m-3 bg-body-tertiary rounded-3">
                                        <div class="container-fluid py-5">
                                            <h1 class="display-5 mb-2 fw-bold">Pass Booked Successfully</h1>
                                            <p class="col-md-8 fs-4">You Booked It</p>
                                            <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                                        </div>
                                    </div>
                            <?php
                        }

                    } else {
                        // this is print in the frontend when the record is not added in fornt page
    
                        ?>
                                <div class="p-5 m-4 bg-body-tertiary rounded-3">
                                    <div class="container-fluid py-5">
                                        <h1 class="display-5 mb-2 fw-bold">Record Not Added</h1>
                                        <p class="col-md-8 fs-4">Please Contact Hostel Warden</p>
                                        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                                    </div>
                                </div>
                        <?php
                    }

                } else if ($passType == "passExtension") {
                    if (
                        isset($details["name"]) and
                        isset($details["roll_no"]) and
                        isset($details["department"]) and
                        isset($_POST["days_to_extend"]) and
                        isset($_POST["from_date"]) and
                        isset($_POST["to_date"]) and
                        isset($_POST["reason"])
                    ) {

                        // this is the place inside the passextension if all the values are set correctly
                        $array = array(
                            "name" => $details["name"],
                            "roll_no" => $details["roll_no"],
                            "department" => $_POST["department"],
                            "days_to_extend" => $_POST["days_to_extend"],
                            "from_date" => $_POST["from_date"],
                            "to_date" => $_POST["to_date"],
                            "reason" => $_POST["reason"]
                        );
                        $pass->setPassExtension($array);
                    } else {
                        // this message is show when we occur any error in our page
                        ?>
                                    <div class="p-5 m-4 bg-body-tertiary rounded-3">
                                        <div class="container-fluid py-5">
                                            <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
                                            <p class="col-md-8 fs-4">Please Try Again :(</p>
                                            <a href="../../logout/" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                                        </div>
                                    </div>
                        <?php
                    }
                }
            } else {
                ?>
                <style>
                    .headerImg1 {
                        width: 7%;
                        height: 7%;
                        float: left;
                    }

                    .headerImg2 {
                        width: 10%;
                        height: 10%;
                        float: right;
                    }

                    .heads {
                        background-color: #212529;
                        color: #fff;
                        width: 100%;
                        border-top-left-radius: 8px;
                        border-top-right-radius: 8px;
                    }

                    .bullet {
                        margin-left: 0%;
                        align-items: start;
                    }


                    .clge-name {
                        font-size: 250%;
                    }

                    p {
                        font-size: 120%;
                    }

                    body {
                        background-color: #f4f4f4;
                        height: 100vh;
                        justify-content: center;
                        align-items: center;
                        display: flex;
                    }

                    .padcen {
                        padding: 20px;
                    }

                    .login-container {
                        background-color: #fff;
                        margin: auto;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        max-width: 600px;
                        width: 600px;
                    }

                    .login-container label {
                        font-weight: bold;
                    }

                    .login-container input {
                        padding: 8px;
                        margin-bottom: 16px;
                        box-sizing: border-box;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                    }





                    input::-webkit-outer-spin-button,
                    input::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }

                    .mt-6 {
                        margin-top: 10%;
                    }

                    .pass-type-selection {
                        margin-bottom: 20px;
                    }

                    .btn-orange {
                        --bs-btn-color: #fff;
                        --bs-btn-bg: #eb901a;
                        --bs-btn-border-color: #eb901a;
                        --bs-btn-hover-color: #fff;
                        --bs-btn-hover-bg: #e99c38;
                        --bs-btn-hover-border-color: #eb901a;
                        --bs-btn-focus-shadow-rgb: 49, 132, 253;
                        --bs-btn-active-color: #fff;
                        --bs-btn-active-bg: #eb901a;
                        --bs-btn-active-border-color: #eb901a;
                        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                        --bs-btn-disabled-color: #fff;
                        --bs-btn-disabled-bg: #eb901a;
                        --bs-btn-disabled-border-color: #eb901a
                    }
                </style>

                </head>

                <body style="background-color: #f8f9fa;">
                    <div class="login-container mt-5 ms-2 me-2 ">
                        <div class="heads py-2 rounded-1">
                            <h2 class="text-center">OUT PASS</h2>
                        </div>
                        <div class="padcen rounded">
                            <div class="pass-type-selection ">
                                <label for="">Select Pass Type</label><br>
                                <div class="in">
                                    <input type="radio" id="gatePass" name="pass_type" value="gate_pass" class="bullet" required>
                                    <label for="gatePass">Gate Pass for outing</label><br>
                                </div>

                                <input type="radio" id="collegeWorkingDays" name="pass_type" value="college_working_days"
                                    class="bullet" required>
                                <label for="collegeWorkingDays">Gate pass during working days</label><br>

                                <input type="radio" id="generalHolidays" name="pass_type" value="general_holidays" class="bullet"
                                    required>
                                <label for="generalHolidays">Gate pass during general holidays</label><br>


                            </div>
                            <form action="../book-gate-pass/" method="post" id="passForm" enctype="multipart/form-data">
                                <div id="passDetails"></div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-dark container-fluid rounded-1" type="submit">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script src="/js-files/gate-pass.js"></script>
                    <?php
            }
        }
    } else {
        ?>
            <div class="p-5 m-4 bg-body-tertiary rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
                    <p class="col-md-8 fs-4">Please Go Back</p>
                    <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                </div>
            </div>
            <?php
    }
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    </body>

</html>