<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check pass status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            /* border: 1px solid #ccc; */
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
</head>

<body>
    <?php

    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // included the gate pass class files.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/pass.class.php");

    // initialize the gate pass class.
    $pass = new Pass_class();

    // check the gate pass is already booked.
    $alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);

    if ($alreadyBooked[0] or $alreadyBooked[1] or $alreadyBooked[2]) {
        // if pass is already booked then collect the data of the student.
        $row = [];
        if ($alreadyBooked[0]) {
            $row = array($pass->getMyPass("gate_pass"), 1);
        } else if ($alreadyBooked[1]) {
            $row = array($pass->getMyPass("working_pass"), 2);
        } else if ($alreadyBooked[2]) {
            $row = array($pass->getMyPass("general_pass"), 3);
        }
        ?>
        <div class="container mb-1 mt-4" bis_skin_checked="1">
            <div class="position-relative  text-center text-muted bg-body border border-dashed rounded-2"
                bis_skin_checked="1">
                <h1 class="text-body-emphasis">
                    <?php
                    if ($row[1] == 1) {
                        echo "Gate pass information";
                    } else if ($row[1] == 2) {
                        echo "Working day pass information";

                    } else {
                        echo "General holiday pass information";
                    }
                    ?>
                </h1>
                <hr>
                <p class="col-lg-6 mx-auto mb-4">
                <div id="html-content">
                    <div class="container-1">
                        <div class="row">
                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;"
                                            src="/images/layout-image/name.png" alt=""></div>
                                    <div class="title"><?php echo $row[0]['stud_name'] ?></div>
                                    <div class="subtitle">Name</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;"
                                            src="/images/layout-image/rollno.png" alt=""></div>
                                    <div class="title"><?php echo $row[0]['roll_no'] ?></div>
                                    <div class="subtitle">Rollno</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;"
                                            src="/images/layout-image/dept.png" alt=""></div>
                                    <div class="title"><?php echo $row[0]['department'] ?></div>
                                    <div class="subtitle">Department</div>
                                </div>
                            </div>

                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;"
                                            src="/images/layout-image/dept.png" alt=""></div>
                                    <div class="title"><?php echo $row[0]['address_name'] ?></div>
                                    <div class="subtitle">Address</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php

                            // converting the date-time-local to normal dates.
                            $Fromdate = new DateTime($row[0]['time_of_leave']);
                            $ToDate = new DateTime($row[0]['time_of_entry']);
                            $from_date = $Fromdate->format('d-m-Y H:iA');
                            $to_date = $ToDate->format('d-m-Y H:iA');

                            ?>
                            <div class="col-lg-6 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;"
                                            src="/images/layout-image/from.png" alt=""></div>
                                    <div class="title">
                                        <?php
                                        echo $from_date;
                                        ?>
                                    </div>
                                    <div class="subtitle">From</div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;"
                                            src="/images/layout-image/to.png" alt=""></div>
                                    <div class="title"> <?php
                                    echo $to_date;
                                    ?></div>
                                    <div class="subtitle">To</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </p>
                <?php

                if (!($pass->isPassAccepted("gate_pass") or $pass->isPassAccepted("working_day_pass") or $pass->isPassAccepted("general_home_pass"))) {
                    ?>
                    <a href="/gate-pass/edit-gate-pass/" class="btn btn-dark px-5 mb-5 rounded-1" type="button">
                        Want To Change something
                    </a>

                </div>
            </div>
            <?php
                }
    } else {
        ?>
        <main>
            <div class="container-fluid" bis_skin_checked="1">
                <div class="border-bottom"></div>
                <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                    <div class="container-fluid py-5" bis_skin_checked="1">
                        <h1 class="display-5 fw-bold">Gate pass not booked</h1>
                        <p class="col-md-8 fs-4">Please book the gate pass to check the status of the gate pass.</p>
                        <a href="/stud-panel/gate-pass/book-gate-pass" class="btn btn-dark btn-lg rounded-1">book gate pass
                            <span id="count-down"> </span></a>
                    </div>
                </div>
            </div>
        </main>

        <?php
    }
    ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>