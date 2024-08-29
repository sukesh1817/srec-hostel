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
    <title>Committee Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .cont-committe {
            max-width: 960px;
        }

        .committee-header {
            max-width: 700px;
        }

        :root {
            --red: hsl(0, 78%, 62%);
            --dark: hsl(0, 0%, 0%);
            --light: hsl(0, 0%, 100%);
            --cyan: hsl(145, 62%, 55%);
            --orange: hsl(34, 97%, 64%);
            --blue: hsl(212, 86%, 64%);
            --varyDarkBlue: hsl(234, 12%, 34%);
            --grayishBlue: hsl(229, 6%, 66%);
            --veryLightGray: hsl(0, 0%, 98%);
            --weight1: 200;
            --weight2: 400;
            --weight3: 600;
        }

        body {
            font-size: 15px;
            background-color: var(--veryLightGray);
        }

        .attribution {
            font-size: 11px;
            text-align: center;
        }

        .attribution a {
            color: hsl(228, 45%, 44%);
        }

        h1:first-of-type {
            font-weight: var(--weight1);
            color: var(--varyDarkBlue);
        }

        h1:last-of-type {
            color: var(--varyDarkBlue);
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 1.5rem;
            }
        }

        .header {
            text-align: center;
            line-height: 0.8;
            margin-bottom: 50px;
            margin-top: 100px;
        }

        .header p {
            margin: 0 auto;
            line-height: 2;
            color: var(--grayishBlue);
        }

        .box p {
            color: var(--grayishBlue);
        }

        .box {
            border-radius: 5px;
            box-shadow: 0px 30px 40px -20px var(--grayishBlue);
            padding: 30px;
            margin: 20px;
        }

        img {
            float: right;
        }

        @media (max-width: 450px) {
            .box {
                height: 200px;
            }
        }

        @media (max-width: 950px) and (min-width: 450px) {
            .box {
                /* text-align: center; */
                height: 125px;
            }
        }

        .cyan {
            border-top: 3px solid var(--cyan);
        }

        .dark {
            border-top: 3px solid var(--dark);

        }

        .light {
            border-top: 3px solid var(--light);

        }

        .red {
            border-top: 3px solid var(--red);
        }

        .blue {
            border-top: 3px solid var(--blue);
        }

        .orange {
            border-top: 3px solid var(--orange);
        }

        h2 {
            color: var(--varyDarkBlue);
            font-weight: var(--weight3);
        }

        @media (min-width: 950px) {
            .row1-container {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .row2-container {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .box-down {
                position: relative;
                top: 150px;
            }

            .box {
                width: 20%;
            }

            .header p {
                width: 30%;
            }
        }
    </style>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
    ?>
</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/committe.class.php";

    $committee = new Committe_class();

    $sports = $committee->GetCommitteMember("sports");
    $food = $committee->GetCommitteMember("garden");
    $library = $committee->GetCommitteMember("library");
    $wifi = $committee->GetCommitteMember("wifi");


    ?>
    <div class="header">
        <h1>Welcome to Committee Details.</h1>
        <h1>See the members of the committee.</h1>

        <p class="w-75">committee is dedicated to enhancing the academic and social environment of our hos. We are a
            team
            of
            passionate individuals who work tirelessly to organize events, support student initiatives, and foster a
            sense of community</p>
    </div>
    <div class="1st-year">
        <h2 class="text-center">I Year</h2>
        <div class="row1-container">

            <div class="box box-down dark">
                <h2>Sports</h2>
                <p>
                    <?php
                    if (isset($sports[3])) {
                        print_r("<strong>".$sports[3]['name']."</strong> From the department of <strong> ".$sports[3]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?>
                </p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/sport.png" alt="">
            </div>

            <div class="box dark">
                <h2>Library</h2>
                <p> <?php
                    if (isset($library[3])) {
                        print_r("<strong>".$library[3]['name']."</strong> From the department of <strong> ".$library[3]['department']."</strong>");
                    }else {
                        echo "Member not found";
                    }
                    
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/library.png" alt="">
            </div>

            <div class="box box-down dark">
                <h2>Garden</h2>
                <p> <?php
                    if (isset($food[3])) {
                        print_r("<strong>".$food[3]['name']."</strong> From the department of <strong> ".$food[3]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/diet.png" alt="">
            </div>
        </div>
        <div class="row2-container">
            <div class="box dark">
                <h2>Wifi</h2>
                <p><?php
                    if (isset($wifi[3])) {
                        print_r("<strong>".$wifi[3]['name']."</strong> From the department of <strong> ".$wifi[3]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/wifi.png" alt="">
            </div>
        </div>
    </div>


    <div class="b-example-divider">
        <hr>
    </div>

    <div class="2nd-year">
        <h2 class="text-center">2nd Year</h2>
        <div class="row1-container">
            <div class="box box-down dark">
                <h2>Sports</h2>
                <p>
                    <?php
                     if (isset($sports[2])) {
                        print_r("<strong>".$sports[2]['name']."</strong> From the department of <strong> ".$sports[2]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?>
                </p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/sport.png" alt="">
            </div>

            <div class="box dark">
                <h2>Library</h2>
                <p> <?php
                    if (isset($library[2])) {
                        print_r("<strong>".$library[2]['name']."</strong> From the department of <strong> ".$library[2]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/library.png" alt="">
            </div>

            <div class="box box-down dark">
                <h2>Garden</h2>
                <p> <?php
                    if (isset($food[2])) {
                        print_r("<strong>".$food[2]['name']."</strong> From the department of <strong> ".$food[2]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/diet.png" alt="">
            </div>
        </div>
        <div class="row2-container">
            <div class="box dark">
                <h2>Wifi</h2>
                <p><?php
                    if (isset($wifi[2])) {
                        print_r("<strong>".$wifi[2]['name']."</strong> From the department of <strong> ".$wifi[2]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/wifi.png" alt="">
            </div>
        </div>
    </div>

    <div class="b-example-divider">
        <hr>
    </div>

    <div class="3rd-year">
        <h2 class="text-center">3rd Year</h2>
        <div class="row1-container">
            <div class="box box-down dark">
                <h2>Sports</h2>
                <p>
                    <?php
                    if (isset($sports[1])) {
                        print_r("<strong>".$sports[1]['name']."</strong> From the department of <strong> ".$sports[1]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?>
                </p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/sport.png" alt="">
            </div>

            <div class="box dark">
                <h2>Library</h2>
                <p> <?php
                    if (isset($library[1])) {
                        print_r("<strong>".$library[1]['name']."</strong> From the department of <strong> ".$library[1]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/library.png" alt="">
            </div>

            <div class="box box-down dark">
                <h2>Garden</h2>
                <p> <?php
                    if (isset($food[1])) {
                        print_r("<strong>".$food[1]['name']."</strong> From the department of <strong> ".$food[1]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/diet.png" alt="">
            </div>
        </div>
        <div class="row2-container">
            <div class="box dark">
                <h2>Wifi</h2>
                <p><?php
                    if (isset($wifi[1])) {
                        print_r("<strong>".$wifi[1]['name']."</strong> From the department of <strong> ".$wifi[1]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/wifi.png" alt="">
            </div>
        </div>
    </div>


    <div class="b-example-divider">
        <hr>
    </div>

    <div class="4td-year">
        <h2 class="text-center">4th Year</h2>
        <div class="row1-container">
            <div class="box box-down dark">
                <h2>Sports</h2>
                <p>
                    <?php
                    if (isset($sports[0])) {
                        print_r("<strong>".$sports[0]['name']."</strong> From the department of <strong> ".$sports[0]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?>
                </p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/sport.png" alt="">
            </div>

            <div class="box dark">
                <h2>Library</h2>
                <p>
                    <?php
                    if (isset($library[0])) {
                        print_r("<strong>".$library[0]['name']."</strong> From the department of <strong> ".$library[0]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?>
                </p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/library.png" alt="">
            </div>

            <div class="box box-down dark">
                <h2>Garden</h2>
                <p> <?php
                    if (isset($food[0])) {
                        print_r("<strong>".$food[0]['name']."</strong> From the department of <strong> ".$food[0]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/diet.png" alt="">
            </div>
        </div>
        <div class="row2-container">
            <div class="box dark">
                <h2>Wifi</h2>
                <p><?php
                    if (isset($wifi[0])) {
                        print_r("<strong>".$wifi[0]['name']."</strong> From the department of <strong> ".$wifi[0]['department']."</strong>");
                    } else {
                        echo "Member not found";
                    }
                    ?></p>
                <img style="width: 45px;height:45px;" src="/images/committee-icons/wifi.png" alt="">
            </div>
        </div>
    </div>





</body>

</html>