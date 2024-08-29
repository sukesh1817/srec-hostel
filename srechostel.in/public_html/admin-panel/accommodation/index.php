<?php
/*
this code checks wheather the person is admin or not,
if admin allow them ,
else do not allow them
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Accommodation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
?>
</head>

<body>

<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
?>
<?php
/*
first the user give the request using http-get method,
based on the request given by the user,
we show the data to the user,
if user click pending we show pending request,
if user click accepted we show accepted request,
we show the data based on the user request
*/

?>
    <?php
    if (isset($_REQUEST["status"])) {
        ?>
        <div class="container mt-6">
            <div class="row d-flex justify-content-start">
                <?php
                include_once($_SERVER["DOCUMENT_ROOT"] . "/../class-files/accommodation.class.php");
                if ($_REQUEST["status"] == "pending") {
                    ?>
                    <h1 class="display-5 text-center">Pending Accommodation</h1>
                    <!-- <hr> -->
                    <?php
                    $accom = new accommodation();
                    $pendingRequest = $accom->getPendingAccom();
                    $i = 0;
                    while (isset($pendingRequest[$i])) {
                        if (isset($pendingRequest[$i])) {
                            $staffdetails = $accom->getStaffDetails($pendingRequest[$i]["staff_id"] );

                            ?>
                            <div class="card m-3" style="width: 20rem;">
                                <img style="width:200px;height:150px"
                                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwIDMwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LDIyICBWNGgxOHYxOGMwLDIuMjA5LTEuNzkxLDQtNCw0IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48cGF0aCBkPSJNMTcsMjIgIEwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxNSIgeDI9IjIxIiB5MT0iMTMiIHkyPSIxMyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSIxMyIgeTI9IjEzIi8+PGxpbmUgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6IzAwMDAwMDtzdHJva2Utd2lkdGg6MjtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MTA7IiB4MT0iMTUiIHgyPSIyMSIgeTE9IjE3IiB5Mj0iMTciLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxMSIgeDI9IjEzIiB5MT0iMTciIHkyPSIxNyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjE1IiB4Mj0iMjEiIHkxPSI5IiB5Mj0iOSIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSI5IiB5Mj0iOSIvPjxwYXRoIGQ9Ik0xNywyMkwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6Ii8+PC9zdmc+"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Summary</h5>
                                    
                                    <b>
                                    <?php echo $pendingRequest[$i]["staff_name"] ?> </b>From the Department of <b>
                                    <?php echo $staffdetails['department'] ?></b> Had booked an accommodation From <b>
                                    <?php echo $pendingRequest[$i]["accom_check_in_date"] ?> </b> To Date <b>
                                    <?php echo $pendingRequest[$i]["accom_check_out_date"] ?> </b> <hr> 
                                    Total Students : <b>
                                    <?php echo $pendingRequest[$i]["no_of_male_student"]+$pendingRequest[$i]["no_of_female_student"]  ?></b> <br> Total Staff :  <b><?php echo $pendingRequest[$i]["no_of_male_staff"]+$pendingRequest[$i]["no_of_female_staff"]?></b>
                                    </p>
                                    <button onclick="acceptAccom('<?php echo $pendingRequest[$i]['staff_id'] ?>')"
                                        class="btn btn-outline-success container-fluid mb-2 rounded-1">Accept</button>
                                    <button onclick="rejectAccom('<?php echo $pendingRequest[$i]['staff_id'] ?>')"
                                        class="btn btn-outline-danger container-fluid mb-2 rounded-1">Decline</button>
                                        <a class="btn btn-outline-dark container-fluid rounded-1"href="/admin-panel/see-auth-letter/?staff-id=<?php echo $pendingRequest[$i]["staff_id"] ?>">Authorization Pdf</a>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    $i = 0;
                    if (!isset($pendingRequest[$i])) {
                        ?>
                        <div class="p-5 mb-4 m-5  bg-body-tertiary rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="mb-5">No Pending Request</h1>
                                <p class="col-md-8 fs-4"></p>
                                <button class="btn btn-info btn-lg text-white rounded-1" type="button">No Pending</button>
                            </div>
                        </div>
                        <?php
                    }
                } else if ($_REQUEST["status"] == "accepted") {
                    ?>
                        <h1 class="display-5 text-center">Accepted Accommodation</h1>
                        <!-- <hr> -->
                        <?php
                        $accom = new accommodation();
                        $acceptedRequest = $accom->getAcceptedAccom();
                        $i = 0;
                        while (isset($acceptedRequest[$i])) {
                            $staffdetails = $accom->getStaffDetails($acceptedRequest[$i]["staff_id"] );

                            ?>
                            <div class="card m-3" style="width: 20rem;">
                                <img style="width:200px;height:150px"
                                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwIDMwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LDIyICBWNGgxOHYxOGMwLDIuMjA5LTEuNzkxLDQtNCw0IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48cGF0aCBkPSJNMTcsMjIgIEwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxNSIgeDI9IjIxIiB5MT0iMTMiIHkyPSIxMyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSIxMyIgeTI9IjEzIi8+PGxpbmUgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6IzAwMDAwMDtzdHJva2Utd2lkdGg6MjtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MTA7IiB4MT0iMTUiIHgyPSIyMSIgeTE9IjE3IiB5Mj0iMTciLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxMSIgeDI9IjEzIiB5MT0iMTciIHkyPSIxNyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjE1IiB4Mj0iMjEiIHkxPSI5IiB5Mj0iOSIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSI5IiB5Mj0iOSIvPjxwYXRoIGQ9Ik0xNywyMkwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6Ii8+PC9zdmc+"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Accepted Summary</h5>
                                   <b>
                                    <?php echo $acceptedRequest[$i]["staff_name"] ?> </b>From the Department of <b>
                                    <?php echo $staffdetails['department'] ?></b> Had booked an accommodation From <b>
                                    <?php echo $acceptedRequest[$i]["accom_check_in_date"] ?> </b> To Date <b>
                                    <?php echo $acceptedRequest[$i]["accom_check_out_date"] ?> </b> <hr> 
                                    Total Students : <b>
                                    <?php echo $acceptedRequest[$i]["no_of_male_student"]+$acceptedRequest[$i]["no_of_female_student"]  ?></b> <br> Total Staff :  <b><?php echo$acceptedRequest[$i]["no_of_male_staff"]+$acceptedRequest[$i]["no_of_female_staff"]?></b>
                                    </p>
                                    <button class="btn btn-success container-fluid mb-2  rounded-1">This is Accepted</button>
                                    <a class="btn btn-outline-dark container-fluid rounded-1" href="../see-auth-letter/?staff-id=<?php echo $acceptedRequest[$i]["staff_id"]; ?>">See Authorization Pdf</a>

                                    <a class="btn btn-orange container-fluid text-white mt-2  rounded-1" href="../see-bill-info/?staff-id=<?php echo $acceptedRequest[$i]["staff_id"]; ?>">Bill Summary</a>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        $i = 0;
                        if (!isset($acceptedRequest[$i])) {
                            ?>
                            <div class="p-5 mb-4 m-5  bg-body-tertiary rounded-3">
                                <div class="container-fluid py-5">
                                    <h1 class="mb-5">No Accepted Request</h1>
                                    <p class="col-md-8 fs-4"></p>
                                    <button class="btn btn-success btn-lg text-white  rounded-1" type="button">No Accept</button>
                                </div>
                            </div>
                        <?php
                        }
                } else if ($_REQUEST["status"] == "declined") {
                    ?>
                            <h1 class="display-5 text-center">Declined Accommodation</h1>
                            <!-- <hr> -->
                        <?php
                        $accom = new accommodation();
                        $declinedRequest = $accom->getDeclinedAccom();
                        $i = 0;
                        while (isset($declinedRequest[$i])) {
                            if (isset($declinedRequest[$i])) {
                                $staffdetails = $accom->getStaffDetails($declinedRequest[$i]["staff_id"] );
                                ?>
                                    <div class="card m-3" style="width: 20rem;">
                                        <img style="width:200px;height:150px"
                                            src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwIDMwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LDIyICBWNGgxOHYxOGMwLDIuMjA5LTEuNzkxLDQtNCw0IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48cGF0aCBkPSJNMTcsMjIgIEwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxNSIgeDI9IjIxIiB5MT0iMTMiIHkyPSIxMyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSIxMyIgeTI9IjEzIi8+PGxpbmUgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6IzAwMDAwMDtzdHJva2Utd2lkdGg6MjtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MTA7IiB4MT0iMTUiIHgyPSIyMSIgeTE9IjE3IiB5Mj0iMTciLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxMSIgeDI9IjEzIiB5MT0iMTciIHkyPSIxNyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjE1IiB4Mj0iMjEiIHkxPSI5IiB5Mj0iOSIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSI5IiB5Mj0iOSIvPjxwYXRoIGQ9Ik0xNywyMkwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6Ii8+PC9zdmc+"
                                            class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">Declined Summary</h5>
                                            <b>
                                    <?php echo $declinedRequest[$i]["staff_name"] ?> </b>From the Department of <b>
                                    <?php echo $staffdetails['department'] ?></b> Had booked an accommodation From <b>
                                    <?php echo $declinedRequest[$i]["accom_check_in_date"] ?> </b> To Date <b>
                                    <?php echo $declinedRequest[$i]["accom_check_out_date"] ?> </b> <hr> 
                                    Total Students : <b>
                                    <?php echo $declinedRequest[$i]["no_of_male_student"]+$declinedRequest[$i]["no_of_female_student"]  ?></b> <br> Total Staff :  <b><?php echo $declinedRequest[$i]["no_of_male_staff"]+$declinedRequest[$i]["no_of_female_staff"]?></b>
                                    </p>
                                            <button href="#" class="btn btn-danger container-fluid mb-2  rounded-1">This is Declined</button>

                                        </div>
                                    </div>
                                <?php
                                $i++;

                            } 

                        }$i = 0;
                        if (!isset($declinedRequest[$i])) {
                            ?>
                            <div class="p-5 mb-4 m-5  bg-body-tertiary rounded-3">
                                <div class="container-fluid py-5">
                                    <h1 class="mb-5">No Declined Request</h1>
                                    <p class="col-md-8 fs-4"></p>
                                    <button class="btn btn-danger btn-lg text-white  rounded-1" type="button">No Decline</button>
                                </div>
                            </div>
                        <?php
                        }
                        
                }
                ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <main>
            <div class="container py-4">
                <h3 class="display-5 text-center fw-bold">Accommodation</h3>
                <header class="pb-3 mb-4 border-bottom">
                    <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">

                        <!-- <span class="fs-4">Hey Welcome . . . </span> -->
                    </a>
                </header>
                <br>
                <br>
                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Accepted Status</h1>
                        <p class="col-md-8 fs-5">By clicking the below button you can see accepted accommodation</p>
                        <a class="btn btn-outline-dark btn-lg rounded-1" href="/admin-panel/accommodation/?status=accepted" style="width: 150px;"
                            type="button">Check</a>
                    </div>
                </div>

                <div class="row align-items-md-stretch">
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 text-bg-dark rounded-3">
                            <h2>Declined Status</h2>
                            <p class="col-md-8 fs-5">By clicking the below button you can see declined accommodation</p>
                            <a href="/admin-panel/accommodation/?status=declined" class="btn btn-outline-light rounded-1"
                                style="width: 150px;">Check</a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                            <h2>Pending Status</h2>
                            <p class="col-md-8 fs-5">By clicking the below button you can see pending accommodation</p>
                            <a href="/admin-panel/accommodation/?status=pending" class="btn btn-outline-dark rounded-1" style="width: 150px;"
                                type="button">Check</a>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php
    }
    ?>





    <script src="/js-files/script-2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>