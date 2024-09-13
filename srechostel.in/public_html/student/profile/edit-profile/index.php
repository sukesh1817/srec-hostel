<?php
// Check if the user is a student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";

?>


<?php
// Include Composer's autoload file
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../composer/vendor/autoload.php';
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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

    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // include the common class files.
    require_once $_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php";

    // initialize the common class.
    $common = new commonClass();
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
                chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/");
               
                if (file_exists($_SESSION['yourToken'] . ".jpg")) {
                    unlink($_SESSION['yourToken'] . ".jpg");
                    chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/tmp/");
                    if (file_exists($_SESSION['yourToken'] . $ext)) {
                        unlink($_SESSION['yourToken'] . $ext);
                    }
                }
                chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/tmp/");
                $dir = $_SESSION['yourToken'] . '.heic';
                if (move_uploaded_file($_FILES["profile-img"]["tmp_name"], $dir)) {

                    $apiKey ='eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZjJkYzMwNjg5NmQxODI0Y2IzYzM3MGJjYmMxMjU1NzlmNzljNGVhNzgzODBjZGY2YmJjYjY4NTQzYjA5ZTA0YTk0NzRiNzg5ZmQ1NTZlYzciLCJpYXQiOjE3MjYyMzcxNjcuNDYzMjY0LCJuYmYiOjE3MjYyMzcxNjcuNDYzMjY2LCJleHAiOjQ4ODE5MTA3NjcuNDYwMTk0LCJzdWIiOiI2OTU3Nzg1NCIsInNjb3BlcyI6WyJ1c2VyLndyaXRlIiwidXNlci5yZWFkIiwidGFzay5yZWFkIiwidGFzay53cml0ZSIsIndlYmhvb2sucmVhZCIsIndlYmhvb2sud3JpdGUiLCJwcmVzZXQucmVhZCIsInByZXNldC53cml0ZSJdfQ.hMi_T6L40nEp7wKbcNk98c29D7L-7Rpxzj3v9zhVVnv2g8dTlA4HGs7vQOwgJms54F33eRxBczY-NcC109HnC0UNMYZTNly4HQth7mH89Ux1CZHnp7PYu4jjF7PckmU3E3A5sJOjyOWXXQDnn-uxafIEYc3iyKTz4x7e9hA0y0g7jtqhmVt6qp6q4pZ8xMYs0sQTmmDEiUo6qIWNHPo9JRjH6i2i6EVOR4-g89WpaUsigoMc_g7W5c8xj8ee4POZZDaDczRGXOmFu2dbqxQXjoml00pYplY-c78bqcYfBFIyNLvgeCGXzA1JyhnpfdOL9JA4W4d_Pmi6Z6V_7X3ixK26Pt7UPHNf-qnoiD6dl7UIoiqEnef5ntSlazzpdyac5TJyg4CHJ3NrqBAIkYmQB7aK7htN3s99m2qmTtu8zK_kEoK5fEAkhh4kffTsxnOLvhUMxIuakuT75XPB0BXn2hjxqJKRm5GOJlBVRS2K6DUcIVv15vewOEzgXsywQjZgOAheJ7K6d1D-S7TKnlrEyjdw_pMUUy3Ij8Pi8MKiAu1xkPcor3TpGGNByWDrH1caGu6HfWut9TXVefQXM44pykEa71KJuW4FP8UJmOeb2burNw0mimqbDVe71jvj5Lg9f2hgxiyaKB3eSQeiYGbdDZjryhlYw7DBtAksg006DpI';
                    $inputFile = '2211049.heic';
                    $outputFile = 'image.jpg';
                    $url = 'https://api.cloudconvert.com/v2/convert';
                    $data = [
                        'input' => 'upload',
                        'file' => new \CURLFile($inputFile),
                        'outputformat' => 'jpg',
                        'apikey' => $apiKey,
                    ];
                    echo "<pre>";
                    print_r($data);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    print_r($response);
                    curl_close($ch);
                    echo "</pre>";

                    file_put_contents($outputFile, $response);
                    // echo "Image converted successfully.";

                    // echo getcwd();
                    exit;
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read("s.png");
                   
                    $image->toJpeg()->save('storage/palm_photo/'.$filename);
                    $image = $manager->read("2211026.heic");
                   
                    // save modified image in new format 
                    chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/");
                    $image->toJpg()->save('s.jpg');
                    chdir($_SERVER['DOCUMENT_ROOT'] . "/../../profile-photos/tmp/");
                    unlink($_SESSION['yourToken'] . ".heic", );
                    

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

        $result = $common->editSomeData($data);
        $f = 0;
        if (isset($_POST['pass-word'])) {
            $res = $common->changePass($_SESSION['yourToken'], $_POST['pass-word']);
            $f = 1;
        }
        if ($result) {
            // after edited successfully give the success message.
            ?>


            <?php
        }

    }


    // get the student details.
    $details = $common->getFullStudDetails($_SESSION['yourToken']);
    $sur_name = $common->getSurname();
    $log_det = $common->getLoginDetails($_SESSION['yourToken']);

    // write the end point of profile picture.
    $end_point = "api/accounts/profile_photo/"
        ?>
    <div class="container-fluid alert alert-warning" role="alert">
        you do not have the access to change some data
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <form action="/profile/edit-profile/" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="avatar mt-5" id="avatar" width="150px" src="<?php echo $domain . $end_point; ?>" alt="Avatar">
                        <label for="fileInput" class="file-input-label mt-2 m-2">Choose an image</label>
                        <input type="file" id="fileInput" name="profile-img" accept="image/*" />

                        <span class="font-weight-bold"><?php echo $details[0]['name']; ?></span><span
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
                            <div class="col-md-6">
                                <label class="labels">Full name</label><input type="text" class="form-control rounded-1"
                                    name="full-name" placeholder="full name" value="<?php echo $details[0]['name']; ?>"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Surname</label>
                                <input type="text" class="form-control rounded-1" name="sur-name" value="<?php echo $sur_name ?>"
                                    placeholder="surname">
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
                                    placeholder="enter address line 2" value="<?php echo $details[1]['pincode']; ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email ID</label><input type="text" class="form-control rounded-1"
                                    name="email-id" placeholder="enter email id"
                                    value="<?php echo $details[1]['email']; ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Degree and Branch</label>
                                <input type="text" class="form-control rounded-1" name="branch-degree" placeholder="education"
                                    value="<?php echo $details[0]['department']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-1">

                            <div class="col-md-6">
                                <label class="labels">Year of study</label>
                                <input name="study-year" type="text" class="form-control rounded-1"
                                    value="<?php echo $details[0]['year_of_study']; ?>" placeholder="year">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Room no</label>
                                <input name="room-no" type="number" class="form-control rounded-1"
                                    value="<?php echo $details[1]['room_no']; ?>" placeholder="year">
                            </div>
                            <div class="col-md-12">
                                <div class="user-box">
                                    <label class="labels">Password</label>
                                    <div class="password-container">
                                        <div class="password-wrapper" style="position: relative;">
                                            <input class="form-control rounded-1 rounded-1" type="password" name="pass-word"
                                                id="password" value="<?php echo $log_det['pass_word']; ?>" />
                                            <span class="password-toggle-icon"
                                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience">
                            <h4 class="text-right">Gurdian information</h4>
                        </div><br>
                        <div class="col-md-12">
                            <label class="labels">Father name</label>
                            <input type="text" class="form-control rounded-1" name="father-name" placeholder="father name"
                                value="<?php echo $details[2]['father_name']; ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Mother name</label>
                            <input type="text" class="form-control rounded-1" name="mother-name" placeholder="mother name"
                                value="<?php echo $details[2]['mother_name']; ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Father no</label>
                            <input type="text" class="form-control rounded-1" name="father-no" placeholder="father no"
                                value="<?php echo $details[2]['father_contact_no']; ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Mother no</label>
                            <input type="text" class="form-control rounded-1" name="mother-no" placeholder="mother no"
                                value="<?php echo $details[2]['mother_contact_no']; ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Tutor name</label>
                            <input type="text" class="form-control rounded-1" name="tutor-name" placeholder="Tutor name"
                                value="<?php echo $details[0]['tutor_name']; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Ac name</label>
                            <input type="text" class="form-control rounded-1" placeholder="Ac name" name="ac-name"
                                value="<?php echo $details[0]['ac_name']; ?>">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="container-fluid btn btn-dark profile-button rounded-1" type="submit">Save Profile</button>
                    </div>
        </form>
    </div>
</body>

<?php
// this package contains which domain you are working.
require_once $_SERVER['DOCUMENT_ROOT'] . "/../../config/domain.php";
$end_point = "js-files/ui-component/toggle.js";
?>
<script src="<?php echo $domain . $end_point; ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

    <script>
    // Get the input and image elements
    const fileInput = document.getElementById('fileInput');
    const avatar = document.getElementById('avatar');

    // Add event listener to the input
    fileInput.addEventListener('change', function() {
        // Check if a file was selected
        if (this.files && this.files[0]) {
            // Create a new FileReader instance
            const reader = new FileReader();

            // Set up the onload event for the reader
            reader.onload = function(e) {
                // Set the src of the image to the uploaded file's data URL
                avatar.src = e.target.result;
            };

            // Read the file as a data URL
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

</html>
</html>