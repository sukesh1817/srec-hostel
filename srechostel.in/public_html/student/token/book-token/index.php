<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Book Food Token</title>
    <link rel="icon" type="image/x-icon" href="/images/icons/food-icon.png">
    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>

    <style>
        @media (min-width: 767px) and (max-width:1445px) {
            .mx-200 {
                margin-left: 400px !important;
                margin-right: 400px !important;
            }

        }

        .list-group {
            width: 100%;
            max-width: 460px;
            margin-inline: 1.5rem;
        }

        .form-check-input:checked+.form-checked-content {
            opacity: .5;
        }

        .form-check-input-placeholder {
            border-style: dashed;
        }

        [contenteditable]:focus {
            outline: 0;
        }

        .list-group-checkable .list-group-item {
            cursor: pointer;
        }

        .list-group-item-check {
            position: absolute;
            clip: rect(0, 0, 0, 0);
        }

        .list-group-item-check:hover+.list-group-item {
            background-color: var(--bs-secondary-bg);
        }

        .list-group-item-check:checked+.list-group-item {
            color: #fff;
            background-color: var(--bs-dark);
            border-color: var(--bs-dark);
        }

        .list-group-item-check[disabled]+.list-group-item,
        .list-group-item-check:disabled+.list-group-item {
            pointer-events: none;
            filter: none;
            opacity: .5;
        }

        .list-group-radio .list-group-item {
            cursor: pointer;
            border-radius: .5rem;
        }

        .list-group-radio .form-check-input {
            z-index: 2;
            margin-top: -.5em;
        }

        .list-group-radio .list-group-item:hover,
        .list-group-radio .list-group-item:focus {
            background-color: var(--bs-secondary-bg);
        }

        .list-group-radio .form-check-input:checked+.list-group-item {
            background-color: var(--bs-body);
            border-color: var(--bs-dark);
            box-shadow: 0 0 0 2px var(--bs-dark);
        }

        .list-group-radio .form-check-input[disabled]+.list-group-item,
        .list-group-radio .form-check-input:disabled+.list-group-item {
            pointer-events: none;
            filter: none;
            opacity: .5;
        }

        .text-s {
            text-align: start !important;
        }
    </style>


</head>

