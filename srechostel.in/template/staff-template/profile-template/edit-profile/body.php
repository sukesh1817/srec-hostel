<body>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";
        ?>



        <?php

        if (
                isset($_POST['sur-name']) 
              //  and isset($_POST['mobile-no'])

        ) {

                $surname = $_POST['sur-name'];
              //  $mobile_no = $_POST['mobile-no'];

                $data = array(
                        "sur-name" => $surname
                );
                if (isset($_FILES['profile-img']['name'])) {
                        $ext = explode(".", strtolower($_FILES['profile-img']['name']))[1];
                        if ($ext == "heic") {
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
                                        $convert = Maestroerror\HeicToJpg::convert("/var/www/hostel-website/srec-assets/profile-photos/tmp/" . $_SESSION['yourToken'] . '.heic')->saveAs("/var/www/hostel-website/srec-assets/profile-photos/" . $_SESSION['yourToken'] . ".jpg");
                                        if ($convert) {
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
                $result = $details->editSomeDataStaff($data);
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
                                                <p class="ms-1">Profile edited successfully <br> <small style="font-size: 12px;">(If
                                                                your are changing your surname it may take some time to change)</small>
                                                </p>

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
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
        $stud = new commonClass();
        $details = $stud->getstaffDetails($_SESSION['yourToken']);
        $sur_name = $stud->getSurnameStaff();
        ?>
        <div class="container-fluid alert alert-warning" role="alert">
                you do not have the access to change some data
        </div>
        <div class="container rounded bg-white mt-5 mb-5">
                <form action="/staff-panel/profile/edit-profile/" method="post" enctype="multipart/form-data">
                        <div class="row">
                                <div class="col-md-3 border-right">
                                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                                        class="avatar mt-5" width="150px" src="/profile-photo/">
                                                <label for="fileInput" class="file-input-label mt-2 m-2"></label>
                                                <input type="file" id="fileInput" name="profile-img" accept="image/*">

                                                <span
                                                        class="font-weight-bold"><?php echo $details['name']; ?></span><span
                                                        class="text-black-50"><?php echo $details['email']; ?></span><span>
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
                                                                        value="<?php echo $details['name']; ?>"
                                                                        readonly>
                                                        </div>
                                                        <div class="col-md-6"><label class="labels">Surname(show in your
                                                                        dashboard)</label><input type="text"
                                                                        class="form-control" name="sur-name"
                                                                        value="<?php echo $sur_name ?>"
                                                                        placeholder="surname">
                                                        </div>
                                                </div>
                                                <div class="row mt-3">
                                                        <!--<div class="col-md-12"><label class="labels">Mobile-->
                                                        <!--                Number</label><input type="number"-->
                                                        <!--                class="form-control" name="mobile-no"-->
                                                        <!--                placeholder="enter phone number"-->
                                                        <!--                value="<?php // echo $details['phone_no']; ?>">-->
                                                        <!--</div>-->

                                                        <div class="col-md-12"><label class="labels">Email
                                                                        ID</label><input type="text"
                                                                        class="form-control" name="email-id"
                                                                        placeholder="enter email id"
                                                                        value="<?php echo $details['email']; ?>"
                                                                        readonly></div>
                                                        <div class="col-md-12"><label class="labels">
                                                                        Branch</label><input type="text"
                                                                        class="form-control" name="branch-degree"
                                                                        placeholder="education"
                                                                        value="<?php echo $details['department']; ?>"
                                                                        readonly></div>
                                                </div>
                                                <div class="mt-5 text-center"><button
                                                                class="container-fluid btn btn-dark profile-button"
                                                                type="submit">Save
                                                                Profile</button></div>

                                        </div>
                                </div>
                                <div class="col-md-4">


                </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        <?php
        // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/footbar.php";
        ?>
</body>