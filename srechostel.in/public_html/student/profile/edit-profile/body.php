<body>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
        ?>

        <?php

        if (
                isset($_POST['sur-name']) and
                isset($_POST['address']) and
                isset($_POST['mobile-no']) and
                isset($_POST['post-code']) and
                isset($_POST['room-no']) and
                isset($_POST['study-year']) and
                isset($_POST['tutor-name']) and
                isset($_POST['ac-name'])

        ) {

                $surname = $_POST['sur-name'];
                $address = $_POST['address'];
                $mobile_no = $_POST['mobile-no'];
                $post_code = $_POST['post-code'];
                $room_no = $_POST['room-no'];
                $study_year = $_POST['study-year'];
                $tutor_name = $_POST['tutor-name'];
                $ac_name = $_POST['ac-name'];
                $data = array(
                        "sur-name" => $surname,
                        "address" => $address,
                        "mobile-no" => $mobile_no,
                        "post-code" => $post_code,
                        "room-no" => $room_no,
                        "study-year" => $study_year,
                        "tutor-name" => $tutor_name,
                        "ac-name" => $ac_name
                );
                if (($_FILES['profile-img']['error'] == 0)) {
                        $filename = $_FILES['profile-img']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);


                        if ($ext == "heic" or $ext == "HEIC") {
                                chdir($_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/");
                                if (file_exists($_SESSION['yourToken'] . ".jpg")) {
                                        unlink($_SESSION['yourToken'] . ".jpg");
                                        chdir($_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/tmp/");
                                        if (file_exists($_SESSION['yourToken'] . $ext)) {
                                                unlink($_SESSION['yourToken'] . $ext);
                                        }
                                        chdir($_SERVER['DOCUMENT_ROOT'] . "/../profile-photos/");
                                }

                                $dir = "tmp/" . $_SESSION['yourToken'] . '.heic';
                                if (move_uploaded_file($_FILES["profile-img"]["tmp_name"], $dir)) {
                                        include $_SERVER['DOCUMENT_ROOT'] . "/../composer/vendor/autoload.php";
                                        $convert = Maestroerror\HeicToJpg::convert("/home/u219671451/public_html/testing/srechostel.in/profile-photos/tmp/" . $_SESSION['yourToken'] . '.heic')->saveAs("/home/u219671451/public_html/testing/srechostel.in/profile-photos/" . $_SESSION['yourToken'] . ".jpg");
                                        chdir("/home/u219671451/public_html/testing/srechostel.in/profile-photos/tmp/");
                                        unlink($_SESSION['yourToken'] . ".heic", );
                                        if ($convert) {
                                                // successfully converted.
                                        }

                                }

                        } else {
                                // echo "in jpg";
                                chdir($_SERVER['DOCUMENT_ROOT'] . "/..");
                                // echo getcwd();
                                if (file_exists($_SESSION['yourToken'] . ".jpg")) {
                                        unlink($_SESSION['yourToken'] . '.jpg');
                                }
                                $dir = "profile-photos/" . $_SESSION['yourToken'] . '.jpg';
                                // echo $dir;
                                if (move_uploaded_file($_FILES["profile-img"]["tmp_name"], $dir)) {

                                }
                        }

                }
                include $_SERVER['DOCUMENT_ROOT'] . "/../class-files/common.class.php";

                $details = new commonClass();
                $result = $details->editSomeData($data);
                $f = 0;
                if (isset($_POST['pass-word'])) {
                        $res = $details->changePass($_SESSION['yourToken'], $_POST['pass-word']);
                        $f = 1;
                }
                if ($result) {
                        ?>
                        <div class="notification rounded-1" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="notification-header">
                                        <h3 class="notification-title">Notification</h3>
                                        <i type="button" class="btn-close-1" data-bs-dismiss="notification" aria-label="Close"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                                        class="bi bi-x" viewBox="0 0 16 16">
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
                                        <div class="notification-title">
                                                <p class="ms-1">Profile edited successfully</p>

                                                <a class="ms-2 container-fluid btn btn-dark rounded-1" href="/stud-panel/">Go back</a>

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
        ?>


        <?php
        include_once($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
        $stud = new commonClass();
        $details = $stud->getFullStudDetails($_SESSION['yourToken']);
        $sur_name = $stud->getSurname();
        $log_det = $stud->getLoginDetails($_SESSION['yourToken']);

        ?>
        <div class="container-fluid alert alert-warning" role="alert">
                you do not have the access to change some data
        </div>
        <div class="container rounded bg-white mt-5 mb-5">
                <form action="/stud-panel/profile/edit-profile/" method="post" enctype="multipart/form-data">
                        <div class="row">
                                <div class="col-md-3 border-right">
                                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                                        class="avatar mt-5" width="150px" src="/profile-photo/">
                                                <label for="fileInput" class="file-input-label mt-2 m-2"></label>
                                                <input type="file" id="fileInput" name="profile-img" accept="image/*">

                                                <span
                                                        class="font-weight-bold"><?php echo $details[0]['name']; ?></span><span
                                                        class="text-black-50"><?php echo $details[1]['email']; ?></span><span>
                                                </span>
                                        </div>
                                </div>
                                <div class="col-md-5 border-right">
                                        <div class="p-3 py-5">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="text-right">Profile Settings</h4>
                                                </div>
                                                <div class="row mt-2">
                                                        <div class="col-md-6"><label class="labels">Full
                                                                        name</label><input type="text"
                                                                        class="form-control" name="full-name"
                                                                        placeholder="full name"
                                                                        value="<?php echo $details[0]['name']; ?>"
                                                                        readonly>
                                                        </div>
                                                        <div class="col-md-6"><label
                                                                        class="labels">Surname</label><input type="text"
                                                                        class="form-control" name="sur-name"
                                                                        value="<?php echo $sur_name ?>"
                                                                        placeholder="surname">
                                                        </div>
                                                </div>
                                                <div class="row mt-3">
                                                        <div class="col-md-12"><label class="labels">Mobile
                                                                        Number</label><input type="number"
                                                                        class="form-control" name="mobile-no"
                                                                        placeholder="enter phone number"
                                                                        value="<?php echo $details[1]['phone_no']; ?>">
                                                        </div>
                                                        <div class="col-md-12"><label class="labels">Address
                                                                        Line</label><textarea type="text"
                                                                        class="form-control w-100 h-100" name="address"
                                                                        placeholder="enter address line 1"><?php echo $details[1]['stud_address']; ?></textarea>
                                                        </div>
                                                        <div class="col-md-12 mt-4"><label
                                                                        class="labels">Postcode</label><input
                                                                        type="number" class="form-control"
                                                                        name="post-code"
                                                                        placeholder="enter address line 2"
                                                                        value="<?php echo $details[1]['pincode']; ?>">
                                                        </div>
                                                        <div class="col-md-12"><label class="labels">Email
                                                                        ID</label><input type="text"
                                                                        class="form-control" name="email-id"
                                                                        placeholder="enter email id"
                                                                        value="<?php echo $details[1]['email']; ?>"
                                                                        readonly></div>
                                                        <div class="col-md-12"><label class="labels">Degree and
                                                                        Branch</label><input type="text"
                                                                        class="form-control" name="branch-degree"
                                                                        placeholder="education"
                                                                        value="<?php echo $details[0]['department']; ?>"
                                                                        readonly></div>
                                                </div>
                                                <div class="row mt-1">

                                                        <div class="col-md-6">
                                                                <label class="labels">Year of study</label><input
                                                                        name="study-year" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo $details[0]['year_of_study']; ?>"
                                                                        placeholder="year">
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="labels">Room no</label><input
                                                                        name="room-no" type="number"
                                                                        class="form-control"
                                                                        value="<?php echo $details[1]['room_no']; ?>"
                                                                        placeholder="year">
                                                        </div>
                                                        <div class="col-md-12">
                                                                <div class="user-box">
                                                                        <label class="labels">Password</label>
                                                                        <div class="password-container">
                                                                                <input class="form-control"
                                                                                        type="password" name="pass-word"
                                                                                        id="password"
                                                                                        value="<?php echo $log_det['pass_word']; ?>"
                                                                                        required="" />
                                                                                <span class="password-toggle-icon"><i
                                                                                                class="fas fa-eye"></i></span>
                                                                        </div>
                                                                </div>

                                                        </div>
                                                </div>

                                        </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="p-3 py-5">
                                                <div
                                                        class="d-flex justify-content-between align-items-center experience">
                                                        <h4 class="text-right">Gurdian information</h4>
                                                </div><br>
                                                <div class="col-md-12"><label class="labels">Father name</label><input
                                                                type="text" class="form-control" name="father-name"
                                                                placeholder="father name"
                                                                value="<?php echo $details[2]['father_name']; ?>"
                                                                readonly></div>
                                                <div class="col-md-12"><label class="labels">Mother name</label><input
                                                                type="text" class="form-control" name="mother-name"
                                                                placeholder="mother name"
                                                                value="<?php echo $details[2]['mother_name']; ?>"
                                                                readonly></div>
                                                <div class="col-md-12"><label class="labels">Father no</label><input
                                                                type="text" class="form-control" name="father-no"
                                                                placeholder="father no"
                                                                value="<?php echo $details[2]['father_contact_no']; ?>"
                                                                readonly></div>
                                                <div class="col-md-12"><label class="labels">Mother no</label><input
                                                                type="text" class="form-control" name="mother-no"
                                                                placeholder="mother no"
                                                                value="<?php echo $details[2]['mother_contact_no']; ?>"
                                                                readonly></div>
                                                <div class="col-md-12"><label class="labels">Tutor name</label><input
                                                                type="text" class="form-control" name="tutor-name"
                                                                placeholder="Tutor name"
                                                                value="<?php echo $details[0]['tutor_name']; ?>"></div>
                                                <div class="col-md-12"><label class="labels">Ac name</label><input
                                                                type="text" class="form-control" placeholder="Ac name"
                                                                name="ac-name"
                                                                value="<?php echo $details[0]['ac_name']; ?>"></div>
                                        </div>
                                        <div class="mt-5 text-center"><button
                                                        class="container-fluid btn btn-dark profile-button"
                                                        type="submit">Save
                                                        Profile</button></div>
                </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        <?php
        // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";
        ?>

</body>