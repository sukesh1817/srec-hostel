<body style="background-color: #f8f9fa;">
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";

    ?>

    <?php
    if (isset($_SESSION['yourToken'])) {
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/accommodation.class.php");
        $accom = new accommodation();
        $alreadyBooked = $accom->checkAccomStatus($_SESSION["yourToken"]);
        if ($alreadyBooked != "none") {
            ?>

            <div class="container my-5" bis_skin_checked="1">
                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                    bis_skin_checked="1">

                    <svg class="bi mt-5 mb-3" width="48" height="48">
                        <use xlink:href="#check2-circle"></use>
                    </svg>
                    <h1 class="text-body-emphasis">Accomodation <strong>Already booked</strong></h1>
                    <p class="col-lg-6 mx-auto mb-4">
                        Your accommodation is already booked please check it
                    </p>
                    <a href="/staff-panel/accommodation/accommodation-status/" class=" btn btn-dark mb-5 rounded-1">
                        Check accommodation status
                    </a>
                </div>
            </div>
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
                            <strong>Your accomodation was already booked</strong>
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

        } else if (
            isset($_POST["check-in-date"]) &&
            isset($_POST["check-out-date"]) &&
            isset($_POST["head-count-male-staff"]) &&
            isset($_POST["head-count-female-staff"]) &&
            isset($_POST["head-count-male-student"]) &&
            isset($_POST["head-count-female-student"]) &&
            isset($_FILES["auth-file"])
        ) {
                    include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/accommodation.class.php");
            $data = $accom->getStaffDetails($_SESSION['yourToken']);
            $staffId = $_SESSION["yourToken"];
            $name = $data["name"];
            $check_in_date = $_POST["check-in-date"];
            $check_out_date = $_POST["check-out-date"];
            $maleStaff = $_POST["head-count-male-staff"];
            $femaleStaff = $_POST["head-count-female-staff"];
            $maleStudent = $_POST["head-count-male-student"];
            $femaleStudent = $_POST["head-count-female-student"];

            $femaleStaffRoom = ceil($femaleStaff / 2);
            $maleStaffRoom = ceil($maleStaff / 2);
            $maleStudentRoom = ceil($maleStudent / 3);
            $femaleStudentRoom = ceil($femaleStudent / 3);

            $file = $_FILES["auth-file"];
            $result = $accom->createAccom(
                array(
                    "staffId" => $staffId,
                    "name" => $name,
                    "checkInDate" => $check_in_date,
                    "checkOutDate" => $check_out_date,
                    "maleStaffCount" => $maleStaff,
                    "femaleStaffCount" => $femaleStaff,
                    "maleStudentCount" => $maleStudent,
                    "femaleStudentCount" => $femaleStudent,
                    "maleStaffRoom" => $maleStaffRoom,
                    "femaleStaffRoom" => $femaleStaffRoom,
                    "maleStudentRoom" => $maleStudentRoom,
                    "femaleStudentRoom" => $femaleStudentRoom,
                ),
                $file
            );

            if ($result) {
                //prints success when all ok
                ?>

                    <div class="container my-5" bis_skin_checked="1">
                        <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                            bis_skin_checked="1">

                            <svg class="bi mt-5 mb-3" width="48" height="48">
                                <use xlink:href="#check2-circle"></use>
                            </svg>
                            <h1 class="text-body-emphasis">Your Accommodation <strong>Booked Successfully</strong></h1>
                            <p class="col-lg-6 mx-auto mb-4">
                                Accommodation is booked successfully , to check it click the below button
                            </p>
                            <a href="/staff-panel/accommodation/accommodation-status/" class=" btn btn-dark mb-5 rounded-1">
                                check accommodation status
                            </a>
                        </div>
                    </div>
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
                                    <strong>Your accomodation booked successfully</strong>
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
                    <div class="container my-5" bis_skin_checked="1">
                        <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                            bis_skin_checked="1">

                            <svg class="bi mt-5 mb-3" width="48" height="48">
                                <use xlink:href="#check2-circle"></use>
                            </svg>
                            <h1 class="text-body-emphasis">Accommodation <strong>Booked Failed</strong></h1>
                            <p class="col-lg-6 mx-auto mb-4">
                                Something went wrong
                            </p>
                            <a href="/stud-panel/gate-pass/" class=" btn btn-dark mb-5 rounded-1">
                                Go back
                            </a>
                        </div>
                    </div>
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
                                    <strong>Your accomodation is not booked something went wrong</strong>
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
        } else {
            ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Accomodation Form</title>

                    <style>
                        input::-webkit-outer-spin-button,
                        input::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }
                    </style>

                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

                <body>


                    <div class="container">
                        <div class="card px-3 py-3 mx-auto my-5">
                            <h4 class="text-center">Fill out the form</h4>
                            <hr>
                            <form class="row g-3 needs-validation" action="/staff-panel/accommodation/book-accommodation/"
                                method="post" enctype="multipart/form-data" novalidate>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Male Staffs</label>
                                    <input type="number" class="form-control" name="head-count-male-staff" id="validationCustom01"
                                        value="Mark" required>

                                    <div class="invalid-feedback">
                                        Number is invalid
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02" class="form-label">Female Staffs</label>
                                    <input type="number" class="form-control" name="head-count-female-staff" id="validationCustom02"
                                        value="Otto" required>

                                    <div class="invalid-feedback">
                                        Number is invalid
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustomUsername" class="form-label">Male Students</label>
                                    <div class="input-group has-validation">
                                        <input type="number" class="form-control" name="head-count-male-student"
                                            id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>

                                        <div class="invalid-feedback">
                                            Number is invalid
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom03" class="form-label">Female Students</label>
                                    <input type="number" class="form-control" id="validationCustom03"
                                        name="head-count-female-student" required>

                                    <div class="invalid-feedback">
                                        Number is invalid
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Check in date</label>
                                    <input type="date" class="form-control" id="validationCustom03" name="check-in-date" required>

                                    <div class="invalid-feedback">
                                        Date is invalid
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom05" class="form-label">Check out date</label>
                                    <input type="date" class="form-control" id="validationCustom03" name="check-out-date" required>
                                    <div class="invalid-feedback">
                                        Date is invalid
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose file<small>(Please upload pdf only)</small></label>
                                    <input class="form-control" type="file" name="auth-file" id="formFile" accept=".pdf" required>
                                    <div class="invalid-feedback">
                                        File is invalid
                                    </div>
                                </div>
                                <div class="flex-row justify-content-center">
                                    <button class="btn btn-dark rounded-1 w-25" type="submit">submit</button>
                                </div>

                            </form>
                        </div>
                    </div>


                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                        crossorigin="anonymous"></script>

                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (() => {
                            'use strict'

                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            const forms = document.querySelectorAll('.needs-validation')

                            // Loop over them and prevent submission
                            Array.from(forms).forEach(form => {
                                form.addEventListener('submit', event => {
                                    if (!form.checkValidity()) {
                                        event.preventDefault()
                                        event.stopPropagation()
                                    }

                                    form.classList.add('was-validated')
                                }, false)
                            })
                        })()
                    </script>

                </body>

                </html>
            <?php
        }


    } else {
        ?>
        <div class="notification rounded-1" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="notification-header">
                <h3 class="notification-title">Notification</h3>
                <button type="button" class="btn-close-1" data-bs-dismiss="notification" aria-label="Close"></button>
            </div>
            <div class="notification-container">
                <div class="notification-media">
                    <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg" alt=""
                        class="notification-user-avatar">
                    <i class="fa fa-thumbs-up notification-reaction"></i>
                </div>
                <div class="notification-content">
                    <p class="notification-text">
                        <strong>Something seems wrong , Please Login again</strong>
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

            window.location.href = "/logout";
        </script>
        <?php
    }
    ?>

</body>