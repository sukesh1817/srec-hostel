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
    <title>Committee Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            /* background-image: linear-gradient(180deg, var(--bs-secondary-bg), var(--bs-body-bg) 100px, var(--bs-body-bg)); */
        }

        .cont-committe {
            max-width: 960px;
        }

        .committee-header {
            max-width: 700px;
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






    <div class="cont-committe container py-3">
        <main class="mt-5">
            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-dark h-100">
                        <div class="card-header py-3 text-bg-dark border-dark">
                            <h4 class="my-0 fw-normal">Members Details</h4>
                        </div>
                        <div class="card-body">
                            <!-- <h1 class="card-title pricing-card-title">$29<small
                                    class="text-body-secondary fw-light">/mo</small></h1> -->
                            <ul class="list-unstyled mt-3 mb-4">
                                <p>Here You can see the details of the committe members.</p>
                            </ul>
                            <a href="/admin-panel/committee/show/"
                                class="w-100 btn btn-lg btn-dark rounded-1 float-end">Show</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm h-100">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Add Members</h4>
                        </div>
                        <div class="card-body">
                            <!-- <h1 class="card-title pricing-card-title">$15<small
                                    class="text-body-secondary fw-light">/mo</small></h1> -->
                            <ul class="list-unstyled mt-3 mb-4">
                                <p>Here You can Edit the committe members.</p>

                            </ul>
                            <a href="/admin-panel/committee/edit/" class="w-100 btn btn-lg btn-dark rounded-1">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-dark h-100">
                        <div class="card-header py-3 text-bg-dark border-dark">
                            <h4 class="my-0 fw-normal">Delete Members</h4>
                        </div>
                        <div class="card-body">
                            <!-- <h1 class="card-title pricing-card-title">$29<small
                                    class="text-body-secondary fw-light">/mo</small></h1> -->
                            <ul class="list-unstyled mt-3 mb-4">
                                <p>Here You can Delete the committe members.</p>

                            </ul>
                            <a href="/admin-panel/committee/delete/" class="w-100 btn btn-lg btn-dark rounded-1">Delete</a>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>



</body>