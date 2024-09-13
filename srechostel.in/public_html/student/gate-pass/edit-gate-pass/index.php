<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check pass status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php
    // poppins font css included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
</head>

<body>
    <?php
    // navbar html code is included.
    require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // include the gate pass class file.
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/pass.class.php");

    // include the gate pass class file.
    $pass = new Pass_class();

    // if anyone of gatepass is booked then execute this block.
    $alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);

    if ($alreadyBooked[0] or $alreadyBooked[1] or $alreadyBooked[2]) {
        // this block executes when the gate pass is already booked.
        ?>
        <div class="container mx-3">
            <?php

            // breadcrumbs  included.
            require_once $_SERVER['DOCUMENT_ROOT'] . "/__common/__breadcrumbs/bookpass.php";

            // use the bread crub function.
            // bread_crumb_gatepass("edit gate pass");
            ?>
            <div id="this-is-form" class="container card  col-md-12 col-lg-6 mt-4">
                <h3 class="text-center">
                    <?php
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
                                "reason" => $_POST['reason']
                            );
                            $edit = $pass->editPass($array, "gate_pass");
                            if ($edit) {
                                ?>
                                <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                                    <img class="d-block mx-auto mb-4" src="/images/layout-image/gate.png" alt="" width="72" height="57">
                                    <h1 class="display-5 fw-bold text-body-emphasis">Gate pass edited Successfully</h1>
                                    <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                                        <p class="lead mb-4">Check your status.</p>
                                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                                            <a href="/gate-pass/chec-pass-status/"
                                                class="btn btn-dark btn-lg px-4 gap-3 rounded-1">status
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
                            isset($_POST["tutor_name"]) and
                            isset($_POST['reason'])
                        ) {
                            $array = array(
                                "from" => $_POST['from'],
                                "to" => $_POST['to'],
                                "address" => $_POST['address'],
                                "ac_name" => $_POST['ac_name'],
                                "tutor_name" => $_POST['tutor_name'],
                                "reason" => $_POST['reason']

                            );
                            $edit = $pass->editPass($array, "working_pass");
                            if ($edit) {
                                ?>
                                    <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                                        <img class="d-block mx-auto mb-4" src="/images/layout-image/gate.png" alt="" width="72" height="57">
                                        <h1 class="display-5 fw-bold text-body-emphasis">Working day pass edited Successfully</h1>
                                        <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                                            <p class="lead mb-4">Check your status.</p>
                                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                                                <a href="/gate-pass/chec-pass-status/"
                                                    class="btn btn-dark btn-lg px-4 gap-3 rounded-1">status
                                                </a>
                                            </div>
                                        </div>
                                    </div>
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
                                "reason" => $_POST['reason']

                            );
                            $edit = $pass->editPass($array, "general_pass");
                            if ($edit) {
                                ?>
                                        <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
                                            <img class="d-block mx-auto mb-4" src="/images/layout-image/gate.png" alt="" width="72" height="57">
                                            <h1 class="display-5 fw-bold text-body-emphasis">General holiday edited Successfully</h1>
                                            <div class="col-lg-6 mx-auto" bis_skin_checked="1">
                                                <p class="lead mb-4">Check your status.</p>
                                                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
                                                    <a href="/gate-pass/chec-pass-status/"
                                                        class="btn btn-dark btn-lg px-4 gap-3 rounded-1">status
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                            }
                        }
                        $row = $pass->getMyPass("general_pass");
                        echo "General Holiday pass";
                    }
                    ?>
                </h3>
                <form class="row g-3" method="POST">
                    <?php
                    if ($alreadyBooked[0]) {
                        ?>
                        <input type='hidden' name='pass' value='out_pass'>
                        <?php
                    } else if ($alreadyBooked[2]) {
                        ?>
                            <input type='hidden' name='pass' value='general_holiday_pass'>
                        <?php
                    }
                    ?>
                    <div class="col-md-12">
                        <label for="from" class="form-label">From <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control rounded-1" name="from" id="from"
                            value="<?php echo $row['time_of_leave'] ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label for="to" class="form-label">To <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control rounded-1" name="to" id="to"
                            value="<?php echo $row['time_of_entry'] ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-1" name="address" id="address"
                            value="<?php echo $row['address_name'] ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-1" name="reason" id="reason"
                            value="<?php echo $row['reason'] ?>" required>
                    </div>
                    <?php
                    if ($alreadyBooked[1]) {
                        ?>
                        <input type='hidden' name='pass' value='working_pass'>
                        <div class="col-md-12">
                            <label for="from" class="form-label">Tutor name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-1" id="from" name="tutor_name"
                                value="<?php echo $row['tutor_name'] ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="from" class="form-label">Ac name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-1" id="from" name="ac_name"
                                value="<?php echo $row['ac_name'] ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="from" class="form-label">Authorization letter <span class="text-danger">*</span></label>
                            <input type="file" class="form-control rounded-1" id="from" required>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-12">
                        <button class="container-fluid btn btn-dark rounded-1" type="submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } else {
        ?>
        <main>
            <div class="container-fluid" bis_skin_checked="1">
                <div class="border-bottom"></div>
                <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
                    <div class="container-fluid py-5" bis_skin_checked="1">
                        <h1 class="display-5 fw-bold">Gate pass not booked</h1>
                        <p class="col-md-8 fs-4">Please book the gate pass.</p>
                        <a href="/gate-pass/book-gate-pass/" class="btn btn-dark btn-lg rounded-1">book gate pass
                        </a>
                    </div>
                </div>
            </div>
        </main>
        <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</html>