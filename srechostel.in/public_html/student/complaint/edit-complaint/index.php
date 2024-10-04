<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/examples/dropdowns/dropdowns.css">
    <link rel="icon" type="image/x-icon" href="/images/icons/complaint-icon.png">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <?php
    // included the poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>

</head>

<body>
    <?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // import the complaint class.
    include_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php");
    $complaint = new commonClass();

    // check which complaint is booked.
    $which_is_booked = $complaint->alreadyBooked($_SESSION['yourToken']);
    if ($which_is_booked) {
        if ($which_is_booked == 1) {
            if (
                isset($_POST["department"]) and
                isset($_POST["complaint_summary"])
            ) {
                //common complaint
                $array = array (
                    "dept" => $_POST['department'],
                    "text" => $_POST['complaint_summary'],
                    "rollNo" => $_SESSION['yourToken']
                );
                $edit = '';
                if (isset($_FILES['evidence'])) {
                    $file = $_FILES['evidence'];
                    $edit = $complaint->putCommonComplaint($array, $file);
                } else {
                    $edit = $complaint->putCommonComplaint($array, $file);
                }
                if ($edit) {
                    //success when common complaint booked
                    ?>
                    <main>
                        <div class="container-fluid" bis_skin_checked="1">
                            <div class="border-bottom"></div>
                            <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                                <div class="container-fluid py-5" bis_skin_checked="1">
                                    <h1 class="display-5 fw-bold">Complaint Booked successfully</h1>
                                    <p class="col-md-8 fs-4">Admin will contact you soon.</p>
                                    <a href="/" class="btn btn-dark btn-lg rounded-1">Home
                                    </a>
                                </div>
                            </div>
                    </main>
                    <?php
                } else {
                    ?>

                    <main>
                        <div class="container-fluid" bis_skin_checked="1">
                            <div class="border-bottom"></div>
                            <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                                <div class="container-fluid py-5" bis_skin_checked="1">
                                    <h1 class="display-5 fw-bold">Complaint Booked Failed</h1>
                                    <p class="col-md-8 fs-4">Contact admin.</p>
                                    <a href="/" class="btn btn-dark btn-lg rounded-1">Home
                                    </a>
                                </div>
                            </div>
                    </main>

                    <?php
                }

            }
        } else if ($which_is_booked == 2) {


            if (
                isset($_POST["complaint_details"])
            ) {

                //individual complaint
                $details = $complaint->getFullStudDetails($_SESSION['yourToken']);
                $name = $details[0]["name"];
                $roomNo = $details[1]["room_no"];
                $rollNo = $details[0]["roll_no"];
                $dept = $details[0]["department"];
                $array = array(
                    "name" => $name,
                    "roomNo" => $roomNo,
                    "rollNo" => $_SESSION['yourToken'],
                    "dept" => $dept,
                    "text" => $_POST['complaint_details']
                );
                $edit = '';
                $file = '';
                if (isset($_FILES['evidence'])) {

                    $file = $_FILES['evidence'];
                    $edit = $complaint->putIndividualComplaint($array, $file);
                } else {
                    $edit = $complaint->putIndividualComplaint($array, $file);
                }
                if ($edit) {
                    //success when individual complaint booked
                    ?>
                        <main>
                            <div class="container-fluid" bis_skin_checked="1">
                                <div class="border-bottom"></div>
                                <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                                    <div class="container-fluid py-5" bis_skin_checked="1">
                                        <h1 class="display-5 fw-bold">Complaint Booked successfully</h1>
                                        <p class="col-md-8 fs-4">Admin will contact you soon.</p>
                                        <a href="/" class="btn btn-dark btn-lg rounded-1">Home
                                        </a>
                                    </div>
                                </div>
                        </main>
                    <?php
                    exit;

                } else {
                    ?>
                        <main>
                            <div class="container-fluid" bis_skin_checked="1">
                                <div class="border-bottom"></div>
                                <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                                    <div class="container-fluid py-5" bis_skin_checked="1">
                                        <h1 class="display-5 fw-bold">Complaint Booked Failed</h1>
                                        <p class="col-md-8 fs-4">Contact admin.</p>
                                        <a href="/" class="btn btn-dark btn-lg rounded-1">Home
                                        </a>
                                    </div>
                                </div>
                        </main>
                    <?php
                    exit;
                }
            }
        }

        if ($which_is_booked == 1) {
            $row = $complaint->retriveMyComplaint("common_complaint");

            ?>
            <div class="m-3 d-flex justify-content-center">
                <div class="cont card px-4 py-4">

                    <h2 class="text-center">Common Complaint</h2>
                    <hr>
                    <form class="needs-validation" action="/complaint/edit-complaint/" method="post"
                        enctype="multipart/form-data">
                        <label class='form-label' class="form-label" for="dept">Your department</label>
                        <select class="form-select rounded-1 mb-2" id="dept" name="department"
                            aria-label="Default select example">
                            <option>Select your department</option>
                            <option value="AI&DS" <?php
                            if ($row['department'] == 'AI&DS') {
                                echo "selected";
                            }
                            ?>>AI&DS</option>
                            <option value="IT" <?php
                            if ($row['department'] == 'IT') {
                                echo "selected";
                            }
                            ?>>IT</option>
                            <option value="ECE" <?php
                            if ($row['department'] == 'ECE') {
                                echo "selected";
                            }
                            ?>>ECE</option>
                            <option value="EEE" <?php
                            if ($row['department'] == 'EEE') {
                                echo "selected";
                            }
                            ?>>EEE</option>
                            <option value="EIE" <?php
                            if ($row['department'] == 'EIE') {
                                echo "selected";
                            }
                            ?>>EIE</option>
                            <option value="CSC" <?php
                            if ($row['department'] == 'CSC') {
                                echo "selected";
                            }
                            ?>>CSC</option>
                        </select>

                        <label class='form-label' class="form-label" for="complaint_details">Breif details about your
                            complaint</label>
                        <textarea class='form-control mb-2' id="complaint_details" name="complaint_summary" rows="4" cols="50"
                            required><?php echo $row['complaint_summary']; ?></textarea>

                        <label class='form-label' class="form-label" for="evidence">Attach File</label>
                        <input class='form-control mb-2' class="form-control" type="file" accept=".jpg,.png,.jpeg,.heic"
                            id="evidence" name="evidence">
                        <small>(upload file only if changes needed)</small>

                        <button class="btn btn-dark container-fluid mt-3" class="form-control" type="submit">Submit</button>
                    </form>
                </div>

            </div>
            <?php
        } else if ($which_is_booked == 2) {
            //individual complaint edit form
            $row = $complaint->retriveMyComplaint("individual_complaint");
            ?>
                <div class="m-3 d-flex justify-content-center">
                    <div class="cont">

                        <h2 class="text-center">Individual Complaint</h2>
                        <hr>
                        <form class="needs-validation" action="/complaint/edit-complaint/" method="post"
                            enctype="multipart/form-data">

                            <!-- 
                    <input class='form-control mb-2' id="dept" name="dept" type="text" required /> -->


                            <label class='form-label' class="form-label" for="complaint_details">Breif details about your
                                complaint</label>
                            <textarea class='form-control mb-2' id="complaint_details" name="complaint_details" rows="4" cols="50"
                                required><?php echo $row['complaint_summary'] ?></textarea>

                            <label class='form-label' class="form-label" for="evidence">Attach File</label>
                            <input class='form-control mb-2' class="form-control" type="file" accept=".jpg,.png,.jpeg,.heic"
                                id="evidence" name="evidence">
                            <small>(upload file only if changes needed)</small>
                            <button class="btn btn-dark container-fluid mt-3" class="form-control" type="submit">Submit</button>
                        </form>
                    </div>

                </div>
            <?php

        }
        ?>

        <?php
    } else {
        //when which_is_booked==0
        ?>
        <main>
            <div class="container-fluid" bis_skin_checked="1">
                <div class="border-bottom"></div>
                <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                    <div class="container-fluid py-5" bis_skin_checked="1">
                        <h1 class="display-5 fw-bold">Complaint not booked</h1>
                        <p class="col-md-8 fs-4">Please book the Complaint to check the status of the comaplint.</p>
                        <a href="/complaint" class="btn btn-dark btn-lg rounded-1">book complaint <span id="count-down">
                            </span></a>
                    </div>
                </div>
        </main>

        <?php
    }

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</html>