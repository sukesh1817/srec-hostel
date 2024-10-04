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


    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
    <style>
        strong {
            font-weight: 600;
        }

        .notification {
            width: 360px;
            padding: 15px;
            background-color: #ececec;
            border-radius: 16px;
            position: fixed;
            bottom: 15px;
            left: 15px;
            transform: translateY(200%);
            animation: noti 2s forwards alternate ease-in;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .notification.hidden {
            opacity: 0;
            transform: translateY(200%);
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .notification-title {
            font-size: 16px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .notification-close {
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F0F2F5;
            font-size: 14px;
        }

        .notification-container {
            display: flex;
            align-items: flex-start;
        }

        .notification-media {
            position: relative;
        }

        .notification-user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 60px;
            object-fit: cover;
        }

        .notification-reaction {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 30px;
            color: white;
            background-image: linear-gradient(45deg, #0070E1, #14ABFE);
            font-size: 14px;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .notification-content {
            width: calc(100% - 60px);
            padding-left: 20px;
            line-height: 1.2;
        }

        .notification-text {
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 50px;
        }

        .notification-timer {
            color: #1876F2;
            font-weight: 600;
            font-size: 14px;
        }

        .notification-status {
            position: absolute;
            right: 15px;
            top: 50%;
            width: 15px;
            height: 15px;
            background-color: #1876F2;
            border-radius: 50%;
        }

        @keyframes noti {
            50% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php"; ?>
<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
$complaint = new commonClass();
$which_is_booked = $complaint->alreadyBooked($_SESSION['yourToken']);
if ($which_is_booked) {


    if ($which_is_booked == 1) {
        if (
            isset($_POST["department"]) and
            isset($_POST["complaint_summary"])
        ) {
            //common complaint
            $array = array(
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


                <div class="notification rounded-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="notification-header">
                        <h3 class="notification-title">Notification</h3>
                        <i type="button" class="btn-close-1" data-bs-dismiss="notification" aria-label="Close"><svg
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x"
                                viewBox="0 0 16 16">
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg></i>
                    </div>
                    <div class="notification-container">
                        <div class="notification-media">
                            <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg" alt=""
                                class="notification-user-avatar">
                            <i class="fa fa-thumbs-up notification-reaction"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">
                                <strong>Your complaint edited successfully</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        const closeButton = document.querySelector('.btn-close-1');
                        const notification = document.querySelector('.notification');

                        closeButton.addEventListener('click', () => {
                            notification.classList.add('hidden');
                        });
                    });
                </script>
                <?php
            } else {
                ?>
                <div class="notification rounded-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="notification-header">
                        <h3 class="notification-title">Notification</h3>
                        <i type="button" class="btn-close-1" data-bs-dismiss="notification" aria-label="Close"><svg
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x"
                                viewBox="0 0 16 16">
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg></i>
                    </div>
                    <div class="notification-container">
                        <div class="notification-media">
                            <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg" alt=""
                                class="notification-user-avatar">
                            <i class="fa fa-thumbs-up notification-reaction"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">
                                <strong>Your complaint edited failed</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        const closeButton = document.querySelector('.btn-close-1');
                        const notification = document.querySelector('.notification');

                        closeButton.addEventListener('click', () => {
                            notification.classList.add('hidden');
                        });
                    });
                </script>
                <?php
            }

        }
    } else if ($which_is_booked == 2) {


        if (
            isset($_POST["complaint_details"])
        ) {

            //individual complaint
            $complaint = new commonClass();
            $details = $complaint->getFullStudDetails($_SESSION['yourToken']);
            $name = $details[0]["name"];
            $roomNo = $details[1]["room_no"];
            $rollNo = $details[0]["roll_no"];
            $array = array(
                "name" => $name,
                "roomNo" => $roomNo,
                "rollNo" => $_SESSION['yourToken'],
                "dept" => $_POST['department'],
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

                    <div class="notification rounded-1" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="notification-header">
                            <h3 class="notification-title">Notification</h3>
                            <i type="button" class="btn-close-1" data-bs-dismiss="notification" aria-label="Close"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg></i>
                        </div>
                        <div class="notification-container">
                            <div class="notification-media">
                                <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg" alt=""
                                    class="notification-user-avatar">
                                <i class="fa fa-thumbs-up notification-reaction"></i>
                            </div>
                            <div class="notification-content">
                                <p class="notification-text">
                                    <strong>Your complaint edited successfully</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            const closeButton = document.querySelector('.btn-close-1');
                            const notification = document.querySelector('.notification');

                            closeButton.addEventListener('click', () => {
                                notification.classList.add('hidden');
                            });
                        });
                    </script>

                <?php
            } else {
                ?>
                    <div class="notification rounded-1" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="notification-header">
                            <h3 class="notification-title">Notification</h3>
                            <i type="button" class="btn-close-1" data-bs-dismiss="notification" aria-label="Close"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg></i>
                        </div>
                        <div class="notification-container">
                            <div class="notification-media">
                                <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg" alt=""
                                    class="notification-user-avatar">
                                <i class="fa fa-thumbs-up notification-reaction"></i>
                            </div>
                            <div class="notification-content">
                                <p class="notification-text">
                                    <strong>Your complaint edited failed</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            const closeButton = document.querySelector('.btn-close-1');
                            const notification = document.querySelector('.notification');

                            closeButton.addEventListener('click', () => {
                                notification.classList.add('hidden');
                            });
                        });
                    </script>
                <?php
            }
        }
    }

    if ($which_is_booked == 1) {
        $row = $complaint->retriveMyComplaint("common_complaint");
        // print_r($row);
        //common complaint edit form
        ?>
        <div class="m-3 d-flex justify-content-center">
            <div class="cont card px-4 py-4">

                <h2 class="text-center">Common Complaint</h2>
                <hr>
                <form class="needs-validation" action="/complaint/edit-complaint/" method="post"
                    enctype="multipart/form-data">
                    <label class='form-label' class="form-label" for="dept">Your department</label>
                    <select class="form-select rounded-1 mb-2" id="dept" name="department" aria-label="Default select example">
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
                    <a href="/complaint" class="btn btn-dark btn-lg rounded-1">book complaint <span
                            id="count-down"> </span></a>
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