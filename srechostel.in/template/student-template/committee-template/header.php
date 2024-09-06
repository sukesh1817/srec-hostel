<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .avatar {
            background-color: white;
            vertical-align: middle;
            width: 60px;
            height: 60px;
            border-radius: 50px;
            object-fit: cover;
        }
    </style>
    <style>
        .committee-item {
            display: flex;
            align-items: start;
        }

        .committee-content {
            flex: 1;
        }

        .committee-content p {
            margin-bottom: 1rem;
        }

        .committee-button {
            margin-top: 1rem;
        }
    </style>

    <?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";



    ?>
</head>