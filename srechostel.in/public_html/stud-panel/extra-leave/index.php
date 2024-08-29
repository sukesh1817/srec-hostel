<?php
//this helps to find the the login person is student or not
include_once $_SERVER["DOCUMENT_ROOT"]."/"."is-stud.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extra Leave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .btn-orange {
            --bs-btn-color: #fff;
            --bs-btn-bg: #eb901a;
            --bs-btn-border-color: #eb901a;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #e99c38;
            --bs-btn-hover-border-color: #eb901a;
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #eb901a;
            --bs-btn-active-border-color: #eb901a;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #eb901a;
            --bs-btn-disabled-border-color: #eb901a
        }
    </style>
</head>
<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");

$pass = new Pass_class();
$result = $pass->alreadyBooked($_SESSION["yourToken"]);
if($_SESSION["yourToken"]) {
if (($result[1] || $result[2])) {
    $result = $pass->isPassExtensionBooked($_SESSION["yourToken"]);
    if ($result) {
        
        ?>
        <div class="p-5 m-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 mb-2 fw-bold">You Already Booked Extra Leave</h1>
                <p class="col-md-8 fs-4">Please Wait</p>
                <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
            </div>
        </div>
        <?php
    } else if (
        isset($_POST["reason"]) and
        isset($_POST["to_date"]) and
        isset($_POST["from_date"]) and
        isset($_POST["days_to_extend"])
    ) {
        $stud = new commonClass();
        $student = $stud->getStudDetails($_SESSION["yourToken"]);
        $array = array(
            "name" => $student["name"],
            "rollNo" => $student["roll_no"],
            "dept" => $student["department"],
            "fromDate" => $_POST["from_date"],
            "toDate" => $_POST["to_date"],
            "daysToExtend" => $_POST["days_to_extend"],
            "reason" => $_POST["reason"]
        );
        $result = $pass->setPassExtension($array);
        if ($result) {
            ?>
                <div class="p-5 m-3 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">Pass Extension Booked Successfully</h1>
                        <p class="col-md-8 fs-4">Enjoy The Day :)</p>
                        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                    </div>
                </div>
            <?php
        } else {
            ?>
                <div class="p-5 m-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">Record Not Added</h1>
                        <p class="col-md-8 fs-4">Please Contact Hostel Warden</p>
                        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                    </div>
                </div>
            <?php
        }
    } else {
        ?>



            <body style="background-color: #f8f9fa;">
                <style>
                    .headerImg1 {
                        width: 7%;
                        height: 7%;
                        float: left;
                    }

                    .headerImg2 {
                        width: 10%;
                        height: 10%;
                        float: right;
                    }

                    .heads {
                        background-color: #ec940f;
                        color: #fff;
                        width: 100%;
                        border-top-left-radius: 8px;
                        border-top-right-radius: 8px;
                    }

                    .bullet {
                        margin-left: 0%;
                        align-items: start;
                    }


                    .clge-name {
                        font-size: 250%;
                    }

                    p {
                        font-size: 120%;
                    }

                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        height: 100vh;
                        justify-content: center;
                        align-items: center;
                        display: flex;
                    }

                    .padcen {
                        padding: 20px;
                    }

                    .login-container {
                        background-color: #fff;
                        margin: auto;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        max-width: 500px;
                        width: 600px;
                    }

                    .login-container label {
                        font-weight: bold;
                    }

                    .login-container input {
                        padding: 8px;
                        margin-bottom: 16px;
                        box-sizing: border-box;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                    }



                    input::-webkit-outer-spin-button,
                    input::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }

                    .mt-6 {
                        margin-top: 10%;
                    }

                    .pass-type-selection {
                        margin-bottom: 20px;
                    }

                    .btn-orange {
                        --bs-btn-color: #fff;
                        --bs-btn-bg: #eb901a;
                        --bs-btn-border-color: #eb901a;
                        --bs-btn-hover-color: #fff;
                        --bs-btn-hover-bg: #e99c38;
                        --bs-btn-hover-border-color: #eb901a;
                        --bs-btn-focus-shadow-rgb: 49, 132, 253;
                        --bs-btn-active-color: #fff;
                        --bs-btn-active-bg: #eb901a;
                        --bs-btn-active-border-color: #eb901a;
                        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                        --bs-btn-disabled-color: #fff;
                        --bs-btn-disabled-bg: #eb901a;
                        --bs-btn-disabled-border-color: #eb901a
                    }
                </style>

                <div class="login-container mt-5 ms-2 me-2">
                    <div class="heads py-2">
                        <h2 class="text-center">Leave Extension</h2>
                    </div>
                    <div class="padcen">

                        <form action="../extraLeave/" method="post" id="passForm" enctype="multipart/form-data">
                            <label for="daysToExtend">Number of Days to Extend</label><br>
                            <input type="number" id="daysToExtend" name="days_to_extend" style="width:100%" required><br>

                            <label for="fromDate">Date From</label><br>
                            <input type="date" id="fromDate" name="from_date" style="width:100%" required><br>

                            <label for="toDate">Date To</label><br>
                            <input type="date" id="toDate" name="to_date" style="width:100%" required><br>

                            <label for="reason">Reason</label><br>
                            <textarea id="reason" name="reason" rows="4" style="width:100%" required></textarea><br>
                            <button class="container-fluid btn btn-orange" type="submit">Confirm</button>

                        </form>
                    </div>
                </div>
            <?php

    }
    ?>

        <?php

} else {
    ?>
 <div class="p-5 m-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">You Do n't Book Any Home Pass</h1>
                        <p class="col-md-8 fs-4">Please Go Back</p>
                        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                    </div>
                </div>
    <?php
 
}

}else {
?>
 <div class="p-5 m-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
                        <p class="col-md-8 fs-4">Please Go Back</p>
                        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
                    </div>
                </div>
<?php
}
?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>