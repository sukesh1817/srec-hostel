<?php
// check the login user is women admin or not.
require_once $_SERVER['DOCUMENT_ROOT'] . '/is-women-admin.php';
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
    </style>

    <style>
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
    </style>



</head>

<body class="noto-sans">


    <?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
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
    </div>

    <div class="bg-light-subtle py-4">
        <div class="container mt-2 text-center">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <form id="search-form" action="/student-details/" method="post" class="mb-4">
                        <div class="mb-3">
                            <select class="form-select" id="yearSelect" name="year" aria-label="Select Year">
                                <option selected disabled>Choose Year</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select class="form-select" id="departmentSelect" name="department"
                                aria-label="Select Department">
                                <option selected disabled>Choose Department</option>
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
                            <input type="hidden" name="year" id="yearValue">
                            <input type="hidden" name="department" id="departmentValue">
                            <div class="input-group">
                                <input type="text" id="searchQueryInput" class="form-control"
                                    placeholder="Search by name, rollno" aria-label="Search">
                                <ul id="myUL" class="dropdown-menu scrollable-dropdown"
                                    style="display: none; position: absolute; width: 100%; z-index: 1000;">
                                </ul>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
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
                            <button id="single-btn" type="button" class="btn btn-outline-dark btn-sm"
                                data-bs-toggle="collapse" data-bs-target="#collapseSingle" aria-expanded="false"
                                aria-controls="collapseSingle" onclick="toggleForms('collapseSingle')">Single user
                                delete</button>
                            <button id="multi-btn" type="button" class="btn btn-outline-dark btn-sm"
                                data-bs-toggle="collapse" data-bs-target="#collapseMulti" aria-expanded="false"
                                aria-controls="collapseMulti" onclick="toggleForms('collapseMulti')">Multi user
                                delete</button>
                        </div>

                        <div class="collapse multi-collapse" id="collapseSingle">
                            <div class="container mt-3 ms-3">
                                <div class="form-container">
                                    <div class="logo-container">Single account delete</div>
                                    <form id="single-form" class="form">
                                        <div class="form-group mb-3">
                                            <label for="user_id">Roll no</label>
                                            <input type="number" id="user_id" name="user_id"
                                                placeholder="Enter the roll no" required="">
                                        </div>
                                        <button class="btn btn-dark rounded-1" type="submit">Delete user</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="collapse multi-collapse" id="collapseMulti">
                            <div class="container mt-3 ms-3">
                                <div class="form-container">
                                    <div class="logo-container">Multi account delete</div>
                                    <div class="form">
                                        <div class="filter-container">
                                            <label for="filterType">Select The Filter</label>
                                            <select id="filterType" onchange="toggleInputFields()">
                                                <option value="rollNumbers">Roll Numbers</option>
                                                <option value="departmentYear">Department & Year</option>
                                                <option value="yearOnly">Year Only</option>
                                            </select>

                                            <form id="roll-nos-form" method="post">
                                                <div id="rollNumbersInput" class="filter-input">
                                                    <label class="mt-1" for="rollNumber">Enter Roll Number</label>
                                                    <input class="rounded-1" type="text" id="rollNumber"
                                                        placeholder="Enter Roll Number">

                                                    <div class="btn-group mt-2 container-fluid" role="group"
                                                        aria-label="Default button group">
                                                        <button class="btn btn-dark container-fluid rounded-start-1"
                                                            onclick="addRollNumber()" type="button">Add Roll
                                                            Number</button>
                                                        <button
                                                            class="btn btn-outline-dark container-fluid rounded-end-1"
                                                            type="submit">Delete
                                                            users</button>
                                                    </div>

                                                    <div class="error-message mt-2" id="rollNumberError">Please enter a
                                                        valid
                                                        roll number.</div>

                                                    <div id="rollnoList" class="rollno-list"></div>
                                                    <input type="hidden" id="rollNumbers" name="rollNumbers">
                                                </div>
                                            </form>

                                            <form id="dept-year-form" method="post">
                                                <div id="departmentYearInput" class="filter-input">
                                                    <label class="mt-1" for="dept_group">Select Department</label>
                                                    <select id="dept_group">
                                                        <option value="AIDS">AIDS</option>
                                                        <option value="CSC">CSC</option>
                                                        <option value="IT">IT</option>
                                                    </select>
                                                    <label class="mt-1" for="year_group">Year</label>
                                                    <select id="year_group">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                    <button class="btn btn-dark mt-2 container-fluid rounded-1"
                                                        type="submit">Delete
                                                        users</button>

                                                    <div class="error-message mt-2" id="departmentYearError">Please
                                                        enter
                                                        valid department and year.</div>
                                                </div>
                                            </form>

                                            <form id="year-form" method="post">
                                                <div id="yearOnlyInput" class="filter-input">
                                                    <label class="mt-1" for="year_only">Select Year</label>
                                                    <select id="year_only">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                    <button class="btn btn-dark mt-2 container-fluid rounded-1"
                                                        type="submit">Delete
                                                        users</button>
                                                    <div class="error-message mt-2" id="yearOnlyError">Please enter a
                                                        valid
                                                        year.</div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="toast-success" class="toast toast-success">Success! Your account has been successfully
                    deleted.</div>
                <div id="toast-error" class="toast toast-error">Error! There was a problem deleting your account.
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <p class="text-center">
        <button style="display: none;" id="downloadButton" class="btn btn-warning mt-3">Download as XLSX</button>

        </p>
        <table id="myTable" style="display: none;" class="table table-striped">
            <thead>
                <tr>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Year</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Data will be inserted here -->
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
        $('#searchQueryInput').on('keyup', function () {
            const suggestionsList = $('#myUL');
            suggestionsList.show()
            let query = $(this).val();
            if (query.length > 0) {
                <?php //included the orginal domain ?>
                domain = "<?php echo $domain ?>"

                $.ajax({
                    url: domain + '/api/admin/search_student/',
                    type: 'GET',
                    data: { query: query },
                    crossDomain: true,
                    success: function (response) {
                        const suggestionsList = $('#myUL');
                        const students = response['data'];
                        suggestionsList.empty();
                        students.forEach((student, index) => {
                            let suggestionItem = $(`
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                                <div>
                                    <strong>${student.name}</strong><br>
                                    <small>Department: ${student.department}</small><br>
                                    <small>Roll No: ${student.roll_no}</small>
                                </div>
                                <a href="show-more/?roll_no=${student.roll_no}" class="btn btn-link">Show More</a>
                            </li>
                        `);

                            // Append the suggestion item to the list
                            suggestionsList.append(suggestionItem);

                            // Append <hr> for all except the last item
                            if (index < students.length - 1) {
                                suggestionsList.append('<hr>');
                            }
                        });

                        // Show dropdown if there are suggestions
                        if (students.length > 0) {
                            $('#myUL').removeClass('d-none'); // Show dropdown
                        } else {
                            $('#myUL').addClass('d-none'); // Hide dropdown if no suggestions
                        }
                    },
                    error: function () {
                        console.error('Error fetching suggestions');
                    }
                });



            } else {
                $('#suggestionsDropdown').addClass('d-none'); // Hide dropdown if input is empty
            }
        });
    })
