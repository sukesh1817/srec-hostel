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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
    ?>

    <style>
        /* Style the Image Used to Trigger the Modal */
        img {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        img:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        #image-viewer {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-content {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        #image-viewer .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        #image-viewer .close:hover,
        #image-viewer .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
</head>

<body>




    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
    ?>

    <main>
        <?php
        /*
this code retrives the all the type complaint data from the database 
*/
        ?>
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php
                    include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
                    $complaint = new commonClass();
                    $row = $complaint->retriveComplaint("individual_complaint");
                    $row1 = $complaint->retriveComplaint("common_complaint");

                    $i = 0;
                    while (isset($row[$i])) {
                        ?>
                        <div class="col images">
                            <div class="card shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="/pic/complaint.jpg" width="100%"
                                    height="225" role="img" aria-label="Placeholder: Thumbnail"
                                    preserveAspectRatio="xMidYMid slice" focusable="false">
                                <h3 class='ms-2 mt-2'>Complaint Info </h3>
                                <h6 class="ms-2 mt-2">Individual Complaint</h6>
                                <div class="card-body">
                                    <p class="card-text">Name - <strong> <?php echo $row[$i]["stud_name"] ?></strong> <br>
                                        Room No - <strong> <?php echo $row[$i]["room_no"] ?></strong><br>
                                        Department - <strong><?php echo $row[$i]["department"] ?></strong>
                                        <br>
                                        Complaint Date - <strong><?php echo $row[$i]["date_of_complaint"] ?></strong>
                                        <br>
                                        Complaint Summary - <strong><?php echo $row[$i]["complaint_summary"] ?></strong>
                                    </p>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button
                                                src="/admin-panel/evidence-photo/?roll-no=<?php echo $row[$i]["roll_no"] ?>&w=i"
                                                class="btn btn-sm btn-outline-secondary photo">Evidence Photo</button>
                                                <?php
                                                if ($row[$i]["complaint_satisfied"] == 0) {


                                                    ?>
                                                    <a href="/admin-panel/address-complaint/?roll-no=<?php echo $row[$i]["roll_no"] ?>&w=i"
                                                        class="btn btn-sm btn-outline-secondary">Address It</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button class="btn btn-sm btn-success">Complaint Addressed</button>
                                                    <?php
                                                }
                                                ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    $i = 0;
                    while (isset($row1[$i])) {
                        $rollNo = $row1[$i]['roll_no'];
                        ?>
                        <div class="col images">
                            <div class="card shadow-sm ">
                                <img class="bd-placeholder-img card-img-top" src="/pic/complaint.jpg" width="100%"
                                    height="225" role="img" aria-label="Placeholder: Thumbnail"
                                    preserveAspectRatio="xMidYMid slice" focusable="false">
                                <h3 class='ms-2 mt-2'>Complaint Info</h3>
                                <br>
                                <h6 class="ms-2">Common Complaint</h6>
                                <div class="card-body">
                                    Department - <strong> <?php echo $row1[$i]["department"] ?></strong>
                                    <br>
                                    Date - <strong><?php echo $row1[$i]["date_of_complaint"] ?></strong>
                                    <br>
                                    Complaint Summary - <strong><?php echo $row1[$i]["complaint_summary"] ?></strong>
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button src="/admin-panel/evidence-photo/?roll-no=<?php echo $rollNo ?>&w=c"
                                                class="btn btn-sm btn-outline-secondary photo">Evidence Photo</button>
                                                <?php if ($row1[$i]["complaint_satisfied"] == 0) {
                                                    ?>
                                                    <a href="/admin-panel/address-complaint/?roll-no=<?php echo $rollNo ?>&w=c"
                                                        class="btn btn-sm btn-outline-secondary">Address It</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button class="btn btn-sm btn-success">Complaint Addressed</button>
                                                    <?php
                                                }
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>



                </div>
            </div>
        </div>

    </main>
    <div id="image-viewer">
        <span class="close">&times;</span>
        <img class="modal-content" id="full-image">
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(".images .photo").click(function () {
            $("#full-image").attr("src", $(this).attr("src"));
            $('#image-viewer').show();
            $(".navbar").hide()
        });

        $("#image-viewer .close").click(function () {
            $('#image-viewer').hide();
            $(".show").hide()
            $(".navbar").show()

        });
    </script>
</body>

</html>