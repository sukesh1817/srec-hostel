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
    <title>gate pass details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sharp {
            border-radius: 1px;
        }

        .sharp::after {
            border-radius: 1px;
        }
    </style>
    <script src="/js-files/action-pass.js"></script>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
    ?>
</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
    ?>
    <?php
    /*
this below code will retrive the token details of the students whoare booked the token
*/
    ?>


    <div class="bg-light-subtle">
        <main>
            <div class="container">

                <br>
                <br>
                <form action="/admin-panel/gate-pass/search/" method="POST">
                    <div class="d-flex justify-content-center ">
                        <div class="w-50">
                            <h1 class="text-center display-6">Search filters</h1>
                            <select class="form-select mb-1 sharp" name="status" aria-label="Default select example"
                                required>
                                <option value="">Pass Status</option>
                                <option value="pending" <?php if (isset($_REQUEST["status"])) {
                                    $a = $_REQUEST["status"];
                                    if ($a == "pending") {
                                        echo "selected";
                                    }
                                } ?>>Pending</option>
                                <option value="accepted" <?php if (isset($_REQUEST["status"])) {
                                    $a = $_REQUEST["status"];
                                    if ($a == "accepted") {
                                        echo "selected";
                                    }
                                } ?>>Accepted</option>

                            </select>

                            <select id="pass-type" class="form-select container-fluid mb-1 sharp" name="pass-type"
                                aria-label="Default select example" required>
                                <option value="">Pass Type</option>
                                <option value="gate-pass" <?php if (isset($_REQUEST["pass-type"])) {
                                    $a = $_REQUEST["pass-type"];
                                    if ($a == "gate-pass") {
                                        echo "selected";
                                    }
                                } ?>><strong>Gate pass</strong></option>
                                <option value="home-pass" <?php if (isset($_REQUEST["pass-type"])) {
                                    $a = $_REQUEST["pass-type"];
                                    if ($a == "home-pass") {
                                        echo "selected";
                                    }
                                } ?>><strong>Home pass</strong></option>
                                <option value="working-day-pass" <?php if (isset($_REQUEST["pass-type"])) {
                                    $a = $_REQUEST["pass-type"];
                                    if ($a == "working-day-pass") {
                                        echo "selected";
                                    }
                                } ?>><strong>Working Day Pass</strong></option>
                            </select>
                            <?php
                            if (isset($_POST['hostel'])) {
                                ?>
                                <input id='which-hostel' type='hidden' name='hostel' value=<?php echo $_POST['hostel']; ?>>
                                <?php
                            }
                            ?>

                            <select class="form-select mb-1 sharp" name="which-dept" aria-label="Default select example"
                                required>
                                <option value="">Department</option>
                                <option value="B.Tech AIDS" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.Tech AIDS") {
                                        echo "selected";
                                    }
                                } ?>>B.Tech AIDS</option>
                                <option value="B.Tech IT" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.Tech IT") {
                                        echo "selected";
                                    }
                                } ?>>B.Tech IT</option>
                                <option value="B.E MECH" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E MECH") {
                                        echo "selected";
                                    }
                                } ?>>B.E MECH</option>

                                <option value="B.E ECE" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E ECE") {
                                        echo "selected";
                                    }
                                } ?>>B.E ECE</option>

                                <option value="B.E EEE" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E EEE") {
                                        echo "selected";
                                    }
                                } ?>>B.E EEE</option>
                                <option value="B.E EIE" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E EIE") {
                                        echo "selected";
                                    }
                                } ?>>B.E EIE</option>
                                <option value="B.E CSE" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E CSE") {
                                        echo "selected";
                                    }
                                } ?>>B.E CSE</option>
                                <option value="M.Tech CSE" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "M.Tech CSE") {
                                        echo "selected";
                                    }
                                } ?>>M.Tech CSE</option>
                                <option value="B.E RA" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E RA") {
                                        echo "selected";
                                    }
                                } ?>>B.E RA</option>
                                <option value="B.E AERO" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E AERO") {
                                        echo "selected";
                                    }
                                } ?>>B.E AERO</option>
                                <option value="B.E BME" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E BME") {
                                        echo "selected";
                                    }
                                } ?>>B.E BME</option>
                                <option value="B.E CIVIL" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E CIVIL") {
                                        echo "selected";
                                    }
                                } ?>>B.E CIVIL</option>
                                <option value="B.E MBA" <?php if (isset($_REQUEST["which-dept"])) {
                                    $a = $_REQUEST["which-dept"];
                                    if ($a == "B.E MBA") {
                                        echo "selected";
                                    }
                                } ?>>B.E MBA</option>
                            </select>

                            <select id="year-type" class="form-select container-fluid mb-1 sharp" name="year" required>
                                <option value="">year</option>
                                <?php
                                if (isset($_POST["hostel"])) {
                                    $a = $_POST["hostel"];
                                    if ($a == "Mens-1") {
                                        ?>
                                        <option value="2" <?php if (isset($_REQUEST["year"])) {
                                            $a = $_REQUEST["year"];
                                            if ($a == "2") {
                                                echo "selected";
                                            }
                                        } ?>><strong>2</strong></option>

                                        <option value="3" <?php if (isset($_REQUEST["year"])) {
                                            $a = $_REQUEST["year"];
                                            if ($a == "3") {
                                                echo "selected";
                                            }
                                        } ?>><strong>3</strong></option>
                                        <?php
                                    } else if ($a == "Mens-2") {
                                        ?>
                                            <option value="1" <?php if (isset($_REQUEST["year"])) {
                                                $a = $_REQUEST["year"];
                                                if ($a == "1") {
                                                    echo "selected";
                                                }
                                            } ?>><strong>1</strong></option>

                                            <option value="4" <?php if (isset($_REQUEST["year"])) {
                                                $a = $_REQUEST["year"];
                                                if ($a == "4") {
                                                    echo "selected";
                                                }
                                            }
                                    }
                                } ?>><strong>4</strong></option>

                            </select>







                            <button type="submit" class="btn btn-dark container-fluid sharp"
                                data-mdb-ripple-init>search</button>
                        </div>
                    </div>
                </form>

                <?php
                if (
                    isset($_REQUEST["pass-type"]) and
                    isset($_REQUEST["which-dept"]) and
                    isset($_REQUEST["status"])
                    and isset($_POST['hostel']) and
                    isset($_POST['year'])


                ) {
                    $row = [];
                    include_once $_SERVER["DOCUMENT_ROOT"] . '/../class-files/' . "pass.class.php";
                    $pass = new Pass_class();
                    $dept = $_REQUEST["which-dept"];
                    if ($_REQUEST["pass-type"] == "gate-pass") {
                        $row = $pass->getAllGatePass($_REQUEST["status"], $dept, $_POST['hostel'], $_POST['year']);
                    } else if ($_REQUEST["pass-type"] == "home-pass") {
                        $row = $pass->getAllHomePass($_REQUEST["status"], $dept, $_POST['hostel'], $_POST['year']);
                    } else if ($_REQUEST["pass-type"] == "working-day-pass") {
                        $row = $pass->getAllWorkingDayPass($_REQUEST["status"], $dept, $_POST['hostel'], $_POST['year']);
                    }
                    $i = 0;
                    ?>
                    <div class="container-flu mt-2">

                        <table class="table">
                            <?php
                            if (isset($row[$i])) {
                                ?>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Roll No</th>
                                        <th>Department</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Address</th>
                                        <th>Reason
                                        <th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <?php
                            }
                            ?>

                            <tbody>
                                <?php
                                while (isset($row[$i])) {


                                    ?>


                                    <tr id="<?php echo $row[$i]['roll_no']; ?>">
                                        <td>
                                            <?php
                                            echo $row[$i]['stud_name']
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $row[$i]['roll_no']
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $row[$i]['department']
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            $date = $row[$i]['time_of_leave'];
                                            echo date('d-m-Y  h:i:s A ', strtotime($date));

                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            $date = $row[$i]['time_of_entry'];
                                            echo date('d-m-Y  h:i:s A ', strtotime($date));

                                            ?>
                                        </td>


                                        <td>
                                            <?php
                                            echo $row[$i]["address_name"];
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo $row[$i]["reason"];
                                            ?>
                                        <td>


                                        <td>
                                            <?php
                                            if ($_REQUEST["status"] == "pending") {
                                                ?>

                                                <button id="<?php echo $row[$i]['roll_no']; ?>-1"
                                                    class="btn btn-success rounded-1 btn-sm mark-it"><small>accept</small></button>
                                                <br>

                                                <button id="<?php echo $row[$i]['roll_no']; ?>-0"
                                                    class="btn btn-danger rounded-1 btn-sm mt-1 mark-it"><small>decline</small></button>
                                                <?php
                                            } else if ($_REQUEST["status"] == "accepted") {
                                                ?>
                                                    <?php

                                                    ?>
                                                    <button class="btn btn-success rounded-1 btn-sm"><small>accepted by
                                                        <?php echo $row[$i]['accepted_by'] ?></small></button>
                                                <?php
                                            }
                                            ?>
                                        </td>


                                    </tr>

                                    <?php
                                    $i++;
                                }
                }
                ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <div id='warning'>
            <?php
            if (isset($_POST['hostel'])) {
                if ($_POST['hostel'] == 'Mens-1') {
                    ?>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Who is this ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                </div>
                                <div class="modal-body">
                                    Please tell who is this to authorize the student ?
                                </div>
                                <div class="modal-footer">
                                    <button id="Poovaiah" type="button" class="btn btn-dark rounded-1 warden"
                                        data-bs-dismiss="modal">Poovaiah</button>
                                    <button id="Balagopi" type="button" class="btn btn-dark rounded-1 warden"
                                        data-bs-dismiss="modal">Bala gopi</button>
                                    <button id="Dinesh" type="button" class="btn btn-dark rounded-1 warden"
                                        data-bs-dismiss="modal">Dinesh</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                } else if ($_POST['hostel'] == 'Mens-2') {
                    ?>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Who is this ?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body">
                                        Please tell who is this to authorize the student ?
                                    </div>
                                    <div class="modal-footer">
                                        <button id="Suresh" type="button" class="btn btn-dark rounded-1 warden"
                                            data-bs-dismiss="modal">Suresh</button>
                                        <button id="Manivel" type="button" class="btn btn-dark rounded-1 warden"
                                            data-bs-dismiss="modal">Manivel</button>
                                        <button id="Navaneethan" type="button" class="btn btn-dark rounded-1 warden"
                                            data-bs-dismiss="modal">Navaneethan</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</body>


<!-- <script src="/jsFiles/script-2.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>


</html>