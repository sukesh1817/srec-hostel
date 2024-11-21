<?php
function show_common_complaint($row)
{
    ?>
    <div class="container">
        <div class="key-value-container">
            <div class="row key-value-row">
                <div class="col-6 key">Department</div>
                <div class="col-6 value"><?php echo $row['department'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Date of complaint</div>
                <div class="col-6 value"><?php echo $row['date_of_complaint'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Complaint summary</div>
                <div class="col-6 value"><?php echo $row['complaint_summary'] ?></div>
            </div>
            <p class="text-center mt-5">
                <a href="/complaint/edit-complaint/" class="btn btn-dark px-5 mb-5 rounded-1" type="button">
                    Change something
                </a>
            </p>
        </div>

    </div>
    <?php
}


function show_individual_complaint($row)
{
    ?>
    <div class="container">
        <div class="key-value-container">
            <div class="row key-value-row">
                <div class="col-6 key">Student name</div>
                <div class="col-6 value"><?php echo $row['stud_name'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Roll no</div>
                <div class="col-6 value"><?php echo $row['roll_no'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Department</div>
                <div class="col-6 value"><?php echo $row['department'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Room no</div>
                <div class="col-6 value"><?php echo $row['room_no'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Date of complaint</div>
                <div class="col-6 value"><?php echo $row['date_of_complaint'] ?></div>
            </div>
            <div class="row key-value-row">
                <div class="col-6 key">Complaint summary</div>
                <div class="col-6 value"><?php echo $row['complaint_summary'] ?></div>
            </div>
            <p class="text-center mt-5">
                <a href="/complaint/edit-complaint/" class="btn btn-dark px-5 mb-5 rounded-1" type="button">
                    Change something
                </a>
            </p>
        </div>

    </div>
    <?php
}

?>