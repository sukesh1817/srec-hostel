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
 
 <div class="container mt-5">
    <h2 class="mb-4">Entry logs</h2>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Approved by Warden</th>
                    <th>Approved by Watchman</th>
                    <th>Approval Time (Warden)</th>
                    <th>Entry Time (Watchman)</th>
                    <th>Status</th>
                    <th>Year of Study</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example of dynamically populated rows -->
                <tr>
                    <td>1234567</td>
                    <td>John Doe</td>
                    <td>Computer Science</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>2024-10-18 10:30:00</td>
                    <td>2024-10-18 12:00:00</td>
                    <td>Approved</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>7654321</td>
                    <td>Jane Smith</td>
                    <td>Electrical Engineering</td>
                    <td>No</td>
                    <td>No</td>
                    <td>--</td>
                    <td>--</td>
                    <td>Pending</td>
                    <td>2</td>
                </tr>
                <!-- More rows can be added dynamically here -->
            </tbody>
        </table>
    </div>
</div>



    


   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>





</body>

</html>