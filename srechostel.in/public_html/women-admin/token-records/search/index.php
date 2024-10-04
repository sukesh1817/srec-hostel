<?php
/*
this code checks wheather the person is admin or not,
if admin allow them ,
else do not allow them
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
    </style>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
    ?>
</head>

<body class="noto-sans">

    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
    ?>
    <div class="container mt-2 text-center">

        <?php
        if (isset($_POST['hostel'])) {
            echo "<h3 class='text-center'>" . $_POST['hostel'] . '</h3>';
        }
        ?>
        <div class="dropdown d-inline-block">
            <button class="btn btn-dark rounded-1 dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Search by
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" data-bs-target="#staticBackdrop">
                <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Room no</a>
                    <ul class="dropdown-menu">
                        <input class="d-inline-block py-2 border border-dark rounded-1 mx-1" type="number"
                            placeholder="Enter room no" name="room-no" id="roomNo">
                        <p class="text-center"> <a id="add-room"
                                class="in container-fluid mx-1 btn btn-dark btn-sm mt-3">set</a>
                        </p>

                    </ul>
                </li>
                <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Department</a>
                    <ul class="dropdown-menu">
                        <li><a id="dept-ai" class="dropdown-item i" href="#">B.Tech AIDS</a></li>
                            <li><a id="dept-it" class="dropdown-item i" href="#">B.Tech IT</a></li>
                            <li><a id="dept-ece" class="dropdown-item i" href="#">B.E ECE</a></li>
                            <li><a id="dept-eee" class="dropdown-item i" href="#">B.E EEE</a></li>
                            <li><a id="dept-mech" class="dropdown-item i" href="#">B.E MECH</a></li>
                             <li><a id="dept-bme" class="dropdown-item i" href="#">B.E BME</a></li>
                            <li><a id="dept-metch" class="dropdown-item i" href="#">M.Tech CSE</a></li>
                            <li><a id="dept-civil" class="dropdown-item i" href="#">B.E CIVIL</a></li>
                            <li><a id="dept-aero" class="dropdown-item i" href="#">B.E AERO</a></li>
                            <li><a id="dept-ra" class="dropdown-item i" href="#">B.E RA</a></li>
                            <li><a id="dept-cse" class="dropdown-item i" href="#">B.E CSE</a></li>
                            <li><a id="dept-eie" class="dropdown-item i" href="#">B.E EIE</a></li>
                            <li><a id="dept-mba" class="dropdown-item i" href="#">B.E MBA</a></li>

                    </ul>
                </li>
            </ul>
        </div>

        <form id="search-form" action="/admin-panel/token-records/search/" method="post"
            class="mt-3 d-inline-block text-center">
            <input type="hidden" name="room-no" id="roomValue" value="<?php
            if (isset($_POST['room-no'])) {
                echo $_POST['room-no'];
            }


            ?>">
            <input type="hidden" name="department" id="departmentValue" value="<?php
            if (isset($_POST['department'])) {
                echo $_POST['department'];
            }


            ?>">
            <input type="hidden" name="hostel" value="<?php if (isset($_POST['hostel'])) {
                echo $_POST['hostel'];
            } ?>">
            <div class="card p-man d-inline-flex">
                <div class="card-body p-man d-flex align-items-center">

                    <p class="card-text mb-0 p-man">
                        <span id="selectedRoom">Room no - <?php
                        if (isset($_POST['room-no'])) {
                            echo $_POST['room-no'];
                        } else {
                            echo "NULL";
                        }


                        ?></span>
                        <button type="button" id="removeRoom" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-circle mb-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </button>
                    </p>
                    <p class="card-text mb-0 ms-3">
                        <span id="selectedDepartment">Department - <?php
                        if (isset($_POST['department'])) {
                            echo $_POST['department'];
                        } else {
                            echo "NULL";
                        }


                        ?></span>
                        <button type="button" id="removeDepartment" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-circle mb-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </button>
                    </p>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-dark mt-3 " id="submitButton" disabled>Search</button>
        </form>
    </div>
    <?php
    /*
this below code will retrive the token details of the students whoare booked the token
*/
    ?>


    <div class="bg-light-subtle">
        <main>
            <div class="container py-4">

                <?php
                if (isset($_POST["department"])) {
                    $totalTuesday = 0;
                    $totalWednesday = 0;
                    $totalThursday = 0;
                    $totalSunday = 0;

                    function dateCalc()
                    {
                        $day = date("l");
                        $nextTuesday = "";
                        if ($day == "Tuesday") {
                            $date = strtotime("+7 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        } else if ($day == "Wednesday") {
                            $date = strtotime("+6 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        } else if ($day == "Thursday") {
                            $date = strtotime("+5 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        } else if ($day == "Saturday") {
                            $date = strtotime("+3 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        } else if ($day == "Sunday") {
                            $date = strtotime("+2 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        } else if ($day == "Monday") {
                            $date = strtotime("+1 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        } else if ($day == "Friday") {
                            $date = strtotime("+4 day", strtotime(date("Y-m-d")));
                            $nextTuesday = date("Y-m-d", $date);
                        }
                        $date = strtotime("+1 day", strtotime($nextTuesday));
                        $nextWednesday = date("Y-m-d", $date);

                        $date = strtotime("+1 day", strtotime($nextWednesday));
                        $nextThursday = date("Y-m-d", $date);

                        $date = strtotime("+3 day", strtotime($nextThursday));
                        $nextSunday = date("Y-m-d", $date);

                        return array($nextTuesday, $nextWednesday, $nextThursday, $nextSunday);
                    }
                    $nextDate = dateCalc();
                    include_once $_SERVER["DOCUMENT_ROOT"] . '/' . '../class-files/' . "connection.class.php";
                    $conn = new Connection();
                    $sqlConn = $conn->returnConn();
                    if (isset($_POST['room-no'])) {
                        if (($_POST['room-no']) > 0) {
                            $roomNo = $_POST['room-no'];
                            $department = $_POST['department'];
                            $sqlQuery = "SELECT roll_no FROM stud_personal_details WHERE room_no=$roomNo and department='$department';";
                            $result = $sqlConn->query($sqlQuery);
                            if ($result) {
                                while ($sam = $result->fetch_assoc()) {
                                    $row[] = $sam;
                                }
                            }
                        } else {
                            $department = $_POST['department'];
                            $sqlQuery = "SELECT roll_no FROM stud_personal_details WHERE department='$department';";
                            $result = $sqlConn->query($sqlQuery);

                            if ($result) {

                                while ($sam = $result->fetch_assoc()) {
                                    $row[] = $sam;

                                }
                            }

                        }

                    }
                    $i = 0;
                    ?>
                    <div class="container m-3">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Roll No</th>
                                    <!-- <th>Department</th> -->
                                    <th><small>Tuesday <br> <?php print ($nextDate[0]) ?></small></th>
                                    <th><small>Wednesday <br><?php print ($nextDate[1]) ?></small></th>
                                    <th><small>Thursday <br> <?php print ($nextDate[2]) ?></small></th>
                                    <th><small>Sunday <br><?php print ($nextDate[3]) ?></small></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while (isset($row[$i]['roll_no'])) {
                                    $rollNo = $row[$i]['roll_no'];
                                    $sqlQuery = "SELECT * FROM stud_details WHERE roll_no='$rollNo';";
                                    $sqlQuery2 = "SELECT * FROM token_system_backup WHERE roll_no='$rollNo';";
                                    if ($sqlConn->query($sqlQuery)) {
                                        $result1 = $sqlConn->query($sqlQuery);
                                        $result2 = $sqlConn->query($sqlQuery2);
                                        while ($sam = $result1->fetch_assoc() and $jam = $result2->fetch_assoc()) {


                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $sam["name"] ?>
                                                </td>
                                                <td>
                                                    <?php echo $sam["roll_no"] ?>
                                                </td>
                                                <!-- <td> -->
                                                <?php //echo $sam["department"] ?>
                                                <!-- </td> -->
                                                <td>
                                                    <?php


                                                    if ($jam['token_booked'] == 1) {
                                                        if ($jam['tuesday_token_count'] == 0) {
                                                            echo "<p class='btn btn-success' id='".$jam['roll_no'].'-tuesday_status'."'>".$jam['tuesday_token_count']."</p>";

                                                        } else {
                                                        $status = $jam['tuesday_status'];
                                                        if($status==1){
                                                            echo "<p class='btn btn-success' id='".$jam['roll_no'].'-tuesday_status'."'>".$jam['tuesday_token_count']."</p>";
                                                        } else if($status==0){
                                                            echo "<p class='btn btn-info unmarked-token' id='".$jam['roll_no'].'-tuesday_status'."'>".$jam['tuesday_token_count']."</p>";
                                                        }
                                                            
                                                        }

                                                        $totalTuesday += $jam["tuesday_token_count"];
                                                    }  else {
                                                        echo "<p class='btn btn-danger' id='".$jam['roll_no'].'-tuesday_status'."'>"."0"."</p>";

                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $a = $jam["wednesday_token_count"];
                                                    if ($jam['token_booked'] == 1) {
                                                        if ($jam['wednesday_token_count'] == 0) {
                                                                    echo "<p class='btn btn-success' id='".$jam['roll_no'].'-wednesday_status'."'>".$jam['wednesday_token_count']."</p>";

                                                        } else {
                                                        
                                                            $status = $jam['wednesday_status'];
                                                            if($status==1){
                                                                 echo "<p class='btn btn-success' id='".$jam['roll_no'].'-wednesday_status'."'>".$jam['wednesday_token_count']."</p>";
                                                            } else if($status==0){
                                                                echo "<p class='btn btn-info unmarked-token' id='".$jam['roll_no'].'-wednesday_status'."'>".$jam['wednesday_token_count']."</p>";
                                                            }
                                                            

                                                        }
                                                        $totalWednesday += $jam["wednesday_token_count"];
                                                    } else {
                                                    echo "<p class='btn btn-danger' id='".$jam['roll_no'].'-wednesday_status'."'>"."0"."</p>";

                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $a = $jam["thursday_token_count"];
                                                    if ($jam['token_booked'] == 1) {
                                                        if ($jam['thursday_token_count'] == 0) {
                                                             echo "<p class='btn btn-success' id='" . $jam['roll_no'] . '-thursday_status' . "'>" . $jam['thursday_token_count'] . "</p>";

                                                        } else {
                                                              $status = $jam['thursday_status'];
                                                            if($status==1){
                                                                echo "<p class='btn btn-success' id='" . $jam['roll_no'] . '-thursday_status' . "'>" . $jam['thursday_token_count'] . "</p>";
                                                            }
                                                            else if($status==0){
                                                                echo "<p class='btn btn-info unmarked-token' id='" . $jam['roll_no'] . '-thursday_status' . "'>" . $jam['thursday_token_count'] . "</p>";
                                                            }

                                                           

                                                        }
                                                        $totalThursday += $jam["thursday_token_count"];
                                                    }  else {
                                                 echo "<p class='btn btn-danger' id='" . $jam['roll_no'] . '-thursday_status' . "'>" ."0". "</p>";

                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $a = $jam["sunday_token_count"];
                                                    if ($jam['token_booked'] == 1) {
                                                        if ($jam['sunday_token_count'] == 0) {
                                                        echo "<p class='btn btn-success' id='" . $jam['roll_no'] . '-sunday_status' . "'>" . $jam['sunday_token_count'] . "</p>";
                                                        } else {
                                                        $status = $jam['sunday_status'];
                                                        if($status==1){
                                                            echo "<p class='btn btn-success' id='" . $jam['roll_no'] . '-sunday_status' . "'>" . $jam['sunday_token_count'] . "</p>";
                                                        } else if($status==0){
                                                            echo "<p class='btn btn-info unmarked-token' id='" . $jam['roll_no'] . '-sunday_status' . "'>" . $jam['sunday_token_count'] . "</p>";
                                                        }
                                                            
                                                        }

                                                        $totalSunday += $jam["sunday_token_count"];
                                                    } else {
                                                echo "<p class='btn btn-danger' id='" . $jam['roll_no'] . '-sunday_status' . "'>" ."0". "</p>";

                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                    if ($jam['token_booked'] == 1) {
                                                        $rollNo= $jam['roll_no'];

                                                        if ($jam['sunday_token_count'] == "0" and $jam['tuesday_token_count'] == "0" and $jam['thursday_token_count'] == "0" and $jam['wednesday_token_count'] == "0") {
                                                            echo '<span id="'.$rollNo.'"  class="btn btn-success btn-sm rounded-4">skiped</span>';

                                                        }  else if( ($jam['tuesday_status']=="1" or $jam['tuesday_token_count']==0) and ($jam['wednesday_status']=="1"or $jam['wednesday_token_count']==0) and ($jam['thursday_status']=="1"or $jam['thursday_token_count']==0) and ($jam['sunday_status']=="1"or $jam['sunday_token_count']==0)){
                                                                        echo '<span id="'.$rollNo.'" class="btn btn-success btn-sm rounded-4">all marked</span>';

                                                        }
                                                        else if($jam['tuesday_status']=="0" and $jam['wednesday_status']=="0" and $jam['thursday_status']=="0" and $jam['sunday_status']=="0"){
                                                            echo "<span id='" . $sam['roll_no'] . "' class='btn btn-info btn-sm rounded-4'>unmarked</span>";

                                                        }
                                                        else if(!($jam['tuesday_status']=="1" and $jam['wednesday_status']=="1" and $jam['thursday_status']=="1" and $jam['sunday_status']=="1")){
                                                                        echo '<span id="'.$rollNo.'" class="btn btn-info btn-sm rounded-4">partially marked</span>';

                                                        }
                                                        
                                                       
                                
        
                                                        
                                                    } else if ($jam['token_booked'] == 0) {
                                                        echo '<span id="'.$rollNo.'" class="btn btn-danger btn-sm rounded-4">not booked</span>';
                                                    } 
                                                    ?>
                                                </td>
                                            </tr>




                                            <?php
                                        }
                                    }
                                    $i++;
                                }
                                ?>
                                <br>
                                <tr>
                                    <?php



                                    ?>

                                    <!-- <td></td> -->
                                    <td>Total Count : </td>
                                    <td></td>
                                    <td id="tuesday-count"><?php echo $totalTuesday; ?></td>
                                    <td id="wednesday-count"><?php echo $totalWednesday; ?></td>
                                    <td id="thursday-count"><?php echo $totalThursday; ?></td>
                                    <td id="sunday-count"><?php echo $totalSunday; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }



                ?>



                <?php

                ?>


                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Warning message</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Please give the valid value
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <script>

                </script>

            </div>
        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="/js-files/token-mark.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        let departmentSelected = false;

        // Toggle nested submenu on click
        $('.dropdown-submenu .dropdown-toggle').on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $submenu = $(this).next('.dropdown-menu');
            if ($submenu.hasClass('show')) {
                $submenu.removeClass('show');
            } else {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
                $submenu.toggleClass('show');
            }
        });

        // Close all dropdowns on click outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown-menu').length) {
                $('.dropdown-menu .show').removeClass('show');
            }
        });

        // Update hidden inputs and check if both selections are made
        $('.i').on('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior
            const value = $(this).text();
            if ($(this).closest('.dropdown-submenu').find('.dropdown-toggle').text().trim() === "Department") {
                $('#departmentValue').val(value);
                $('#selectedDepartment').text(`Department - ${value}`);
                departmentSelected = true;
            }

            // Enable submit button if both year and department are selected
            if (departmentSelected) {
                $('#submitButton').prop('disabled', false);
            }
        });

        $('.in').on('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior
            const value = $('#roomNo').val();
            if ($(this).closest('.dropdown-submenu').find('.dropdown-toggle').text().trim() === "Department") {
                $('#roomValue').val(value);
                $('#selectedRoom').text(`Room No - ${value}`);
            }
            if (value > 0) {
                $('#selectedRoom').text(`Room No - ${value}`);
                $('#roomValue').val(value);
            } else {

                $('#exampleModal').modal('show');

            }
        });

        // Remove year selection
        $('#removeRoom').on('click', function () {
            $('#roomValue').val('');
            $('#selectedRoom').text('Room no - NULL');
            roomSelected = false;
        });

        // Remove department selection
        $('#removeDepartment').on('click', function () {
            $('#departmentValue').val('');
            $('#selectedDepartment').text('Department - NULL');
            departmentSelected = false;
            $('#submitButton').prop('disabled', true);
        });
        departmentSelected = false;
        var dept = $('#departmentValue').val();
        if (dept == 'AI&DS' || dept == 'IT' || dept == 'MECH' || dept == 'ECE' || dept == 'EEE') {
            departmentSelected = true;
        }
        if (departmentSelected) {
            $('#submitButton').prop('disabled', false);
        }


    });
</script>



</html>