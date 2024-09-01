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
    <title>Student details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="/css-files/toast.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .btn-outline-light:hover {
            color: black;
        }

        .offcanvas.offcanvas-end {
            width: 800px;
        }

        .form-container {
            max-width: 400px;
            background-color: #fff;
            padding: 32px 24px;
            font-size: 14px;
            font-family: inherit;
            color: #212121;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box;
            border-radius: 1px;
            box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
        }

        .form-container button:active {

            scale: 0.95;
        }

        .form-container .logo-container {
            text-align: center;
            font-weight: 600;
            font-size: 18px;
        }

        .form-container .form {
            display: flex;
            flex-direction: column;
        }

        .form-container .form-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .form-container .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container .form-group input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 1px;
            font-family: inherit;
            border: 1px solid #ccc;
        }

        .form-container .form-group input::placeholder {
            opacity: 0.5;
        }

        .form-container .form-group input:focus {
            outline: none;
            border-color: #1778f2;
        }

        .form-container .form-submit-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: inherit;
            color: #fff;
            background-color: #212121;
            border: none;
            width: 100%;
            padding: 12px 16px;
            font-size: inherit;
            gap: 8px;
            margin: 12px 0;
            cursor: pointer;
            border-radius: 1px;
            box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
        }

        .form-container .form-submit-btn:hover {
            background-color: #313131;
        }

        .form-container .link {
            color: #1778f2;
            text-decoration: none;
        }

        .form-container .signup-link {
            align-self: center;
            font-weight: 500;
        }

        .form-container .signup-link .link {
            font-weight: 400;
        }

        .form-container .link:hover {
            text-decoration: underline;
        }
    </style>




</head>

