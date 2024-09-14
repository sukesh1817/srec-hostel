<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php"; ?>
<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
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
                <form class="needs-validation" action="/stud-panel/complaint/edit-complaint/" method="post"
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
                    <form class="needs-validation" action="/stud-panel/complaint/edit-complaint/" method="post"
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
                    <a href="/stud-panel/complaint" class="btn btn-dark btn-lg rounded-1">book complaint <span
                            id="count-down"> </span></a>
                </div>
            </div>
    </main>
    <script>
        var elem = document.getElementById('count-down');
        var timer = 5;
        setInterval(function () {
            if (timer == 0) {

                window.location.href = "/stud-panel/complaint/";
            }
            elem.innerHTML = timer;
            timer--;

        }, 1000);
    </script>
    <?php
}
// include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";

?>