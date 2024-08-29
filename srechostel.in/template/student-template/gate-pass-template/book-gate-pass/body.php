<body style="background-color: #f8f9fa;">
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/gate-pass-template/book-gate-pass/crumbs.php";

    ?>

    <?php
    if (isset($_SESSION['yourToken'])) {
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
        $pass = new Pass_class();
        $alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);
        if ($alreadyBooked[0] || $alreadyBooked[1] || $alreadyBooked[2]) {
            ?>

            <div class="container my-5" bis_skin_checked="1">
                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                    bis_skin_checked="1">

                    <svg class="bi mt-5 mb-3" width="48" height="48">
                        <use xlink:href="#check2-circle"></use>
                    </svg>
                    <h1 class="text-body-emphasis"><?php 
                    if($alreadyBooked[0]){
                        echo "Gate pass ";
                    } else if($alreadyBooked[1]){
                        echo "Working day pass ";
                    } else {
                        echo "General Holiday day pass ";
                    }
                    ?><strong>Already booked</strong></h1>
                    <p class="col-lg-6 mx-auto mb-4">
                        Your gatepass is already booked please check it
                    </p>
                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                        Check gatepass status
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
                            <strong>Your gatepass Already booked</strong>
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

        } else if (isset($_POST["passType"])) {
            include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
            include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
            $studDetail = new commonClass();
            $details = $studDetail->getStudDetails($_SESSION["yourToken"]);
            $pass = new Pass_class();
            $passType = $_POST["passType"];
            if ($passType == "gatePass") {
                if (
                    isset($details["name"]) and
                    isset($details["roll_no"]) and
                    isset($details["department"]) and
                    isset($_POST["time_out"]) and
                    isset($_POST["time_in"]) and
                    isset($_POST["address"]) and 
                     isset($_POST["reason"])
                    // this if check the all values are correctly set 
                ) {
                    // this is the place inside the gatepass if all the values are set correctly
                    $array = array(
                        "name" => $details["name"],
                        "roll_no" => $details["roll_no"],
                        "department" => $details["department"],
                        "time_out" => $_POST["time_out"],
                        "time_in" => $_POST["time_in"],
                        "address" => $_POST["address"],
                        "reason" => $_POST["reason"]
                    );
                    $result = $pass->setGatePass($array);
                    if ($result) {
                        //prints success when all ok
                        ?>

                            <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Out pass <strong>Booked Successfully</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Out pass is booked successfully , to check it click the below button
                                    </p>
                                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        check gatepass status
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
                                            <strong>Your gatepass booked successfully</strong>
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
                                    <h1 class="text-body-emphasis">Out pass <strong>Booked Failed</strong></h1>
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
                                        <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                                            alt="" class="notification-user-avatar">
                                        <i class="fa fa-thumbs-up notification-reaction"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">
                                            <strong>Your gate pass is not booked something went wrong</strong>
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
                    // this is print in the frontend when the record is not added in fornt page
                    ?>
                         <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Out pass Booked Declined</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Your details not added in Hostel Records 
                                    </p>
                                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        Contact admin
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
                                    <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                                        alt="" class="notification-user-avatar">
                                    <i class="fa fa-thumbs-up notification-reaction"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="notification-text">
                                        <strong>Your Detials is not added please contact the admin</strong>
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
            } else if ($passType == "workingDays") {
                if (
                    isset($details["name"]) and
                    isset($details["roll_no"]) and
                    isset($details["department"]) and
                    isset($_POST["tutor_name"]) and
                    isset($_POST["academic_coordinator_name"]) and
                    isset($_POST["time_of_leaving"]) and
                    isset($_POST["time_of_entry"]) and
                    isset($_POST["address"]) and 
                     isset($_POST["reason"])
                    // this if check the all values are correctly set 
                ) {
                    // this is the place inside the workingday if all the values are set correctly
                    $array = array(
                        "name" => $details["name"],
                        "roll_no" => $details["roll_no"],
                        "department" => $details["department"],
                        "tutor_name" => $_POST["tutor_name"],
                        "ac_name" => $_POST["academic_coordinator_name"],
                        "time_of_leaving" => $_POST["time_of_leaving"],
                        "time_of_entry" => $_POST["time_of_entry"],
                        "address" => $_POST["address"],
                        "reason" => $_POST["reason"]
                    );
                    $result = $pass->setWorkingDayPass($array);
                   
                    if ($result) {
                        //prints success when all ok
                        ?>

                            <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Working day pass <strong>Booked Successfully</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Working day pass is booked successfully , to check it click the below button
                                    </p>
                                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        check gatepass status
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
                                            <strong>Your gatepass booked successfully</strong>
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
                                    <h1 class="text-body-emphasis">Working day pass <strong>Booked Failed</strong></h1>
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
                                        <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                                            alt="" class="notification-user-avatar">
                                        <i class="fa fa-thumbs-up notification-reaction"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">
                                            <strong>Your gate pass is not booked something went wrong</strong>
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
                    // this is print in the frontend when the record is not added in fornt page
                    ?>
                         <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">Working day pass Booked Declined</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Your details not added in Hostel Records 
                                    </p>
                                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        Contact admin
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
                                    <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                                        alt="" class="notification-user-avatar">
                                    <i class="fa fa-thumbs-up notification-reaction"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="notification-text">
                                        <strong>Your Details is not added please contact the admin</strong>
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

            } else if ($passType == "generalDays") {

                if (
                    isset($details["name"]) and
                    isset($details["roll_no"]) and
                    isset($details["department"]) and
                    isset($_POST["time_of_leaving"]) and
                    isset($_POST["time_of_entry"]) and
                    isset($_POST["address"]) and 
                     isset($_POST["reason"])
                    // this if check the all values are correctly set 
                ) {

                    // this is the place inside the generalday if all the values are set correctly
                    $array = array(
                        "name" => $details["name"],
                        "roll_no" => $details["roll_no"],
                        "department" => $details["department"],
                        "time_of_leaving" => $_POST["time_of_leaving"],
                        "time_of_entry" => $_POST["time_of_entry"],
                        "address" => $_POST["address"],
                        "reason" => $_POST["reason"]
                    );
                    $result = $pass->setGeneralDayPass($array);
                    
                    if ($result) {
                        
                        //prints success when all ok
                        ?>

                            <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">General holiday pass <strong>Booked Successfully</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        General holiday pass is booked successfully , to check it click the below button
                                    </p>
                                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        check gatepass status
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
                                            <p>Your gatepass booked successfully , Want to book buspass ?</p>
                                            <a href="/stud-panel/gate-pass/book-bus-pass/" class="container-fluid btn btn-dark rounded-1">buspass</a>
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
                                    <h1 class="text-body-emphasis">General holiday pass <strong>Booked Failed</strong></h1>
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
                                        <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                                            alt="" class="notification-user-avatar">
                                        <i class="fa fa-thumbs-up notification-reaction"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">
                                            <strong>Your gate pass is not booked something went wrong</strong>
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
                    // this is print in the frontend when the record is not added in fornt page
                    ?>
                         <div class="container my-5" bis_skin_checked="1">
                                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed  rounded-1"
                                    bis_skin_checked="1">

                                    <svg class="bi mt-5 mb-3" width="48" height="48">
                                        <use xlink:href="#check2-circle"></use>
                                    </svg>
                                    <h1 class="text-body-emphasis">General holiday pass Booked Declined</strong></h1>
                                    <p class="col-lg-6 mx-auto mb-4">
                                        Your details not added in Hostel Records 
                                    </p>
                                    <a href="/stud-panel/gate-pass/check-pass-status/" class=" btn btn-dark mb-5 rounded-1">
                                        Contact admin
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
                                    <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                                        alt="" class="notification-user-avatar">
                                    <i class="fa fa-thumbs-up notification-reaction"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="notification-text">
                                        <strong>Your Detials is not added please contact the admin</strong>
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
        } else {
            ?>
                <div class="mx-auto my-3">
                    <div class="container">
                        <div class="login-container">
                            <div class="heads py-2 rounded-1">
                                <h2 class="text-center">OUT PASS</h2>
                            </div>
                            <div class="padcen rounded">
                                <div class="pass-type-selection ">
                                    <label for="">Select Pass Type</label><br>
                                    <div class="in">
                                        <input type="radio" id="gatePass" name="pass_type" value="gate_pass" class="bullet"
                                            required>
                                        <label for="gatePass">Out pass</label><br>
                                    </div>
                                    <input type="radio" id="collegeWorkingDays" name="pass_type" value="college_working_days"
                                        class="bullet" required>
                                    <label for="collegeWorkingDays">College Working Days Home Pass</label><br>

                                    <input type="radio" id="generalHolidays" name="pass_type" value="general_holidays"
                                        class="bullet" required>
                                    <label for="generalHolidays">General Holidays Home Pass</label><br>
                                </div>
                                <form action="../book-gate-pass/" method="post" id="passForm" enctype="multipart/form-data">
                                    <div id="passDetails"></div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-dark container-fluid rounded-1" type="submit">Book the pass</button>
                                    </div>
                                </form>
                            </div>
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
                    <img src="https://blog.tryshiftcdn.com/uploads/2021/01/notifications@2x.jpg"
                        alt="" class="notification-user-avatar">
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


    <?php
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";

    ?>
</body>