<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
    ?>


    <?php

    include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
    $stud = new commonClass();
    $details = $stud->getFullStudDetails($_SESSION['yourToken']);
    $sur_name = $stud->getSurname();
    $log_det = $stud->getLoginDetails($_SESSION['yourToken']);


    ?>
    <div class="container-fluid alert alert-info" role="alert">
        Do you want to edit something ?
        <a class="text-decoration-none text-dark" href="/stud-panel/profile/edit-profile">
            <u>click here</u>
        </a>
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="avatar mt-5 mb-2"
                        style="width: 150px;" src="/profile-photo/" alt="profile-picture">
                    <span class="font-weight-bold"><?php echo $details[0]['name']; ?></span><span
                        class="text-black-50"><?php echo $details[1]['email']; ?></span><span> </span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Full name</label><input type="text"
                                class="form-control" placeholder="full name" value="<?php echo $details[0]['name']; ?>"
                                readonly>
                        </div>
                        <div class="col-md-6"><label class="labels">Surname</label><input type="text"
                                class="form-control" value="<?php echo $sur_name ?>" placeholder="surname" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text"
                                class="form-control" placeholder="enter phone number"
                                value="<?php echo $details[1]['phone_no']; ?>" readonly></div>
                        <div class="col-md-12"><label class="labels">Address Line</label><textarea type="text"
                                class="form-control w-100 h-100" placeholder="enter address line 1"
                                readonly><?php echo $details[1]['stud_address']; ?></textarea></div>
                        <div class="col-md-12 mt-4"><label class="labels">Postcode</label><input type="text"
                                class="form-control" placeholder="enter address line 2"
                                value="<?php echo $details[1]['pincode']; ?>" readonly></div>
                        <div class="col-md-12"><label class="labels">Email ID</label><input type="text"
                                class="form-control" placeholder="enter email id"
                                value="<?php echo $details[1]['email']; ?>" readonly></div>
                        <div class="col-md-12"><label class="labels">Degree and Branch</label><input type="text"
                                class="form-control" placeholder="education"
                                value="<?php echo $details[0]['department']; ?>" readonly></div>
                    </div>
                    <div class="row mt-1">
                        <!-- <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" 
                placeholder="country" value=""></div>
            <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" 
                value="" placeholder="state"></div> -->
                        <div class="col-md-6">
                            <label class="labels">Year of study</label><input type="text" class="form-control"
                                value="<?php echo $details[0]['year_of_study']; ?>" placeholder="year" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Room no</label><input type="text" class="form-control"
                                value="<?php echo $details[1]['room_no']; ?>" placeholder="year" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="user-box">
                            <label class="labels">Password</label>
                            <div class="password-container">
                                <input class="form-control" type="password" name="pass-word" id="password"
                                    value="<?php echo $log_det['pass_word']; ?>" readonly />
                                <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
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
                    <div class="col-md-12"><label class="labels">Father name</label><input type="text"
                            class="form-control" placeholder="father name"
                            value="<?php echo $details[2]['father_name']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Mother name</label><input type="text"
                            class="form-control" placeholder="mother name"
                            value="<?php echo $details[2]['mother_name']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Father no</label><input type="text"
                            class="form-control" placeholder="father no"
                            value="<?php echo $details[2]['father_contact_no']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Mother no</label><input type="text"
                            class="form-control" placeholder="mother no"
                            value="<?php echo $details[2]['mother_contact_no']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Tutor name</label><input type="text"
                            class="form-control" placeholder="Tutor name"
                            value="<?php echo $details[0]['tutor_name']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Ac name</label><input type="text" class="form-control"
                            placeholder="Ac name" value="<?php echo $details[0]['ac_name']; ?>" readonly></div>

                </div>
                <div class="mt-5 text-center"><a href="/logout"
                        class="container-fluid btn btn-dark profile-button">Logout</a></div>
            </div>
        </div>

    </div>

    </div>

    </div>
    <?php
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";
    ?>
</body>