<?php
// check the current user is student.
require_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Food Token Status</title>
    <link rel="icon" type="image/x-icon" href="/images/icons/food-icon.png">
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

    if (
        isset($_SESSION['yourToken'])
    ) {
        // initialize the token class.
        $token = new Token($rollNo);

        // gather the session id of the user.
        $rollNo = $_SESSION["yourToken"];

        if ((date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")) {

            // check the token is booked by the student.
            $isTokenBooked = $token->isTokenBooked($rollNo);

            // if token is booked then, show the token status.
            if ($isTokenBooked) {
                ?>
                <div class="container-fluid" bis_skin_checked="1">
                    <div class="text-center  rounded-3" bis_skin_checked="1">
                        <h1 class="text-body-emphasis">Hey
                            <?php if (isset($_SESSION['name'])) {
                                echo $_SESSION['name'];
                            } ?>
                        </h1>
                        <p class="col-lg-8 mx-auto fs-5 text-muted">
                            Here is you food token Information
                        </p>
                        <?php
                        $row = $token->fetchMyToken($_SESSION['yourToken']);
                        ?>
                        <div class="d-flex flex-column flex-md-row  gap-4  align-items-center justify-content-center"
                            bis_skin_checked="1">
                            <div class="dropdown-menu position-static d-flex flex-column flex-lg-row align-items-stretch justify-content-start p-3 rounded-3 shadow-lg mb-3"
                                data-bs-theme="light" bis_skin_checked="1">
                                <div class="col-lg-12">
                                    <ul class="list-unstyled d-flex flex-column gap-2">
                                        <li>
                                            <a href="#" class="btn btn-hover-light rounded-2 d-flex align-items-start   text-start">
                                                <svg class="bi" width="24" height="24">
                                                    <use xlink:href="#image-fill"></use>
                                                </svg>
                                                <div bis_skin_checked="1">
                                                    <strong class="d-block">Tuesday omlettee -
                                                        <?php echo $row['tuesday_date'] ?></strong>
                                                    <small class="text-center">count :
                                                        <strong><?php echo $row['tuesday_token_count'] ?></strong></small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="container-fluid btn btn-hover-light rounded-2 d-flex align-items-start  lh-sm text-start">
                                                <svg class="bi" width="24" height="24">
                                                    <use xlink:href="#image-fill"></use>
                                                </svg>
                                                <div bis_skin_checked="1">
                                                    <strong class="d-block">Wednesday chicken -
                                                        <?php echo $row['wednesday_date'] ?></strong>
                                                    <small class="text-center">count :
                                                        <strong><?php echo $row['wednesday_token_count'] ?></strong></small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="btn btn-hover-light rounded-2 d-flex align-items-start  lh-sm text-start ">
                                                <svg class="bi" width="24" height="24">
                                                    <use xlink:href="#image-fill"></use>
                                                </svg>
                                                <div bis_skin_checked="1">
                                                    <strong class="d-block">Thursday Egg -
                                                        <?php echo $row['thursday_date'] ?></strong>
                                                    <small class="text-center">count :
                                                        <strong><?php echo $row['thursday_token_count'] ?></strong></small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="btn btn-hover-light rounded-2 d-flex align-items-start  lh-sm text-start">
                                                <svg class="bi" width="24" height="24">
                                                    <use xlink:href="#image-fill"></use>
                                                </svg>
                                                <div bis_skin_checked="1">
                                                    <strong class="d-block">Sunday Chicken -
                                                        <?php echo $row['sunday_date'] ?></strong>
                                                    <small class="text-center">count :
                                                        <strong><?php echo $row['sunday_token_count'] ?></strong></small>

                                                </div>
                                            </a>
                                        </li>
                                        <div>
                                            <a href="../" class="container-fluid btn btn-dark ">Go back</a>
                                            <a href="/stud-panel/token/edit-token/"
                                                class="container-fluid btn btn-outline-dark mt-2">Edit token</a>
                                        </div>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php

            } else {
                // this part executes when the token is not booked yet.
                ?>
                <div class="container my-5" bis_skin_checked="1">
                    <div class="p-4 text-center bg-body-tertiary rounded-3" bis_skin_checked="1">
                        <img src="/images/icons/token.png" class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100"
                            height="100">
                        </img>
                        <h1 class="text-body-emphasis">Token yet not booked</h1>
                        <button class="btn btn-danger rounded-1 mt-1">
                            Please book the food token.
                        </button>
                        <br>
                        <a href="../" class="btn btn-secondary rounded-1 mt-2">Go back</span></a>

                    </div>
                </div>

                <?php
            }
        } else {
            // this parts executes when the booking is not opened.
            ?>
            <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
                <h1 class="display-5 fw-bold text-body-emphasis">Booking not open</h1>
                <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                    <p class="lead mb-4">Please wait sometime to book token.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                        <a href="../" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Go back</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        // comes when the session is not set
        $domain = "https://srechostel.in/api/auth/logout/";
        ?>
        <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
            <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
            <h1 class="display-5 fw-bold text-body-emphasis">Something went wrong</h1>
            <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                <p class="lead mb-4">Please logout and login again.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                    <a href="<?php echo $domain ?>" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Logout</span>
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