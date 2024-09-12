<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate pass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
</head>


<body>
    <?php
    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
    ?>

    <div class="col-lg-8 mx-auto p-2 py-md-5" bis_skin_checked="1">
        <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
            <a href="#" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                <img src="/images/layout-image/press-pass.png" width="40" height="40">
                <span class="fs-4">Gate pass</span>
            </a>
        </header>
        <main>
            <div class="container ms-1">
                <h1 class="text-body-emphasis">Book the gate pass to enjoy the journey</h1>
                <p class="fs-5 col-md-8">Quickly Book the gate pass to enjoy the journey and return back to hostel in
                    happy way.
                </p>
                <div class="mb-5" bis_skin_checked="1">
                    <a href="/gate-pass/book-gate-pass/" class="btn btn-dark btn-lg px-4 rounded-1">Book gate pass</a>
                </div>
            </div>
            <hr class="col-12 mb-5">
            <div class="bg-dark text-secondary px-4 py-5 text-center rounded-1" bis_skin_checked="1">
                <div class="py-5" bis_skin_checked="1">
                    <h1 class="display-5 fw-bold text-white">Check Your Pass</h1>
                    <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                        <p class="fs-5 mb-4">Here you can check about your gate pass information and also you have the
                            ability to
                            download the gate pass.</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                            <a href="/gate-pass/check-pass-status/"
                                class="btn btn-light btn-md px-4 me-sm-3 fw-bold rounded-1">Pass Information</a>
                            <a href="/gate-pass/download-gate-pass/"
                                class="btn btn-outline-light btn-md px-4 rounded-1">Download
                                pass</a>
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