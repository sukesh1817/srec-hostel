<?php
function pass_theme($student)
{

?>

<div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
    <div class="box">
        <div class="icon mb-2"><img style="width: 40px;height:40px;" src="/images/layout-image/download.png" alt="">
        </div>
        <div class="title mb-2"><button style="border-radius:2px;" class="btn btn-dark "
                id="download-button">download</button>
        </div>
        <div class="subtitle">click to download</button>
        </div>
    </div>
</div>
<div id="html-content">
    <div class="container-1">
        <h3 class="text-center title fw-bold"><?php echo $student['pass_type'] ?></h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-md-12 mt-1">
                <div class="box">
                    <div class="icon">
                        <img class="avatar img-fluid" src='<?php echo $student['img_url'] ?>' alt='profile-img'
                            width='100' height='100'>
                    </div>
                    <div class="title">Student profile</div>
                    <div class="subtitle">Image</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/name.png" alt="">
                    </div>
                    <div class="title"><?php echo $student['name'] ?></div>
                    <div class="subtitle">Name</div>
                </div>
            </div>
            <div class="col-lg-6 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/rollno.png"
                            alt=""></div>
                    <div class="title"><?php echo $student['roll_no'] ?></div>
                    <div class="subtitle">Rollno</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/dept.png" alt="">
                    </div>
                    <div class="title"><?php echo $student['dept'] ?></div>
                    <div class="subtitle">Department</div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/room.png" alt="">
                    </div>
                    <div class="title"><?php echo $student['room_no'] ?></div>
                    <div class="subtitle">Room no</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/hostel.png"
                            alt=""></div>
                    <div class="title"><?php echo $student['hostel'] ?></div>
                    <div class="subtitle">Hostel</div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mt-6">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/address.png"
                            alt=""></div>
                    <div class="title"><?php echo $student['address'] ?></div>
                    <div class="subtitle">Address</div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6 col-md-12 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/from.png" alt="">
                    </div>
                    <div class="title"><?php echo $student['time_leave'] ?> | <?php echo $student['date_leave'] ?></div>
                    <div class="subtitle">From</div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/to.png" alt="">
                    </div>
                    <div class="title"><?php echo $student['time_enter'] ?> | <?php echo $student['date_enter'] ?></div>
                    <div class="subtitle">To</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-md-12 mt-1">
                <div class="box">
                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/approvedby.png"
                            alt=""></div>
                    <div class="title"><?php echo $student['accepted_by'] ?></div>
                    <div class="subtitle">Accepted by</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-md-12 mt-1">
                <div class="box">
                    <div class="icon">
                        <img class="img-fluid" src='<?php echo $studemt['qr_code']; ?>' alt='QR Code' width='100' height='100'>
                    </div>
                    <div class="title"><a class="text-dark" href="/gate-pass/qr-code/">click to entry with qr</a></div>
                    <div class="subtitle">Qr Link</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}