<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Gate Pass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

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



        .padcen {
            padding: 20px;
        }

        .login-container {
            background-color: #f4f4f4;
            background-color: #fff;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
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
    </style>
</head>

<body style="background-color: #f8f9fa;">
    <?php
    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // include the gate pass class file.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/pass.class.php");

    // include the gate pass class file.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php");


    // initialize the gate pass class.
    $pass = new Pass_class();
    ?>

    <?php
    // check the session is exist.
    if (isset($_SESSION['yourToken'])) {

        // check the anyone of the gatepass is booked.
        $alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);

        // if anyone of gatepass is booked then execute this block.
        if ($alreadyBooked[0] or $alreadyBooked[1] or $alreadyBooked[2]) {

            // this block executes when the gate pass is already booked.
            ?>

            <div class="container my-5" bis_skin_checked="1">
                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                    bis_skin_checked="1">

                    <svg class="bi mt-5 mb-3" width="48" height="48">
                        <use xlink:href="#check2-circle"></use>
                    </svg>
                    <h1 class="text-body-emphasis"><?php
                    if ($alreadyBooked[0]) {
                        echo "Out pass ";
                    } else if ($alreadyBooked[1]) {
                        echo "Working day pass ";
                    } else {
                        echo "General Holiday day pass ";
                    }
                    ?><strong>Already booked</strong></h1>
                    <p class="col-lg-6 mx-auto mb-4">
                        Your gatepass is already booked please check it
                    </p>
                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                        Check gatepass status
                    </a>
                </div>
            </div>
            <?php

        } else if (isset($_POST["passType"])) {
            // this part executes when the data is entered by the user.
            $studDetail = new commonClass();
            $details = $studDetail->getStudDetails($_SESSION["yourToken"]);
            $passType = $_POST["passType"];
            if ($passType == "gatePass") {
                if (
                    isset($details["name"]) and
                    isset($details["roll_no"]) and
                    isset($details["department"]) and
                    isset($_POST["time_out"]) and
                    isset($_POST["time_in"]) and
                    isset($_POST["address"]) and
                    isset($_POST["reason"])
                ) {
                    // this part of code executes when, all the parameters are set correctly.
                    $array = array(
                        "name" => $details["name"],
                        "roll_no" => $details["roll_no"],
                        "department" => $details["department"],
                        "time_out" => $_POST["time_out"],
                        "time_in" => $_POST["time_in"],
                        "address" => $_POST["address"],
                        "reason" => $_POST["reason"]
                    );
                    $result = $pass->setGatePass($array);
                    if ($result) {
                        //
                        ?>

                            <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Out pass <strong>Booked Successfully</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Out pass is booked successfully, to check the out pass status, click the below button
                                    </p>
                                    <a href="/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        check gatepass status
                                    </a>
                                </div>
                            </div>

                        <?php
                    } else {
                        ?>
                            <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Out pass <strong>Booked Failed</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Something went wrong, please contact admin
                                    </p>
                                    <a href="/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                        Go back
                                    </a>
                                </div>
                            </div>

                        <?php
                    }
                } else {
                    ?>
                        <div class="container my-5" bis_skin_checked="1">
                            <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                bis_skin_checked="1">

                                <svg class="bi mt-5 mb-3" width="48" height="48">
                                    <use xlink:href="#check2-circle"></use>
                                </svg>
                                <h1 class="text-body-emphasis">Out pass Booked Declined</strong></h1>
                                <p class="col-lg-6 mx-auto mb-4">
                                    Your details not added in hostel records, please contact admin
                                </p>
                                <a href="/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                    Go back
                                </a>
                            </div>
                        </div>
                    <?php
                }
            } else if ($passType == "workingDays") {

                // this part of code executes when, all the parameters are set correctly.
                if (
                    isset($details["name"]) and
                    isset($details["roll_no"]) and
                    isset($details["department"]) and
                    isset($_POST["tutor_name"]) and
                    isset($_POST["academic_coordinator_name"]) and
                    isset($_POST["time_of_leaving"]) and
                    isset($_POST["time_of_entry"]) and
                    isset($_POST["address"]) and
                    isset($_POST["reason"])
                ) {
                    $array = array(
                        "name" => $details["name"],
                        "roll_no" => $details["roll_no"],
                        "department" => $details["department"],
                        "tutor_name" => $_POST["tutor_name"],
                        "ac_name" => $_POST["academic_coordinator_name"],
                        "time_of_leaving" => $_POST["time_of_leaving"],
                        "time_of_entry" => $_POST["time_of_entry"],
                        "address" => $_POST["address"],
                        "reason" => $_POST["reason"]
                    );
                    $result = $pass->setWorkingDayPass($array);
                    if ($result) {
                        ?>

                                <div class="container my-5" bis_skin_checked="1">
                                    <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                        bis_skin_checked="1">

                                        <svg class="bi mt-5 mb-3" width="48" height="48">
                                            <use xlink:href="#check2-circle"></use>
                                        </svg>
                                        <h1 class="text-body-emphasis">Working day pass <strong>Booked Successfully</strong></h1>
                                        <p class="col-lg-6 mx-auto mb-4">
                                            Working day pass is booked successfully , to check it click the below button
                                        </p>
                                        <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                            check gatepass status
                                        </a>
                                    </div>
                                </div>
                        <?php
                    } else {
                        ?>
                                <div class="container my-5" bis_skin_checked="1">
                                    <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                        bis_skin_checked="1">

                                        <svg class="bi mt-5 mb-3" width="48" height="48">
                                            <use xlink:href="#check2-circle"></use>
                                        </svg>
                                        <h1 class="text-body-emphasis">Working day pass <strong>Booked Failed</strong></h1>
                                        <p class="col-lg-6 mx-auto mb-4">
                                            Something went wrong
                                        </p>
                                        <a href="/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                            Go back
                                        </a>
                                    </div>
                                </div>

                        <?php
                    }
                } else {
                    ?>
                            <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Working day pass Booked Declined</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Your details not added in hostel records, please contact admin
                                    </p>
                                    <a href="/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                        Go back
                                    </a>
                                </div>
                            </div>

                    <?php
                }

            } else if ($passType == "generalDays") {

                // this part of code executes when, all the parameters are set correctly.
                if (
                    isset($details["name"]) and
                    isset($details["roll_no"]) and
                    isset($details["department"]) and
                    isset($_POST["time_of_leaving"]) and
                    isset($_POST["time_of_entry"]) and
                    isset($_POST["address"]) and
                    isset($_POST["reason"])
                ) {
                    $array = array(
                        "name" => $details["name"],
                        "roll_no" => $details["roll_no"],
                        "department" => $details["department"],
                        "time_of_leaving" => $_POST["time_of_leaving"],
                        "time_of_entry" => $_POST["time_of_entry"],
                        "address" => $_POST["address"],
                        "reason" => $_POST["reason"]
                    );
                    $result = $pass->setGeneralDayPass($array);
                    if ($result) {
                        ?>

                                    <div class="container my-5" bis_skin_checked="1">
                                        <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                            bis_skin_checked="1">

                                            <svg class="bi mt-5 mb-3" width="48" height="48">
                                                <use xlink:href="#check2-circle"></use>
                                            </svg>
                                            <h1 class="text-body-emphasis">General holiday pass <strong>Booked Successfully</strong></h1>
                                            <p class="col-lg-6 mx-auto mb-4">
                                                General holiday pass is booked successfully , to check it click the below button
                                            </p>
                                            <a href="/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                                check gatepass status
                                            </a>
                                        </div>
                                    </div>

                        <?php
                    } else {
                        ?>
                                    <div class="container my-5" bis_skin_checked="1">
                                        <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                            bis_skin_checked="1">

                                            <svg class="bi mt-5 mb-3" width="48" height="48">
                                                <use xlink:href="#check2-circle"></use>
                                            </svg>
                                            <h1 class="text-body-emphasis">General holiday pass <strong>Booked Failed</strong></h1>
                                            <p class="col-lg-6 mx-auto mb-4">
                                                Something went wrong
                                            </p>
                                            <a href="/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                                Go back
                                            </a>
                                        </div>
                                    </div>
                        <?php
                    }
                } else {
                    ?>
                                <div class="container my-5" bis_skin_checked="1">
                                    <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                        bis_skin_checked="1">

                                        <svg class="bi mt-5 mb-3" width="48" height="48">
                                            <use xlink:href="#check2-circle"></use>
                                        </svg>
                                        <h1 class="text-body-emphasis">General holiday pass Booked Declined</strong></h1>
                                        <p class="col-lg-6 mx-auto mb-4">
                                            Your details not added in hostel records, please contact admin
                                        </p>
                                        <a href="/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                            Go back
                                        </a>
                                    </div>
                                </div>

                    <?php
                }

            }
        } else {
            // contains the form and take input from the user.
            ?>
                <div class="mx-auto my-3 mt-5">
                    <div class="container">
                        <div class="login-container">
                            <div class="heads py-2 rounded-1">
                                <h2 class="text-center">Gate pass</h2>
                            </div>
                            <div class="padcen rounded">
                                <div class="pass-type-selection ">
                                    <label for="">Select Pass Type</label><br>
                                    <div class="in">
                                        <input type="radio" id="gatePass" name="pass_type" value="gate_pass" class="bullet"
                                            required>
                                        <label for="gatePass">Out pass</label><br>
                                    </div>
                                    <input type="radio" id="collegeWorkingDays" name="pass_type" value="college_working_days"
                                        class="bullet" required>
                                    <label for="collegeWorkingDays">Working days pass</label><br>

                                    <input type="radio" id="generalHolidays" name="pass_type" value="general_holidays"
                                        class="bullet" required>
                                    <label for="generalHolidays">General holidays pass</label><br>
                                </div>
                                <form action="/gate-pass/book-gate-pass/" method="post" id="passForm" enctype="multipart/form-data">
                                    <div id="passDetails"></div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-dark container-fluid rounded-1" type="submit">Book the pass</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    } else {
        // this part will execute, when the session is not set.
        // tell the user to login again to reset the session.
        $domainName = "https://testing.srechostel.in/api/auth/logout/";
        ?>
        <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
            <h1 class="display-5 fw-bold text-body-emphasis">Something went wrong</h1>
            <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                <p class="lead mb-4">Please login again</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                    <a href="<?php echo $domainName; ?>" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Logout
                    </a>
                </div>
            </div>
        </div>
        <?php

    }
    ?>
</body>
<script src="/js-files/gate-pass.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>