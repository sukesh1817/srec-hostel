<body class="noto-sans">
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";
    ?>
    <?php
    /*
    this below code get the accomodation status of the authorized person from the database,
    and show the status of the accomodation (pending,accepted,declined)
    */
    ?>

    <?php
    if (isset($_SESSION['yourToken'])) {


        include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/accommodation.class.php";
        $id = $_SESSION["yourToken"];
        $accom = new accommodation();
        $result = $accom->checkAccomStatus($id);

    ?>
        <div class="container mt-6">
            <div class="row d-flex justify-content-center">
                <h1 class="display-6 text-center mt-3">Order History</h1>
                <hr>
                <div class="card m-3" style="width: 20rem;">
                    <img style="width:200px;height:100px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwIDMwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LDIyICBWNGgxOHYxOGMwLDIuMjA5LTEuNzkxLDQtNCw0IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48cGF0aCBkPSJNMTcsMjIgIEwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxNSIgeDI9IjIxIiB5MT0iMTMiIHkyPSIxMyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSIxMyIgeTI9IjEzIi8+PGxpbmUgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6IzAwMDAwMDtzdHJva2Utd2lkdGg6MjtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MTA7IiB4MT0iMTUiIHgyPSIyMSIgeTE9IjE3IiB5Mj0iMTciLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxMSIgeDI9IjEzIiB5MT0iMTciIHkyPSIxNyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjE1IiB4Mj0iMjEiIHkxPSI5IiB5Mj0iOSIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSI5IiB5Mj0iOSIvPjxwYXRoIGQ9Ik0xNywyMkwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6Ii8+PC9zdmc+" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Your Summary</h5>
                        <p class="card-text">
                            <?php
                            if ($result == "pending") {
                                echo "Your Order Is In Pending State";
                            } else if ($result == "declined") {
                                echo "Your Order Is Declined";
                            } else if ($result == "accepted") {
                                echo "Your Order Is Accepted";
                            } else {
                                echo "You Have No Orders";
                            }
                            ?>
                        </p>
                        <button class="btn btn-outline-<?php
                                                        if ($result == "pending") {
                                                            echo "info";
                                                        } else if ($result == "declined") {
                                                            echo "danger";
                                                        } else if ($result == "accepted") {
                                                            echo "success";
                                                        } else {
                                                            echo "dark";
                                                        }
                                                        ?> container-fluid mb-2 text-capitalize rounded-1">
                            <?php
                            echo $result;
                            ?>
                        </button>
                        <?php
                        if ($result == "declined") {
                                echo "<a href='/api/clear-accomy/' class='container-fluid btn btn-dark rounded-1'>clear accommodation</a>";
                            }
                        ?>
                        <?php
                        if ($result == "accepted") {
                            $data = $accom->getMyData($_SESSION['yourToken']);
                            $totalPeople = $data['no_of_male_student'] + $data['no_of_female_student'] + $data['no_of_male_staff'] + $data['no_of_female_staff'];
                            $totalRoom = $data['no_of_male_student_room'] + $data['no_of_female_student_room'] + $data['no_of_female_staff_room'] + $data['no_of_male_staff_room'];
                            if (isset($data["staff_id"])) {
                        ?>
                                <!-- <form action="/makePdf/" method="get"> -->

                                <a id="bill-summary" href="/staff-panel/accommodation/download-bill-info/" class="container-fluid btn btn-outline-dark rounded-1">Download Bill
                                </a>
                                <!-- </form> -->
                    </div>
                </div>
                <div class="card m-3" style="width: 20rem;">
                    <img style="width:200px;height:100px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwIDMwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LDIyICBWNGgxOHYxOGMwLDIuMjA5LTEuNzkxLDQtNCw0IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48cGF0aCBkPSJNMTcsMjIgIEwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxNSIgeDI9IjIxIiB5MT0iMTMiIHkyPSIxMyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSIxMyIgeTI9IjEzIi8+PGxpbmUgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6IzAwMDAwMDtzdHJva2Utd2lkdGg6MjtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MTA7IiB4MT0iMTUiIHgyPSIyMSIgeTE9IjE3IiB5Mj0iMTciLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxMSIgeDI9IjEzIiB5MT0iMTciIHkyPSIxNyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjE1IiB4Mj0iMjEiIHkxPSI5IiB5Mj0iOSIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSI5IiB5Mj0iOSIvPjxwYXRoIGQ9Ik0xNywyMkwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6Ii8+PC9zdmc+" class="card-img-top img-fluid" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Order information</h5>
                        <?php
                                $totalPeople = $data['no_of_male_student'] + $data['no_of_female_student'] + $data['no_of_male_staff'] + $data['no_of_female_staff'];
                                $totalRoom = $data['no_of_male_student_room'] + $data['no_of_female_student_room'] + $data['no_of_female_staff_room'] + $data['no_of_male_staff_room'];
                        ?>
                        <p class="card-text">Total Members : <?php echo $totalPeople; ?></p>
                        <p class="card-text">Total Rooms : <?php echo $totalRoom; ?></p>
                        <p class="card-text">Check in date : <?php echo $data['accom_check_in_date']; ?></p>
                        <p class="card-text">Check out date : <?php echo $data['accom_check_out_date']; ?></p>

                    </div>
                </div>
            <?php
                            }
                        } else if ($result == "pending") {
                            $data = $accom->getMyPendingData($_SESSION['yourToken']);
            ?>
            <a class="btn btn-dark container-fluid mb-2 rounded-1" href="/staff-panel/accommodation/see-auth-letter/">Authorization Pdf</a>
            <a id="bill-summary" href="/staff-panel/accommodation/edit-accommodation/" class="container-fluid btn btn-outline-dark">Edit values</a>
            </div>
        </div>
        <?php
                            // print_r($data)

        ?>


        <div class="card m-3" style="width: 20rem;">
            <img style="width:200px;height:100px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwIDMwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMzAgMzAiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LDIyICBWNGgxOHYxOGMwLDIuMjA5LTEuNzkxLDQtNCw0IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48cGF0aCBkPSJNMTcsMjIgIEwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6IiBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxNSIgeDI9IjIxIiB5MT0iMTMiIHkyPSIxMyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSIxMyIgeTI9IjEzIi8+PGxpbmUgc3R5bGU9ImZpbGw6bm9uZTtzdHJva2U6IzAwMDAwMDtzdHJva2Utd2lkdGg6MjtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MTA7IiB4MT0iMTUiIHgyPSIyMSIgeTE9IjE3IiB5Mj0iMTciLz48bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojMDAwMDAwO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHgxPSIxMSIgeDI9IjEzIiB5MT0iMTciIHkyPSIxNyIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjE1IiB4Mj0iMjEiIHkxPSI5IiB5Mj0iOSIvPjxsaW5lIHN0eWxlPSJmaWxsOm5vbmU7c3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjI7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEwOyIgeDE9IjExIiB4Mj0iMTMiIHkxPSI5IiB5Mj0iOSIvPjxwYXRoIGQ9Ik0xNywyMkwxNywyMkg0bDAsMGMwLDIuMjA5LDEuNzkxLDQsNCw0aDEzQzE4Ljc5MSwyNiwxNywyNC4yMDksMTcsMjJ6Ii8+PC9zdmc+" class="card-img-top img-fluid" alt="...">
            <div class="card-body">
                <h5 class="card-title">Order information</h5>
                <?php
                            $totalPeople = $data['no_of_male_student'] + $data['no_of_female_student'] + $data['no_of_male_staff'] + $data['no_of_female_staff'];
                            $totalRoom = $data['no_of_male_student_room'] + $data['no_of_female_student_room'] + $data['no_of_female_staff_room'] + $data['no_of_male_staff_room'];
                ?>
                <p class="card-text">Total Members : <?php echo $totalPeople; ?></p>
                <p class="card-text">Total Rooms : <?php echo $totalRoom; ?></p>
                <p class="card-text">Check in date : <?php echo $data['accom_check_in_date']; ?></p>
                <p class="card-text">Check out date : <?php echo $data['accom_check_out_date']; ?></p>

            </div>
        </div>

    <?php
                        }

    ?>


<?php
    }
?>
</body>