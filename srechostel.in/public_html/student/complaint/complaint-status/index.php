<?php // check the login user is student 
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php" ; 
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Check pass status</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="/images/icons/complaint-icon.png">

        <?php
        // poppins font css included.
        require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
        ?>

        <style>
            .key-value-container {
                max-width: 800px;
                max-height: 500px;
                margin: 50px auto;
                padding: 20px;
                border-radius: 10px;
                background-color: #f8f9fa;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .key-value-row {
                border-bottom: 1px solid #dee2e6;
                padding: 10px 0;
            }

            .key-value-row:last-child {
                border-bottom: none;
            }

            .key {
                font-weight: 500;
                color: #495057;
            }

            .value {
                font-weight: 400;
                color: #6c757d;
            }
        </style>
    </head>

    <body>
        <?php
        // navbar html code is included.
        require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

        // complaint status template.
        require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/modules/show_complaint_status.php";

        // common class is included.
        require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php");

        // common class is initialized.
        $complaint = new commonClass();

        // to find which compalint is booked.
        $which_is_booked = $complaint->alreadyBooked($_SESSION['yourToken']);

        if ($which_is_booked) {
            $row = [];
            if ($which_is_booked == 1) {
                $row = $complaint->retriveMyComplaint("common_complaint");
            } else {
                $row = $complaint->retriveMyComplaint("individual_complaint");
            }
            ?>
            <div class="container mt-2" bis_skin_checked="1">
                <div class="position-relative  text-muted bg-body  mx-2" bis_skin_checked="1">
                    <h1 class="text-body-emphasis text-center">Complaint Information</h1>
                    <h2 class="text-body-emphasis text-center">
                        <?php if ($which_is_booked == 1) {
                            echo "Common complaint";
                        } else {
                            echo "Individual complaint";
                        } ?>
                    </h2>
                        <hr>
                    <?php
                    if ($which_is_booked == 1) {
                        $newDate = date("d-m-Y", strtotime($row['date_of_complaint']));
                        $row['date_of_comaplint'] = $newDate;
                        show_common_complaint($row);
                    } else {
                        $newDate = date("d-m-Y", strtotime($row['date_of_complaint']));
                        $row['date_of_comaplint'] = $newDate;
                        show_individual_complaint($row);
                    }
                    ?>
                </div>
            </div>
            <?php

        } else {
            ?>
            <main>
                <div class="container-fluid" bis_skin_checked="1">
                    <div class="border-bottom"></div>
                    <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                        <div class="container-fluid py-5" bis_skin_checked="1">
                            <h1 class="display-5 fw-bold">Complaint not booked</h1>
                            <p class="col-md-8 fs-4">Please book the Complaint after check the status of the complaint.</p>
                            <a href="/complaint" class="btn btn-dark btn-lg rounded-1">book complaint <span
                                    id="count-down"> </span></a>
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