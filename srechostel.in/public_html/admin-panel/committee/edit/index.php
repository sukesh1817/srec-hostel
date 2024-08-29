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
    <title>Add new members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container-form,
        .img,
        .form,
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }



        .container-form {
            width: 700px;
            height: 400px;
            background: white;
            position: relative;
            display: grid;
            grid-template: 100%/50% 50%;
            box-shadow: 2px 2px 10px 0 rgba(51, 51, 51, 0.2);
        }

        .img {
            background-image: url("/images/layout-image/complaint.jpg") !important;
            position: absolute;
            width: 50%;
            height: 100%;
            transition: 0.5s all ease;
            transform: translateX(100%);
            z-index: 4;
        }

        .img:before {
            position: absolute;
            content: "";
            width: 1px;
            height: 70%;
            background: #c3c3d8;
            opacity: 0;
            left: 0;
            top: 15%;
        }



        .img-container-form:before {
            opacity: 0.3;
            left: 0;
        }

        .login:before {
            opacity: 0.3;
            left: 100%;
        }

        .btn-wrapper {
            width: 60%;
        }

        .form {
            width: 100%;
            height: 100%;
        }

        .form--heading {
            font-size: 25px;
            height: 50px;
            color: black;
        }

        .form--committe {
            border-right: 1px solid #999;
        }

        form {
            width: 70%;
        }

        form>* {
            margin: 10px;
        }

        form input {
            width: 90%;
            height: 50%;
            border: 0;
            border-bottom: 1px solid #aaa;
            color: #797a9e;
        }

        form select {
            width: 90%;
            height: 50%;
            border: 0;
            border-bottom: 1px solid #aaa;
            color: black;
        }

        form input::placeholder {
            color: black;
        }

        form input:focus {
            outline: 0;
            border-bottom: 1px solid rgba(128, 155, 206, 0.7);
            transition: 0.6s all ease;
        }

        form select:focus {
            outline: 0;
            border-bottom: 1px solid rgba(128, 155, 206, 0.7);
            transition: 0.6s all ease;
        }

        option {
            border-radius: 1px;
        }

        .button {
            width: 90%;
            border-radius: 1px;
            outline: 0;
            color: white;
            font-size: 15px;
            font-weight: 400;
            position: relative;
            cursor: pointer;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
    ?>

</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
    ?>

    <div class="container-form mx-auto mt-4">
        <div class="img img-container-form">

        </div>
        <div class="form form--committe">
            <div class="form--heading">Welcome, Fill the form !</div>
            <form id="form-committee" type="POST" autocomplete="on">
                <input class="text-dark" type="number" id="roll_no" placeholder="Roll no starts with 2" required>
                <select name="which-committe" id="which_committee" required>
                    <option class="text-dark" value="" selected>Which committe</option>
                    <option value="sports">Sports</option>
                    <option value="library">Library</option>
                    <option value="garden">Garden</option>
                    <option value="wifi">Wifi</option>
                </select>
                <button class="btn btn-dark button">check and submit</button>
            </form>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <div id="toast-icon">

                </div>
            </div>
            <div id="toast-message" class="toast-body">

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="/js-files/committee/add.js"></script>
</body>

</html>