<body class="noto-sans">


    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
    ?>
    <div class="float-end mx-3 my-3">
        <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-placement="left"
            data-bs-trigger="hover focus" data-bs-content="Want to delete a user click this">
            <button type="button" class="btn btn-sm btn-danger rounded-1" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3"
                    viewBox="0 0 16 16">
                    <path
                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                </svg>
                Delete user
            </button>
        </span>
    </div><br>

    <div class="bg-light-subtle">
        <div class="container">
            <?php
            if (isset($_POST['hostel'])) {
                $hostel = $_POST['hostel'];
                echo "<h3 class='text-center mt-3'>$hostel<h3>";
            }
            ?>
        </div>
        <div class="container mt-2 text-center">
            <div class="dropdown d-inline-block">
                <button class="btn btn-dark rounded-1 dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Search by
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Year</a>
                        <ul class="dropdown-menu">
                            <?php
                            if ($_POST['hostel'] == 'Men-hostel-1') {
                                ?>
                                <li><a id="year-1" class="dropdown-item i" href="#">2</a></li>
                                <li><a id="year-2" class="dropdown-item i" href="#">3</a></li>
                                <?php
                            } else if ($_POST['hostel'] == 'Men-hostel-2') {
                                ?>
                                    <li><a id="year-1" class="dropdown-item i" href="#">1</a></li>
                                    <li><a id="year-2" class="dropdown-item i" href="#">4</a></li>
                                <?php
                            } else {
                                ?>
                                    <li><a id="year-1" class="dropdown-item i" href="#">1</a></li>
                                    <li><a id="year-2" class="dropdown-item i" href="#">2</a></li>
                                    <li><a id="year-3" class="dropdown-item i" href="#">3</a></li>
                                    <li><a id="year-4" class="dropdown-item i" href="#">4</a></li>
                                <?php
                            }
                            ?>

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


            <form id="search-form" action="/admin-panel/stud-details/search/" method="post"
                class="mt-3 d-inline-block text-center">
                <input type="hidden" name="year" id="yearValue" value="<?php
                if (isset($_POST['year'])) {
                    echo $_POST['year'];
                }


                ?>">
                <input type="hidden" name="department" id="departmentValue" value="<?php
                if (isset($_POST['department'])) {
                    echo $_POST['department'];
                }


                ?>">
                <input type="hidden" name="hostel" value="<?php if (isset($_POST['hostel'])) {
                    echo $_POST['hostel'];
                } else {
                    echo "men-hostel-1";
                } ?>">
                <div class="card p-man d-inline-flex">
                    <div class="card-body p-man d-flex align-items-center">

                        <p class="card-text mb-0 p-man">
                            <span id="selectedYear">Year - <?php
                            if (isset($_POST['year'])) {
                                echo $_POST['year'];
                            } else {
                                echo "NULL";
                            }


                            ?></span>
                            <button type="button" id="removeYear" class="btn">
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



        <main>
            <div class="container">



                <?php
                if (isset($_POST["year"]) and isset($_POST['department'])) {
                    include_once $_SERVER["DOCUMENT_ROOT"] . '/' . '../class-files/' . "connection.class.php";
                    $conn = new Connection();
                    $sqlConn = $conn->returnConn();
                    $year = $_POST["year"];
                    $dept = $_POST['department'];
                    $sqlQuery = "SELECT * FROM stud_details WHERE year_of_study=$year and department='$dept';";
                    if ($sqlConn->query($sqlQuery)) {
                        $result = $sqlConn->query($sqlQuery);
                        while ($sam = $result->fetch_assoc()) {
                            $row[] = $sam;
                        }

                    }
                }
                ?>
                <div class="container m-3">

                    <table class="table">

                        <?php
                        $i = 0;
                        if (isset($row[0])) {
                            ?>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Roll No</th>
                                    <th>Department</th>
                                    <th>Year of study</th>
                                    <th>Room No</th>
                                    <th>Personal No</th>
                                    <th>Father No</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <?php
                        }
                        while (isset($row[$i])) {
                            $user_id = $row[$i]['user_id'];
                            $sqlQuery = "SELECT * FROM stud_personal_details WHERE user_id=$user_id;";
                            if ($sqlConn->query($sqlQuery)) {
                                $result = $sqlConn->query($sqlQuery);
                                $row1 = $result->fetch_assoc();
                            }
                            $sqlQuery = "SELECT * FROM stud_gurdian_details WHERE user_id=$user_id;";
                            if ($sqlConn->query($sqlQuery)) {
                                $result = $sqlConn->query($sqlQuery);
                                $row2 = $result->fetch_assoc();
                            }
                            ?>
                            <tr>
                                <td><?php echo $row[$i]["name"] ?></td>
                                <td><?php echo $row[$i]["user_id"] ?></td>
                                <td><?php echo $row[$i]["department"] ?></td>
                                <td><?php echo $row[$i]["year_of_study"] ?></td>
                                <td><?php echo $row1["room_no"] ?></td>
                                <td><?php echo $row1["phone_no"] ?></td>
                                <td><?php echo $row2["father_contact_no"] ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>





    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Account deletion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="btn-group d-flex justify-content-center">
                            <button id="single-btn" type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#collapseSingle" aria-expanded="false" aria-controls="collapseSingle"
                                onclick="toggleForms('collapseSingle')">Single user delete</button>
                            <button id="multi-btn" type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#collapseMulti" aria-expanded="false" aria-controls="collapseMulti"
                                onclick="toggleForms('collapseMulti')">Multi user delete</button>
                        </div>

                        <div class="collapse multi-collapse" id="collapseSingle">
                            <div class="container mt-3 ms-3">
                                <div class="form-container">
                                    <div class="logo-container">Single account delete</div>
                                    <form id="single-form" class="form" >
                                        <div class="form-group">
                                            <label for="user_id">Roll no</label>
                                            <input type="number" id="user_id" name="user_id"
                                                placeholder="Enter the roll no" required="">
                                        </div>
                                        <button class="form-submit-btn" type="submit">Delete user</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="collapse multi-collapse" id="collapseMulti">
                            <div class="container mt-3 ms-3">
                                <div class="form-container">
                                    <div class="logo-container">Multi account delete</div>
                                    <form class="form">
                                        <div class="form-group">
                                            <label for="multi-email">Roll no</label>
                                            <input type="text" id="multi-email" name="multi-email"
                                                placeholder="Enter the roll no" required="">
                                        </div>
                                        <button class="form-submit-btn" type="submit">Delete user</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <div id="toast-success" class="toast toast-success">Success! Your account has been successfully deleted.</div>
                <div id="toast-error" class="toast toast-error">Error! There was a problem deleting your account.</div>
                </div>
            </div>
        </div>
    </div>
   
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="/js-files/api/admin/delete-user-accounts.js"></script>
<script>
    $(document).ready(function () {
        let yearSelected = false;
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
            if ($(this).closest('.dropdown-submenu').find('.dropdown-toggle').text().trim() === "Year") {
                $('#yearValue').val(value);
                $('#selectedYear').text(`Year - ${value}`);
                yearSelected = true;
            } else {
                $('#departmentValue').val(value);
                $('#selectedDepartment').text(`Department - ${value}`);
                departmentSelected = true;
            }

            // Enable submit button if both year and department are selected
            if (yearSelected && departmentSelected) {
                $('#submitButton').prop('disabled', false);
            }
        });

        // Remove year selection
        $('#removeYear').on('click', function () {
            $('#yearValue').val('');
            $('#selectedYear').text('Year - NULL');
            yearSelected = false;
            $('#submitButton').prop('disabled', true);
        });

        //Remove department selection
        $('#removeDepartment').on('click', function () {
            $('#departmentValue').val('');
            $('#selectedDepartment').text('Department - NULL');
            departmentSelected = false;
            $('#submitButton').prop('disabled', true);
        });
        yearSelected = false;
        departmentSelected = false;
        var year = $('#yearValue').val();
        if (year == 1 || year == 2 || year == 3 || year == 4) {
            yearSelected = true;
        }
        var dept = $('#departmentValue').val();
        if (dept == 'AIDS' || dept == 'IT' || dept == 'MECH' || dept == 'ECE' || dept == 'EEE' || dept == 'RA' || dept == 'EIE' || dept == 'AERO' || dept == 'MBA' || dept == 'MTECH' || dept == 'CSE' || dept == 'BME') {
            departmentSelected = true;
        }
        if (yearSelected && departmentSelected) {
            $('#submitButton').prop('disabled', false);
        }


    });

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>

<script>
    function toggleForms(collapseId) {
        const collapseSingle = document.getElementById('collapseSingle');
        const collapseMulti = document.getElementById('collapseMulti');

        if (collapseId === 'collapseSingle') {

            var element = document.getElementById("single-btn");
            var element2 = document.getElementById("multi-btn");
            element.classList.remove("btn-outline-dark");
            element.classList.add("btn-dark");
            element2.classList.remove("btn-dark");
            element2.classList.add("btn-outline-dark");

            if (collapseMulti.classList.contains('show')) {
                collapseMulti.classList.remove('show');
            }
        } else if (collapseId === 'collapseMulti') {
            var element = document.getElementById("multi-btn");
            var element2 = document.getElementById("single-btn");
            element.classList.remove("btn-outline-dark");
            element.classList.add("btn-dark");
            element2.classList.remove("btn-dark");
            element2.classList.add("btn-outline-dark");
            if (collapseSingle.classList.contains('show')) {
                collapseSingle.classList.remove('show');
            }
        }
    }
</script>

</html>