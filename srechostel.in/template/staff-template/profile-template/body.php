<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";
    ?>


    <?php

    include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
    $staff = new commonClass();
    $details = $staff->getStaffDetails($_SESSION['yourToken']);
    $sur_name = $staff->getSurnameStaff();
    // print_r($details);
    

    ?>
    <div class="container-fluid alert alert-info" role="alert">
        Do you want to edit something ?
        <a class="text-decoration-none text-dark" href="/staff-panel/profile/edit-profile">
            <u>click</u>
        </a>
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="avatar mt-5 mb-2"
                        style="width: 150px;" src="/profile-photo/" alt="profile-picture">
                    <span class="font-weight-bold"><?php echo $details['name']; ?></span><span
                        class="text-black-50"><?php echo $details['designation']; ?></span><span> </span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Full name</label><input type="text"
                                class="form-control" placeholder="full name" value="<?php echo $details['name']; ?>"
                                readonly>
                        </div>
                        <div class="col-md-6"><label class="labels">Surname(show in your dashboard)</label><input
                                type="text" class="form-control" value="<?php echo $sur_name ?>" placeholder="surname"
                                readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">designation</label><input type="text"
                                class="form-control" placeholder=" "
                                value="<?php echo $details['designation']; ?>" readonly></div>


                        <div class="col-md-12"><label class="labels">Email ID</label><input type="text"
                                class="form-control" placeholder="enter email id"
                                value="<?php echo $details['email']; ?>" readonly></div>
                        <div class="col-md-12"><label class="labels">Branch</label><input type="text"
                                class="form-control" placeholder="education"
                                value="<?php echo $details['department']; ?>" readonly></div>
                    </div>
                    <div class="mt-5 text-center"><a href="/logout" class="container-fluid btn btn-dark profile-button"
                            type="submit">Logout</a></div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>
    <?php
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/footbar.php";
    ?>
</body>