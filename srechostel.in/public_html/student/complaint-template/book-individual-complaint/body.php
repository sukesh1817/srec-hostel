<body>

    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
    ?>
    <?php
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
    $complaint = new commonClass();
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
                <a href="/stud-panel/complaint/complaint-status/" class=" btn btn-dark mb-5 rounded-1">
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
                        <a href="/stud-panel/complaint/complaint-status/" class=" btn btn-dark mb-5 rounded-1">
                            check complaint status
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
                                <strong>Your complaint booked successfully</strong>
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
            <div class="m-3 d-flex justify-content-center">
                <div class="cont">

                    <h2 class="text-center">Individual Complaint</h2>
                    <hr>
                    <form class="needs-validation" action="/stud-panel/complaint/book-individual-complaint/" method="post"
                        enctype="multipart/form-data">

                        <!-- 
                    <input class='form-control mb-2' id="dept" name="dept" type="text" required /> -->


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
    <?php
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";
    ?>
</body>