<body>
    <?php
    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // token class file is included.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/token.class.php");

    // check session is set.
    if (isset($_SESSION['yourToken'])) {
        // yourToken is your session key.
        $rollNo = $_SESSION["yourToken"];

        // initialize the token class.
        $token = new Token($rollNo);

        // check booking day is b/w tuesday and saturday.
        if ((date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")) {
            $result = $token->isTokenBooked($rollNo);

            // result is true, when the user is booked the token, it did not allow second time to book the tokn.
            if ($result) {
                ?>
                <div class="container my-5" bis_skin_checked="1">
                    <div class="p-4 text-center bg-body-tertiary rounded-3" bis_skin_checked="1">
                    <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">

                        <h1 class="text-body-emphasis">Hey Welcome
                            <?php if (isset($_SESSION['name'])) {
                                echo $_SESSION['name'];
                            }
                            ?>
                        </h1>
                        <p class="col-lg-8 mx-auto fs-5 text-muted">
                           Your food token is already booked.
                        </p>

                        <a class="btn btn-dark rounded-1 mt-2" href="/token/check-status/">Check status</a>
                        <a class="btn btn-secondary rounded-1 mt-2" href="/">Go home</a>
                    </div>
                </div>
                <?php

            } else {
                // check all the parameters are correct, if it is, then it will allow to book the token.
                if (
                    isset($_POST["tuesdayCount"])
                    and isset($_POST["wednesdayCount"])
                    and isset($_POST["thursdayCount"])
                    and isset($_POST["sundayCount"])
                ) {
                    $result = false;
                    $tuesday = $_POST["tuesdayCount"];
                    $wednesday = $_POST["wednesdayCount"];
                    $thursday = $_POST["thursdayCount"];
                    $sunday = $_POST["sundayCount"];
                    $rollNo = $_SESSION["yourToken"];
                    $day = date("l");
                    $nextTuesday = "";
                    if ($day == "Tuesday") {
                        $date = strtotime("+7 day", strtotime(date("Y-m-d")));
                        $nextTuesday = date("Y-m-d", $date);
                    } else if ($day == "Wednesday") {
                        $date = strtotime("+6 day", strtotime(date("Y-m-d")));
                        $nextTuesday = date("Y-m-d", $date);
                    } else if ($day == "Thursday") {
                        $date = strtotime("+5 day", strtotime(date("Y-m-d")));
                        $nextTuesday = date("Y-m-d", $date);
                    } else if ($day == "Friday") {
                        $date = strtotime("+4 day", strtotime(date("Y-m-d")));
                        $nextTuesday = date("Y-m-d", $date);
                    } else if ($day == "Saturday") {
                        $date = strtotime("+3 day", strtotime(date("Y-m-d")));
                        $nextTuesday = date("Y-m-d", $date);
                    }

                    $date = strtotime("+1 day", strtotime($nextTuesday));
                    $nextWednesday = date("Y-m-d", $date);

                    $date = strtotime("+1 day", strtotime($nextWednesday));
                    $nextThursday = date("Y-m-d", $date);

                    $date = strtotime("+3 day", strtotime($nextThursday));
                    $nextSunday = date("Y-m-d", $date);

                    $array = array(
                        "rollNo" => $rollNo,
                        "tuesdayCount" => $tuesday,
                        "tuesdayDate" => $nextTuesday,
                        "wednesdayCount" => $wednesday,
                        "wednesdayDate" => $nextWednesday,
                        "thursdayCount" => $thursday,
                        "thursdayDate" => $nextThursday,
                        "sundayCount" => $sunday,
                        "sundayDate" => $nextSunday
                    );
                    $token = new Token($rollNo);
                    if ($token->isTokenIdPresent) {
                        $result = $token->updateToken($array);

                    } else {
                        $result = $token->createNewToken($array);
                    }
                    if ($result) {
                        ?>
                        <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                            <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
                            <h1 class="display-5 fw-bold text-body-emphasis">Token booked Successfully</h1>
                            <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                                <p class="lead mb-4">Enjoy your meal.</p>
                                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                                    <a href="../" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Go back <span id="count-down"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php


                    } else {
                        // this parts executes when the something wrong in the server side.
                        ?>
                        <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                            <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
                            <h1 class="display-5 fw-bold text-body-emphasis">Token booked Failed</h1>
                            <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                                <p class="lead mb-4">Something went wrong.</p>
                                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                                    <a href="../" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Go back <span id="count-down"></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                    }

                } else {
                    // show booking form when the token is not booked.
                    ?>
                    <form class="mx-200 mx-2" action="/token/book-token/" method="post">
                        <h5 class="text-center display-6 mt-4 mb-3 fw-bold">Book token for next week</h5>
                        <hr>
                        <div class="container card my-5 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
                            bis_skin_checked="1">
                            <p class="text-s">1.Tuesday omelette count</p>
                            <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
                                <input class="list-group-item-check pe-none" type="radio" name="tuesdayCount" id="1" value="1">
                                <label class="list-group-item rounded-3 py-2" for="1">
                                    1
                                </label>
                                <input class="list-group-item-check pe-none" type="radio" name="tuesdayCount" id="3" value="0">
                                <label class="list-group-item rounded-3 py-2" for="3">
                                    skip
                                </label>
                            </div>
                        </div>
                        <div class="container card  my-5 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
                            bis_skin_checked="1">
                            <p>2.Wednesday chicken count</p>
                            <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
                                <input class="list-group-item-check pe-none" type="radio" name="wednesdayCount" id="4" value="1">
                                <label class="list-group-item rounded-3 py-2" for="4">
                                    1
                                </label>
                                <input class="list-group-item-check pe-none" type="radio" name="wednesdayCount" id="5" value="2">
                                <label class="list-group-item rounded-3 py-2" for="5">
                                    2
                                </label>
                                <input class="list-group-item-check pe-none" type="radio" name="wednesdayCount" id="6" value="0">
                                <label class="list-group-item rounded-3 py-2" for="6">
                                    skip
                                </label>
                            </div>
                        </div>
                        <div class="container card  my-5 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
                            bis_skin_checked="1">
                            <p>3.Thursday egg count</p>

                            <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
                                <input class="list-group-item-check pe-none" type="radio" name="thursdayCount" id="7" value="1">
                                <label class="list-group-item rounded-3 py-2" for="7">
                                    1
                                </label>

                                <input class="list-group-item-check pe-none" type="radio" name="thursdayCount" id="8" value="2">
                                <label class="list-group-item rounded-3 py-2" for="8">
                                    2
                                </label>
                                <input class="list-group-item-check pe-none" type="radio" name="thursdayCount" id="9" value="0">
                                <label class="list-group-item rounded-3 py-2" for="9">
                                    skip
                                </label>
                            </div>
                        </div>
                        <div class=" container card  my-3 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
                            bis_skin_checked="1">
                            <p>4.Sunday chicken count</p>
                            <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
                                <input class="list-group-item-check pe-none" type="radio" name="sundayCount" id="10" value="1">
                                <label class="list-group-item rounded-3 py-2" for="10">
                                    1
                                </label>
                                <input class="list-group-item-check pe-none" type="radio" name="sundayCount" id="11" value="2">
                                <label class="list-group-item rounded-3 py-2" for="11">
                                    2
                                </label>
                                <input class="list-group-item-check pe-none" type="radio" name="sundayCount" id="12" value="0">
                                <label class="list-group-item rounded-3 py-2" for="12">
                                    skip
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-2">
                            <button class="container-md btn btn-dark btn-lg rounded-1 ">submit</button>
                        </div>
                    </form>
                    <?php
                }
            }
        } else {
            ?>
            <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
                <h1 class="display-5 fw-bold text-body-emphasis">Booking not open</h1>
                <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                    <p class="lead mb-4">Please wait sometime to book token.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                        <a href="../" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Go back
                        </a>
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
            <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
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
    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>