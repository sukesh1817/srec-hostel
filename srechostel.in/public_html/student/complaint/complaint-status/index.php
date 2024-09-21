<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check pass status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/images/icons/complaint-icon.png">


    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>

<style>
    .key-value-container {
      max-width: 800px;
      max-height: 500px;
      margin: 50px auto;
      padding: 20px;
      border-radius: 10px;
      background-color: #f8f9fa;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
    ?>
    <?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
    $complaint = new commonClass();
    $which_is_booked = $complaint->alreadyBooked($_SESSION['yourToken']);

    if ($which_is_booked) {

        $row = [];
        if ($which_is_booked == 1) {
            $row = $complaint->retriveMyComplaint("common_complaint");
        } else {
            $row = $complaint->retriveMyComplaint("individual_complaint");

        }

        ?>
        <div class="container mt-5" bis_skin_checked="1">
            <div class="position-relative  text-center text-muted bg-body border border-dashed rounded-1 mx-2"
                bis_skin_checked="1">

                <svg class="bi mb-3" width="48" height="48">
                    <use xlink:href="#check2-circle"></use>
                </svg>
                <h1 class="text-body-emphasis">Complaint Information</h1>
                <h2 class="text-body-emphasis">
                    <?php if ($which_is_booked == 1) {
                        echo "Common complaint";
                    } else {
                        echo "Individual complaint";
                    } ?></h2>
                <hr>
                <div class="col-lg-6 mx-auto mb-4 container">

                    <?php
                    if ($which_is_booked == 1) {
                        echo "<p>Department : <strong>" . $row['department'] . '</strong></p>';
                        echo "<p>Date of complaint: <strong> " . $row['date_of_complaint'] . '</strong></p>';
                        echo "<p>complaint summary : <strong> " . $row['complaint_summary'] . '</strong></p>';

                    } else {
                        echo "<p>Name : <strong>" . $row['stud_name'] . '</strong></p>';
                        echo "<p>Roll no : <strong>" . $row['roll_no'] . '</strong></p>';
                        echo "<p>Room no : <strong>" . $row['room_no'] . '</strong></p>';
                        echo "<p>Department : <strong>" . $row['department'] . '</strong>';
                        echo "<p>Date of complaint: <strong> " . $row['date_of_complaint'] . '</strong></p>';
                        echo "<p>complaint summary : <strong> " . $row['complaint_summary'] . '</strong></p>';
                    }


                    ?>
                </div>

                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Key-Value Pair Display</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
                        rel="stylesheet">
                    <style>
                        .key-value-container {
                            max-width: 600px;
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

                    <div class="container">
                        <div class="key-value-container">
                            <div class="row key-value-row">
                                <div class="col-6 key">Name:</div>
                                <div class="col-6 value">John Doe</div>
                            </div>
                            <div class="row key-value-row">
                                <div class="col-6 key">Email:</div>
                                <div class="col-6 value">johndoe@example.com</div>
                            </div>
                            <div class="row key-value-row">
                                <div class="col-6 key">Phone:</div>
                                <div class="col-6 value">+1 234 567 890</div>
                            </div>
                            <div class="row key-value-row">
                                <div class="col-6 key">Location:</div>
                                <div class="col-6 value">New York, USA</div>
                            </div>
                        </div>
                    </div>

                    <script
                        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                </body>

                </html>

                <a href="/stud-panel/complaint/edit-complaint/" class="btn btn-dark px-5 mb-5 rounded-1" type="button">
                    Change something
                </a>
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
                        <a href="/stud-panel/complaint" class="btn btn-dark btn-lg rounded-1">book complaint <span
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