</script>





<script>
    $(document).ready(function () {
        $('#departmentSelect').change(function () {
            $("#myTable").show()
            $("#downloadButton").show()
            <?php //included the orginal domain ?>
            domain = "<?php echo $domain ?>"
            const selectedDepartment = $(this).val(); // Get selected department value

            // Make an AJAX request
            $.ajax({
                url: domain + '/api/admin/search_student/', // Replace with your endpoint
                type: 'POST',
                data: { department: selectedDepartment },
                success: function (data) {
                    $('#myTable tbody').empty();
                    console.log(data)
                    // Check if data is returned
                    if (data.length > 0) {
                        // Loop through the data and append rows to the table
                        data.forEach(item => {
                            $('#myTable tbody').append(`
                        <tr>
                            <td>${item.roll_no}</td>
                            <td>${item.name}</td>
                            <td>${item.department}</td>
                            <td>${item.year_of_study}</td>
                            <!-- Add more columns as needed -->
                        </tr>
                    `);
                        });
                    } else {
                        // If no data, show a message
                    $('#myTable tbody').append(`
                    <tr>
                        <td colspan="4" class="text-center text-danger">No records found.</td>
                    </tr>
                `);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                }
            });
        });
    });
</script>


<script>
    document.getElementById("downloadButton").addEventListener("click", function () {
        // Get the table and its rows
        var table = document.getElementById("myTable"); // Replace with your table ID
        var data = [];

        // Iterate through the rows of the table
        for (var i = 0; i < table.rows.length; i++) {
            var row = [];
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                row.push(table.rows[i].cells[j].innerText.trim()); // Get text content of each cell
            }
            data.push(row); // Add the row to the data array
        }

        // Create a new workbook and a worksheet
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(data);

        // Append the worksheet to the workbook
        XLSX.utils.book_append_sheet(wb, ws, "Students");

        // Generate XLSX file and trigger download
        XLSX.writeFile(wb, "students_data.xlsx");
    });
</script>
</html>