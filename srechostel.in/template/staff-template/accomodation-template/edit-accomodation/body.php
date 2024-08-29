<body style="background-color: #f8f9fa;">
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";

    ?>

    <?php
    if (isset($_SESSION['yourToken'])) {
        
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/accommodation.class.php");
        $accom = new accommodation();
        $alreadyBooked = $accom->checkAccomStatus($_SESSION["yourToken"]);
        if ($alreadyBooked == "pending") {
            if (
                isset($_POST["check-in-date"]) &&
                isset($_POST["check-out-date"]) &&
                isset($_POST["head-count-male-staff"]) &&
                isset($_POST["head-count-female-staff"]) &&
                isset($_POST["head-count-male-student"]) &&
                isset($_POST["head-count-female-student"]) &&
                isset($_FILES["auth-file"])
            ) {

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
                            <h1 class="text-body-emphasis">Your Accommodation <strong>Edited Successfully</strong></h1>
                            <p class="col-lg-6 mx-auto mb-4">
                                Accommodation is Edited successfully , to check it click the below button
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
                                    <strong>Your accomodation Edited successfully</strong>
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
                            <h1 class="text-body-emphasis">Accommodation <strong>Edited Failed</strong></h1>
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
                                    <strong>Your accomodation is not Edited something went wrong</strong>
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
               

       

                <body>

                    <?php
                    $data = $accom->getMyPendingData($_SESSION['yourToken']);
                    // print_r($data);
        

                    ?>
                    <div class="container">
                        <div class="card px-3 py-3 mx-auto my-5">
                            <h4 class="text-center">Edit the form</h4>
                            <hr>
                            <form class="row g-3 needs-validation" action="/staff-panel/accommodation/edit-accommodation/"
                                method="post" enctype="multipart/form-data" novalidate>
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Male Staffs</label>
                                    <input type="number" class="form-control rounded-1" name="head-count-male-staff" id="validationCustom01"
                                        value="<?php echo $data['no_of_male_staff'] ?>" required>

                                    <div class="invalid-feedback">
                                        Number is invalid
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02" class="form-label">Female Staffs</label>
                                    <input type="number" class="form-control rounded-1" name="head-count-female-staff" id="validationCustom02"
                                        value="<?php echo $data['no_of_female_staff'] ?>" required>

                                    <div class="invalid-feedback">
                                        Number is invalid
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustomUsername" class="form-label">Male Students</label>
                                    <div class="input-group has-validation">
                                        <input type="number" class="form-control rounded-1" name="head-count-male-student"
                                            id="validationCustomUsername" aria-describedby="inputGroupPrepend"
                                            value="<?php echo $data['no_of_male_student'] ?>" required>

                                        <div class="invalid-feedback">
                                            Number is invalid
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="no-female-stud" class="form-label">Female Students</label>
                                    <input type="number" class="form-control rounded-1" id="no-female-stud"
                                        name="head-count-female-student" value="<?php echo $data['no_of_female_student'] ?>"
                                        required>

                                    <div class="invalid-feedback">
                                        Number is invalid
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="check-in-date" class="form-label">Check in date</label>
                                    <input type="date" class="form-control rounded-1" id="check-in" name="check-in-date"
                                        value="<?php echo $data['accom_check_in_date'] ?>" required>

                                    <div class="invalid-feedback">
                                        Date is invalid
                                    </div>
                                </div>
                                <div class="col-md-3">
                                 
                                    <label for="check-out-date" class="form-label">Check out date</label>
                                    <input type="date" class="form-control rounded-1" id="check-in" name="check-out-date"
                                        value="<?php echo trim($data['accom_check_out_date']) ?>" required>
                                    <div class="invalid-feedback">
                                        Date is invalid
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label"><small>Choose file(When changes required)</small></label>
                                    <input class="form-control rounded-1" type="file" name="auth-file" id="formFile">
                                    <div class="invalid-feedback">
                                        File is invalid
                                    </div>
                                </div>
                                <div class="flex-row justify-content-center">
                                    <button class="btn btn-dark rounded-1" type="submit">changes</button>
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
        } else if($alreadyBooked=="accepted")  {
            ?>
                <div class="px-4 py-5 my-5 text-center">
                    <h1 class="display-5 fw-bold text-body-emphasis">Accommodation accepted</h1>
                    <div class="col-lg-6 mx-auto">
                        <p class="lead mb-4">Your accommodation order is accepted successfully , so you do not have the ability to
                            edit it</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href=".." type="button" class="btn btn-dark rounded-1 btn-lg px-4 gap-3">Go back</a>
                        </div>
                    </div>
                </div>
            <?php

        } else if($alreadyBooked=="declined") {
            ?>
             <div class="px-4 py-5 my-5 text-center">
                    <h1 class="display-5 fw-bold text-body-emphasis">Accommodation declined</h1>
                    <div class="col-lg-6 mx-auto">
                        <p class="lead mb-4">Your accommodation order is declined , You need to clear your accommodation status before booking new one.</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="/api/clear-accom/"  class="btn btn-dark rounded-1 btn-lg px-4 gap-3">Clear the Accommodation</a>
                        </div>
                    </div>
                </div>
            <?php
        } else {
            ?>
            <div class="px-4 py-5 my-5 text-center">
                    <h1 class="display-5 fw-bold text-body-emphasis">No Accommodation Orders</h1>
                    <div class="col-lg-6 mx-auto">
                        <p class="lead mb-4">You have no accmmodation orders, please book the accommodation before edit the accommodation.</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="/staff-panel/accommodation/"  class="btn btn-dark rounded-1 btn-lg px-4 gap-3">Go back</a>
                        </div>
                    </div>
                </div>
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