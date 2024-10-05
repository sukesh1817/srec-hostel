<?php
// check the login user is women admin or not.
require_once $_SERVER['DOCUMENT_ROOT'] . '/is-women-admin.php';
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate pass</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <?php
    // included the poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: 0;
            margin-left: .1rem;
            display: none;
            /* Hide by default */
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
            /* Show on hover */
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

        .form-container input,
        select {
            width: 100%;
            padding: 12px 16px;
            border-radius: 1px;
            font-family: inherit;
            border: 1px solid #ccc;
        }

        .form-container input::placeholder,
        select::placeholder {
            opacity: 0.5;
        }

        .form-container input:focus,
        select:focus {
            outline: none;
            border-color: #1778f2;
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

        .filter-container label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        /* .filter-container input, .filter-container select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    } */

        .filter-input {
            display: none;
        }

        .filter-input.active {
            display: block;
        }

        .rollno-list {
            margin-top: 15px;
        }

        .rollno-card {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }




        .error-message {
            color: #ff6b6b;
            background-color: #fce8e8;
            border: 1px solid #ff6b6b;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
            display: none;
            /* Hide by default */
        }

        .error-message.active {
            display: block;
            /* Show if error is active */
        }

        .scrollable-dropdown {
            max-height: 350px;
            /* Set maximum height for the dropdown */
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: hidden;
            /* Disable horizontal scrolling */
            border: 1px solid #ccc;
            /* Optional: border for the dropdown */
            border-radius: 0.25rem;
            /* Optional: rounded corners */
            background-color: white;
            /* Optional: background color */
        }

        .dropdown-menu {
            margin: 0;
            /* Remove default margins */
            padding: 0;
            /* Remove default padding */
            list-style-type: none;
            /* Remove default list styling */
        }

        .dropdown-menu li {
            padding: 10px;
            /* Padding for each item */
            cursor: pointer;
            /* Change cursor to pointer */
        }

        .dropdown-menu li:hover {
            background-color: #f1f1f1;
            /* Change background color on hover */
        }

        .scrollable-dropdown {
            max-height: 350px;
            /* Set maximum height for the dropdown */
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: hidden;
            /* Disable horizontal scrolling */
            border: 1px solid #ccc;
            /* Optional: border for the dropdown */
            border-radius: 0.25rem;
            /* Optional: rounded corners */
            background-color: white;
            /* Optional: background color */
        }
    </style>



</head>

<body>


    <?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
    ?>
    <div class="float-end mx-3 my-3">
        <a href="/gate-pass/logs/" class="btn btn-sm btn-dark rounded-1" data-bs-toggle="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pass"
                viewBox="0 0 16 16">
                <path d="M5.5 5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z" />
                <path
                    d="M8 2a2 2 0 0 0 2-2h2.5A1.5 1.5 0 0 1 14 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-13A1.5 1.5 0 0 1 3.5 0H6a2 2 0 0 0 2 2m0 1a3 3 0 0 1-2.83-2H3.5a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-1.67A3 3 0 0 1 8 3" />
            </svg>
            Logs
        </a>
        </span>
    </div>

    <div class="bg-light-subtle py-4">
        <div class="container mt-2 text-center">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <form method="post" class="mb-4">
                        <div class="mb-3">
                            <select class="form-select rounded-1" id="yearSelect" name="year" aria-label="Select Year">
                                <option selected disabled value="NULL">Choose Year</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select class="form-select rounded-1" id="departmentSelect" name="department"
                                aria-label="Select Department">
                                <option selected disabled value="NULL">Choose Department</option>
                                <option value="B.Tech AIDS">B.Tech AIDS</option>
                                <option value="B.Tech IT">B.Tech IT</option>
                                <option value="B.E ECE">B.E ECE</option>
                                <option value="B.E EEE">B.E EEE</option>
                                <option value="B.E MECH">B.E MECH</option>
                                <option value="B.E BME">B.E BME</option>
                                <option value="M.Tech CSE">M.Tech CSE</option>
                                <option value="B.E CIVIL">B.E CIVIL</option>
                                <option value="B.E AERO">B.E AERO</option>
                                <option value="B.E RA">B.E RA</option>
                                <option value="B.E CSE">B.E CSE</option>
                                <option value="B.E EIE">B.E EIE</option>
                                <option value="B.E MBA">B.E MBA</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <select class="form-select rounded-1" id="passStatus" name="passStatus"
                                aria-label="Select pass status">
                                <option selected disabled value="NULL">Choose status of pass</option>
                                <option value="1">Accepted</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select class="form-select rounded-1" id="passType" name="passType"
                                aria-label="Select pass type">
                                <option selected disabled value="NULL">Choose type of pass</option>
                                <option value="1">Out pass</option>
                                <option value="2">General home pass</option>
                                <option value="3">Working day pass</option>
                            </select>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="container mt-4">
        <table id="myTable" style="display: none;" class="table table-striped">
            <thead>
                <tr id="dynamicHeaderRow">
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>


            </tbody>
        </table>
    </div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>



<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../config/' . "domain.php";
?>



<script>
    $(document).ready(function () {
        function fetchPassData() {
            // Get form values
            const passType = $('#passType').val();
            const passStatus = $('#passStatus').val();
            const department = $('#departmentSelect').val();
            const year = $('#yearSelect').val();

            const domain = "<?php echo $domain ?>"

            // Only send the request if all fields have been selected
            if (passType && passStatus) {
                // Prepare the AJAX request
                $.ajax({
                    url: domain + '/api/admin/manage_pass_request/get_student_pass/index.php', // Replace with the actual path to your PHP file
                    type: 'GET',
                    data: {
                        pass_type: passType,
                        pass_status: passStatus,
                        department: department,
                        year: year
                    },
                    dataType: 'json',
                    success: function (data) {
                        // Handle success
                        let output = '';
                        if (passStatus == 0 && data.length > 0) {
                            if (data.error) {
                                output += `<tr><td colspan="5">Error: ${data.error}</td></tr>`;
                            } else {
                                $('#dynamicHeaderRow').find('.dynamic-header').remove();
                                $('#dynamicHeaderRow').append(`<th class="dynamic-header">accept</th>`);
                                $('#dynamicHeaderRow').append(`<th class="dynamic-header">decline</th>`);
                                data.forEach(item => {
                                    output += `<tr>
                                    <td>${item.roll_no}</td>
                                    <td>${item.stud_name}</td>
                                    <td>${item.department}</td>
                                    <td>${item.year_of_study}</td>
                                    <td><button class="btn btn-success btn-sm">Accept</button></td>
                                    <td><button class="btn btn-danger btn-sm">Decline</button></td>
                                </tr>`;
                                });
                            }
                            $('#myTable tbody').html(output);
                            $('#myTable').show();
                        } else if (passStatus == 0 && data.length > 0) {
                            $('#dynamicHeaderRow').find('.dynamic-header').remove();
                            $('#dynamicHeaderRow').append(`<th class="dynamic-header">Status</th>`);
                            if (data.error) {
                                output += `<tr><td colspan="5">Error: ${data.error}</td></tr>`;
                            } else {
                                data.forEach(item => {
                                    output += `<tr>
                                    <td>${item.roll_no}</td>
                                    <td>${item.stud_name}</td>
                                    <td>${item.department}</td>
                                    <td>${item.year_of_study}</td>
                                    <td><button class="btn btn-success btn-sm">${item.accepted_by}</button></td>
                                </tr>`;
                                });
                            }
                            $('#myTable tbody').html(output);
                            $('#myTable').show();
                        } else if (data.length == 0) {
                            $('#myTable tbody').append(`
                        <tr>
                            <td colspan="5" class="text-center text-danger">No records found.</td>
                        </tr>
                    `);
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle errors
                        $('#myTable tbody').html(`<tr><td colspan="5">Error: ${textStatus} - ${errorThrown}</td></tr>`);
                        $('#myTable').show();
                    }
                });
            } else {
                // Clear table if any field is not selected
                $('#myTable tbody').html('');
                $('#myTable').hide();
            }
        }


        $('#yearSelect').on('change', function () {
            fetchPassData();
        });
        $('#departmentSelect').on('change', function () {
            fetchPassData();
        });
        $('#passStatus').on('change', function () {
            fetchPassData();
        });
        $('#passType').on('change', function () {
            fetchPassData();
        });
    });
</script>








</html>