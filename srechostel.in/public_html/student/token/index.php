<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php"; 
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food token</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php"; 
    ?>
</head>

<body>
    <?php
    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php"; 

    // token class file is included.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/token.class.php");
    
    // initialize the token class.
    $token = new Token();

    // welcome message for the student.
    ?>
    <div class="container my-5" bis_skin_checked="1">
        <div class="p-4 text-center bg-body-tertiary rounded-3" bis_skin_checked="1">
            <svg class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <h1 class="text-body-emphasis">Hey Welcome
                <?php if (isset($_SESSION['name'])) {
                    echo $_SESSION['name'];
                } else {
                    echo "Student";
                } ?>
            </h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
                Welcome! Book your food token easily on our site and check your booking status anytime under "Token
                status."
                <br>
                Enjoy your meal!
            </p>
            <div class="gap-2 mb-5" bis_skin_checked="1">
                <?php
                // check token is already booked.
                $result = $token->isTokenBooked($_SESSION["yourToken"]);
                if (!(date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")) {
                    ?>
                    <a class="align-items-center btn btn-danger rounded-1 mt-2" href="/token/">Booking not opened</a>
                    <?php
                } else if ($result) {
                    ?>
                        <button class="align-items-center btn btn-success rounded-1 mt-2" type="button">Token
                            booked</button>
                    <?php
                } else {
                    ?>
                        <a class="align-items-center btn btn-outline-secondary rounded-1 mt-2"
                            href="/token/book-token/">Book
                            Token</a>
                    <?php
                }
                ?>
                <br>
                <?php
                // show the token status button while the day is b/w tuesday and saturday.
                if (date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday") {
                    ?>
                    <a class="align-items-center btn btn-outline-secondary rounded-1 mt-2" href="/token/token-status/">Token
                        status</a>
                    <?php

                }
                ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>