<?php
// check the login user is women admin or not.
require_once $_SERVER['DOCUMENT_ROOT'] . '/is-women-admin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <?php
    // included the poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>

    <style>
        .btn-outline-light:hover {
            color: black;
        }

        .navbar-brand.ms-3.d-lg-none.dg-xl-none {
            display: none;
        }

        /* Display the element when the screen is large (e.g., 992px and up) */
        @media (min-width: 992px) {
            .navbar-brand.ms-3.d-lg-none.dg-xl-none {
                display: block;
            }
        }
    </style>
</head>

<body>

    <?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
    ?>

    <div class="bg-light-subtle">
        <main class="bg-img">
            <div class="container-fluid py-4">

                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Student Details</h1>
                        <p class="col-md-8 fs-4">Here You Can See About The Student Details By Clicking
                            The Below Button.</p>
                        <a href="/admin-panel/stud-details" class="btn btn-dark rounded-1 btn-lg">See Details</a>
                    </div>
                </div>

                <div class="row align-items-md-stretch">
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-dark rounded-3">
                            <h2 style="color:#fff">Token Records</h2>
                            <p style="color:#fff">Here You Can See About The Token Records By Click The
                                Below
                                Button.</p>
                            <a href="/admin-panel/token-records" class="btn btn-outline-light rounded-1 btn-lg"
                                type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                            <h2>Accommodation</h2>
                            <p>Here You Can See About Latest Accommodation By Click The Below Button.</p>
                            <a href="/admin-panel/accommodation" class="btn btn-outline-dark rounded-1 btn-lg"
                                type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row align-items-md-stretch">


                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                            <h2>Complaint</h2>
                            <p>Here You Can See About Latest complaints By students.</p>
                            <a href="/admin-panel/complaint/" class="btn btn-dark rounded-1 btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-dark rounded-3">
                            <h2 style="color:#fff">Gate Pass</h2>
                            <p style="color:#fff">Here You Can See About The Gatepass from the student.</p>
                            <a href="/admin-panel/gate-pass/" class="btn btn-light rounded-1 text-dark btn-lg"
                                type="button">
                                See Details
                            </a>
                        </div>
                    </div>


                </div>

                <div class="row align-items-md-stretch">


                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5  bg-dark border rounded-3">
                            <h2 class="text-light">Committee</h2>
                            <p class="text-light">Here You Can See About The Committee from the student.</p>
                            <a href="/admin-panel/committee/" class="btn btn-outline-light rounded-1 btn-lg"
                                type="button">
                                See Details
                            </a>
                        </div>
                    </div>


                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5  bg-body-tertiary border rounded-3">
                            <h2 class="text-dark">Food Order</h2>
                            <p class="text-dark">Here You Can See About Food Orders from the staff.</p>
                            <a href="/admin-panel/food-orders/" class="btn btn-outline-dark rounded-1 btn-lg"
                                type="button">
                                See Details
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row align-items-md-stretch">
                    <div class="col-md-6 col-lg-12 mb-4">
                        <div class="h-100 p-5  bg-dark border rounded-3">
                            <h2 class="text-light">Add Data</h2>
                            <p class="text-light">Add the student data using this form.</p>
                            <a href="/admin-panel/add-student-records/" class="btn btn-light rounded-1 btn-lg">
                                See Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>