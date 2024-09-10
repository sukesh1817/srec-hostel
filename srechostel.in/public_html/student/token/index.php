<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food token</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
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
                Enjoy your meal!
            </p>
            <div class="gap-2 mb-5" bis_skin_checked="1">
                <a class="align-items-center btn <?php
                include_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/token.class.php");
                $token = new Token();
                $result = $token->isTokenBooked($_SESSION["yourToken"]);
                if (!(date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")) {
                    echo "btn-warning";
                } else if ($result) {
                    echo "btn-success";
                } else {
                    echo "btn-dark";
                }
                ?> rounded-1 mt-2" href="<?php
                 if (date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday") {
                     include_once($_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/token.class.php");
                     $token = new Token();
                     $result = $token->isTokenBooked($_SESSION["yourToken"]);
                     if ($result) {
                         echo "/stud-panel/token/";
                     } else {
                         echo "/stud-panel/token/book-token";

                     }
                 } else {
                     echo "/stud-panel/token/";
                 }
                 ?>" type="button">
                    <?php
                    if (date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday") {
                        include_once($_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/token.class.php");
                        $token = new Token();
                        $result = $token->isTokenBooked($_SESSION["yourToken"]);
                        if ($result) {
                            echo "Token booked";
                        } else {
                            echo "Book token";

                        }
                    } else {
                        echo "Booking not opened";
                    }

                    ?>

                </a>
                <br>
                <a class="align-items-center btn btn-outline-secondary rounded-1 mt-2" href="<?php
                if (date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday") {
                    echo "/stud-panel/token/token-status";
                } else {
                    echo "/stud-panel/token/";
                }
                ?>" type="button">
                    Token status
                </a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>