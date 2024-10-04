<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>book individual complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
    <style>


        .cont {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        textarea {
            resize: none;
        }
    </style>

</head>

<body>

    <?php

    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // common class is included.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php");
    
    // common class is initialized.
    $complaint = new commonClass();

    // to find which compalint is booked.
    $which_is_booked = $complaint->alreadyBooked($_SESSION['yourToken']);
    if ($which_is_booked) {
        ?>
        <div class="container my-5" bis_skin_checked="1">
            <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                bis_skin_checked="1">

                <svg class="bi mt-5 mb-3" width="48" height="48">
                    <use xlink:href="#check2-circle"></use>
                </svg>
                <h1 class="text-body-emphasis">
                    <?php if ($which_is_booked == 1) {
                        echo "Common complaint already booked";
                    } else {
                        echo "Individual complaint already booked";
                    } ?>
                </h1>
                <p class="col-lg-6 mx-auto mb-4">
                    Hostel admin will contact you soon
                </p>
                <a href="/complaint/complaint-status/" class=" btn btn-dark mb-5 rounded-1">
                    Check complaint status
                </a>
            </div>
        </div>
        <?php

    } else if (
        isset($_POST["complaint_details"])

    ) {
        $complaint = new commonClass();
        $details = $complaint->getFullStudDetails($_SESSION['yourToken']);
        $name = $details[0]["name"];
        $roomNo = $details[1]["room_no"];
        $rollNo = $details[0]["roll_no"];
        $dept = $details[0]["department"];
        $text = $_POST["complaint_details"];
        $file = $_FILES["evidence"];
        $data = array(
            "name" => $name,
            "roomNo" => $roomNo,
            "rollNo" => $rollNo,
            "dept" => $dept,
            "text" => $text
        );
        $result1 = $complaint->putindividualComplaint($data, $file);
        if ($result1) {
            ?>
                <div class="container my-5" bis_skin_checked="1">
                    <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                        bis_skin_checked="1">
                        <svg class="bi mt-5 mb-3" width="48" height="48">
                            <use xlink:href="#check2-circle"></use>
                        </svg>
                        <h1 class="text-body-emphasis">Individual complaint<strong> Booked Successfully</strong></h1>
                        <p class="col-lg-6 mx-auto mb-4">
                            Your complaint will received , admin will contact you soon
                        </p>
                        <a href="/complaint/complaint-status/" class=" btn btn-dark mb-5 rounded-1">
                            check complaint status
                        </a>
                    </div>
                </div>
            <?php
        }
    } else {

        ?>
            <div class="m-3 d-flex justify-content-center">
                <div class="cont">

                    <h2 class="text-center">Individual Complaint</h2>
                    <hr>
                    <form class="needs-validation" action="/complaint/book-individual-complaint/" method="post"
                        enctype="multipart/form-data">
                        <label class='form-label' class="form-label" for="complaint_details">Breif details about your
                            complaint</label>
                        <textarea class='form-control mb-2' id="complaint_details" name="complaint_details" rows="4" cols="50"
                            required></textarea>

                        <label class='form-label' class="form-label" for="evidence">Attach File</label>
                        <input class='form-control mb-2' class="form-control" type="file" accept=".jpg,.png,.jpeg,.heic"
                            id="evidence" name="evidence" required>
                        <button class="btn btn-dark container-fluid mt-3" class="form-control" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        <?php
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>