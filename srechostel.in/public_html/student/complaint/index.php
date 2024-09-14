<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
    // included the poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>

</head>

<body>
<?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
    ?>
    <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <img src="/images/layout-image/bad-review.png" alt="" width="50" height="50">
            <h1 class="text-body-emphasis">Register your complaint</h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
                Here you can register throught the register form and also you can see the status of your registration
            </p>
            <div class="d-inline-flex gap-2 mb-5">
                <a href="/stud-panel/complaint/book-common-complaint/" class=" btn btn-dark  rounded-1">
                    common
                </a>
                <a href="/stud-panel/complaint/book-individual-complaint/" class="btn btn-outline-dark  rounded-1">
                    Individual
                </a>
            </div>
        </div>
    </div>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">See your status</h1>
                <p class="lead text-body-secondary">Here you can see your staus of your complaint and also you can able
                    to edit
                    if you are booked your comaplint.</p>
                <p>
                    <a href="/complaint/complaint-status" class="btn btn-secondary my-2 rounded-1">status of
                        complaint</a>
                    <a href="/complaint/edit-complaint" class="btn btn-dark my-2 rounded-1">edit the
                        complaint</a>
                </p>
            </div>
        </div>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>