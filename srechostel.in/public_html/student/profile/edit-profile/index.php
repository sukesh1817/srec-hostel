<?php
// Include Composer's autoload file
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../composer/vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// create image manager with desired driver
$manager = new ImageManager(new Driver());

// read image from file system
$image = $manager->read('images/example.jpg');

// resize image proportionally to 300px width
$image->scale(width: 300);

// insert watermark
$image->place('images/watermark.png');

// save modified image in new format 
$image->toJpg()->save('images/foo.png');
// Check if the user is a student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="/images/icons/profile-icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/../../config/domain.php";
    $end_point = "css-files/toogle.css";
    ?>
    <link rel="stylesheet" href="<?php echo $domain . $end_point; ?>" />
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
    <style>
        .form-control.rounded-1:focus {
            box-shadow: none;
            border-color: black;
        }

        .avatar {
            vertical-align: middle;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .labels {
            font-size: 11px;
        }

        input[type="file"] {
            display: none;
        }

        .file-input-label {
            background: url('/images/layout-image/edit.svg') no-repeat center center;
            display: block;
            padding: 10px 10px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php";

    $common = new commonClass();

    if (
        isset($_POST['sur-name']) &&
        isset($_POST['address']) &&
        isset($_POST['mobile-no']) &&
        isset($_POST['post-code']) &&
        isset($_POST['room-no']) &&
        isset($_POST['study-year']) &&
        isset($_POST['tutor-name']) &&
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

        if ($_FILES['profile-img']['error'] == 0) {
            $filename = $_FILES['profile-img']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed_extensions = ['heic', 'jpg', 'jpeg', 'png'];

            if (!in_array($ext, $allowed_extensions)) {
                die('Unsupported file type.');
            }

            if ($ext == 'heic') {
                chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/");
                if (file_exists($_SESSION['yourToken'] . ".jpg")) {
                    unlink($_SESSION['yourToken'] . ".jpg");
                }
                $dir = $_SESSION['yourToken'] . '.heic';
                if (move_uploaded_file($_FILES["profile-img"]["tmp_name"], $dir)) {
                    try {
                        $image = Image::make($dir);
                        $encoded = $image->encode('jpg');
                        $encoded->save($_SESSION['yourToken'] . ".jpg");
                        unlink($dir);
                    } catch (Exception $e) {
                        echo 'Error processing image: ', $e->getMessage(), "\n";
                    }
                }
            } else {
                chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/");
                if (file_exists($_SESSION['yourToken'] . '.jpg')) {
                    unlink($_SESSION['yourToken'] . '.jpg');
                }
                $image_name = $_SESSION['yourToken'] . '.jpg';
                if (move_uploaded_file($_FILES["profile-img"]["tmp_name"], $image_name)) {
                    // Image saved successfully
                }
            }
        }

        $result = $common->editSomeData($data);
        if (isset($_POST['pass-word'])) {
            $res = $common->changePass($_SESSION['yourToken'], $_POST['pass-word']);
        }

        if ($result) {
            // Success message
            echo '<div class="alert alert-success">Profile updated successfully.</div>';
        }
    }

    // Get the student details
    $details = $common->getFullStudDetails($_SESSION['yourToken']);
    $sur_name = $common->getSurname();
    $log_det = $common->getLoginDetails($_SESSION['yourToken']);

    // Write the end point of profile picture
    $end_point = "api/accounts/profile_photo/";
    ?>
    <div class="container-fluid alert alert-warning" role="alert">
        You do not have the access to change some data
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <form action="/profile/edit-profile/" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="avatar mt-5" id="avatar" width="150px" src="<?php echo $domain . $end_point; ?>"
                            alt="Avatar">
                        <label for="fileInput" class="file-input-label mt-2 m-2"></label>
                        <input type="file" id="fileInput" name="profile-img" accept="image/*" />
                        <span class="font-weight-bold"><?php echo $details[0]['name']; ?></span><span
                            class="text-black-50"><?php echo $details[1]['email']; ?></span><span></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Full name</label><input type="text" class="form-control rounded-1"
                                    name="full-name" placeholder="full name" value="<?php echo $details[0]['name']; ?>"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Surname</label>
                                <input type="text" class="form-control rounded-1" name="sur-name"
                                    value="<?php echo $sur_name ?>" placeholder="surname">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Mobile Number</label>
                                <input type="number" class="form-control rounded-1" name="mobile-no"
                                    placeholder="enter phone number" value="<?php echo $details[1]['phone_no']; ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Address Line</label>
                                <textarea type="text" class="form-control rounded-1 w-100 h-100" name="address"
                                    placeholder="enter address line 1"><?php echo $details[1]['stud_address']; ?></textarea>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="labels">Postcode</label>
                                <input type="number" class="form-control rounded-1" name="post-code"
                                    placeholder="enter postcode" value="<?php echo $details[1]['stud_postcode']; ?>">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="labels">Room No</label>
                                <input type="number" class="form-control rounded-1" name="room-no"
                                    placeholder="enter room number" value="<?php echo $details[1]['room_no']; ?>">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="labels">Study Year</label>
                                <select name="study-year" class="form-control rounded-1">
                                    <option value="1" <?php if ($details[1]['stud_year'] == 1)
                                        echo 'selected'; ?>>1
                                    </option>
                                    <option value="2" <?php if ($details[1]['stud_year'] == 2)
                                        echo 'selected'; ?>>2
                                    </option>
                                    <option value="3" <?php if ($details[1]['stud_year'] == 3)
                                        echo 'selected'; ?>>3
                                    </option>
                                    <option value="4" <?php if ($details[1]['stud_year'] == 4)
                                        echo 'selected'; ?>>4
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="labels">Tutor Name</label>
                                <input type="text" class="form-control rounded-1" name="tutor-name"
                                    placeholder="enter tutor name" value="<?php echo $details[1]['tutor_name']; ?>">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="labels">AC Name</label>
                                <input type="text" class="form-control rounded-1" name="ac-name"
                                    placeholder="enter ac name" value="<?php echo $details[1]['ac_name']; ?>">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="labels">Change Password</label>
                                <input type="password" class="form-control rounded-1" name="pass-word"
                                    placeholder="***********">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-1wX0WnEBylBse02vM0eNFFeMBQnYBhhY7nH3hbM9y6O3iJ0WmRg7YcD63V2jLFU9"
        crossorigin="anonymous"></script>
    <script>
        document.getElementById('fileInput').addEventListener('change', function () {
            var fileInput = this;
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatar').src = e.target.result;
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    </script>
</body>

</html>