<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
?>
<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
$pass = new Pass_class();
$alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);
if ($alreadyBooked[0] or $alreadyBooked[1] or $alreadyBooked[2]) {

    ?>

    <div class="mx-3">
        <h1 class="mt-2 mb-2 text-center">Edit Your Pass</h1>
        <div class="border-bottom"></div>
        <div id="this-is-form" class="container card p-3 col-md-12 col-lg-6 mt-4">
            <h3 class="text-center"><?php
            $row = [];

            if ($alreadyBooked[0]) {

                if (
                    isset($_POST["from"]) and
                    isset($_POST["to"]) and
                    isset($_POST["address"]) and 
                    isset($_POST["reason"])
                ) {

                    $array = array(
                        "from" => $_POST['from'],
                        "to" => $_POST['to'],
                        "address" => $_POST['address'],
                        "reason"=>$_POST['reason']
                    );
                    $edit = $pass->editPass($array, "gate_pass");
                    if ($edit) {
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
                                            <p>Your gatepass Edited successfully</p>
                                            <a class="btn btn-dark" href="../">Go back</a>

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
                $row = $pass->getMyPass("gate_pass");
                echo "Out pass";
            } else if ($alreadyBooked[1]) {
                if (
                    isset($_POST["from"]) and
                    isset($_POST["to"]) and
                    isset($_POST["address"]) and 
                    isset($_POST["ac_name"]) and 
                    isset($_POST["tutor_name"])  and 
                    isset($_POST['reason'])
                ) {
                    $array = array(
                        "from" => $_POST['from'],
                        "to" => $_POST['to'],
                        "address" => $_POST['address'],
                        "ac_name" => $_POST['ac_name'],
                        "tutor_name"=>$_POST['tutor_name'],
                        "reason"=>$_POST['reason']

                    );
                    $edit = $pass->editPass($array, "working_pass");
                    if ($edit) {
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
                                            <p>Your gatepass Edited successfully</p>
                                            <a class="btn btn-dark" href="../">Go back</a>

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
                $row = $pass->getMyPass("working_pass");
                echo "Working day pass";
            } else if ($alreadyBooked[2]) {
                if (
                    isset($_POST["from"]) and
                    isset($_POST["to"]) and
                    isset($_POST["address"]) and 
                    isset($_POST['reason'])
                ) {
                    $array = array(
                        "from" => $_POST['from'],
                        "to" => $_POST['to'],
                        "address" => $_POST['address'],
                        "reason"=>$_POST['reason']

                    );
                    $edit = $pass->editPass($array, "general_pass");
                    if ($edit) {
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
                                            <p>Your gatepass Edited successfully</p>
                                            <a class="btn btn-dark" href="../">Go back</a>

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
                $row = $pass->getMyPass("general_pass");
                echo "General Home pass";
            }
            ?>
            </h3>
            <form class="row g-3 needs-validation" method="post" novalidate>
                <?php
                                if ($alreadyBooked[0]) {
                                    ?>
                                                        <input type='hidden' name='pass' value='out_pass'>

                                    <?php
                                } else if($alreadyBooked[2]){
                                    ?>
                                    <input type='hidden' name='pass' value='general_holiday_pass'>

                                    <?php
                                }

                ?>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">From</label>
                    <input type="datetime-local" class="form-control" name="from" id="validationCustom01"
                        value="<?php echo $row['time_of_leave'] ?>" required>
                    <div class="valid-feedback">

                    </div>
                    <div class="invalid-feedback">
                        Please choose a time.
                    </div>
                </div>


                <div class="col-md-12">
                    <label for="validationCustom04" class="form-label">To</label>
                    <input type="datetime-local" class="form-control" name="to" id="validationCustom01"
                        value="<?php echo $row['time_of_entry'] ?>" required>

                    <div class="valid-feedback">

                    </div>
                    <div class="invalid-feedback">
                        Please choose a time.
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="validationCustom04" class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" id="validationCustom01"
                        value="<?php echo $row['address_name'] ?>" required>

                    <div class="valid-feedback">

                    </div>
                    <div class="invalid-feedback">
                        Please choose a Valid Address.
                    </div>
                </div>
                 <div class="col-md-12">
                    <label for="validationCustom04" class="form-label">Reason</label>
                    <input type="text" class="form-control" name="reason" id="validationCustom01"
                        value="<?php echo $row['reason'] ?>" required>

                    <div class="valid-feedback">

                    </div>
                    <div class="invalid-feedback">
                        Please choose a Valid Reason.
                    </div>
                </div>
                <?php
                if ($alreadyBooked[1]) {
                    ?>
                    <input type='hidden' name='pass' value='working_pass'>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">Tutor name</label>
                        <input type="text" class="form-control" id="validationCustom01"  name="tutor_name" value="<?php echo $row['tutor_name'] ?>"
                            required>
                        <div class="valid-feedback">

                        </div>
                        <div class="invalid-feedback">
                            Please choose a Valid Tutor name.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">Ac name</label>
                        <input type="text" class="form-control" id="validationCustom01" name="ac_name" value="<?php echo $row['ac_name'] ?>"
                            required>
                        <div class="valid-feedback">

                        </div>
                        <div class="invalid-feedback">
                            Please choose a Valid Ac name.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">Authorization letter</label>
                        <input type="file" class="form-control" id="validationCustom01" required>
                        <div class="valid-feedback">

                        </div>
                        <div class="invalid-feedback">
                            Please choose a Valid File.
                        </div>
                    </div>
                    <?php

                }
                ?>


                <div class="col-12">
                    <button class="container-fluid btn btn-dark" type="submit">Confirm edit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>


    <?php


} else {
    ?>
    <main>
        <div class="container-fluid" bis_skin_checked="1">
            <div class="border-bottom"></div>
            <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                <div class="container-fluid py-5" bis_skin_checked="1">
                    <h1 class="display-5 fw-bold">Gate pass not booked</h1>
                    <p class="col-md-8 fs-4">Please book the gate pass to edit it.</p>
                    <a href="/stud-panel/gate-pass/book-gate-pass" class="btn btn-dark btn-lg rounded-1">book gate pass
                        <span id="count-down"> </span></a>
                </div>
            </div>

            <!-- <div class="row align-items-md-stretch" bis_skin_checked="1">
          <div class="col-md-6" bis_skin_checked="1">
            <div class="h-100 p-5 text-bg-dark rounded-1" bis_skin_checked="1">
              <h2>Change the background</h2>
              <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then,
                mix and match with additional component themes and more.</p>
              <button class="btn btn-outline-light" type="button">Example button</button>
            </div>
          </div>
          <div class="col-md-6" bis_skin_checked="1">
            <div class="h-100 p-5 bg-body-tertiary border rounded-1" bis_skin_checked="1">
              <h2>Add borders</h2>
              <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure
                to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's
                content for equal-height.</p>
              <button class="btn btn-outline-secondary" type="button">Example button</button>
            </div>
          </div>
        </div> -->
        </div>
    </main>
    <script>
        var elem = document.getElementById('count-down');
        var timer = 5;
        setInterval(function () {
            if (timer == 0) {

                window.location.href = "/stud-panel/gate-pass/book-gate-pass";
            }
            elem.innerHTML = timer;
            timer--;

        }, 1000);
    </script>
    <?php
}
?>


<?php
// include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";

?>