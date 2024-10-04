<?php
// check the login user is student
include_once $_SERVER['DOCUMENT_ROOT'] . "/is-student.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* .avatar {
            background-color: white;
            vertical-align: middle;
            width: 60px;
            height: 60px;
            border-radius: 50px;
            object-fit: cover;
        } */
    </style>
    <style>
        /* .committee-item {
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
        } */
    </style>

    <?php
    // included the poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>

</head>

<body>

    <?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";
    ?>
    <div class="container px-4 py-5" id="hanging-icons">
        <h2 class="pb-2 border-bottom">Committee Member Info</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="col committee-item">
                <div
                    class="text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <img style="width: 60px; height: 60px;" src="/images/committee-icons/diet.png" alt="sa">
                </div>
                <div class="committee-content">
                    <h3 class="fs-3 text-body-emphasis">Food committee</h3>
                    <h2 class="fs-4 text-body-emphasis"><small class="fs-5">Leader -</small> Ajay M | B.Tech IT</h2>
                    <p>We are delighted to welcome you to the Food Committee section of our hostel website! This is
                        where your passion for food and community can come together to make a significant impact on our
                        dining experience.</p>
                    <a href="/stud-panel/committies/food-committiee/" class="btn btn-dark rounded-1 committee-button">
                        current status
                    </a>
                </div>
            </div>
            <div class="col committee-item">
                <div
                    class="text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <img class="avatar" src="/images/committee-icons/sport.png" alt="sa">
                </div>
                <div class="committee-content">
                    <h3 class="fs-3 text-body-emphasis">Sports committee</h3>
                    <h2 class="fs-4 text-body-emphasis"><small class="fs-5">Leader -</small> Anandh L | B.E EIE</h2>
                    <p>
                        We are thrilled to have you join the Sports Committee section of our hostel website! Here, your
                        passion for sports and teamwork will help shape our events, enhancing our community's fitness
                        and camaraderie.
                    </p>
                    <a href="#" class="btn btn-dark rounded-1 committee-button">
                        current status
                    </a>
                </div>
            </div>
            <div class="col committee-item">
                <div
                    class="text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <img style="width: 60px; height: 60px;" src="/images/committee-icons/park.png" alt="sa">
                </div>
                <div class="committee-content">
                    <h3 class="fs-3 text-body-emphasis">Garden committee</h3>
                    <h2 class="fs-4 text-body-emphasis"><small class="fs-5">Leader -</small> Harish R | B.E ECE</h2>
                    <p>Welcome to the Garden Committee section of our hostel website! This is your gateway to
                        contributing to the green spaces of our hostel and making our surroundings more beautiful and
                        sustainable. Your involvement is crucial in fostering a love for nature and enhancing our
                        communal living environment.</p>
                    <a href="#" class="btn btn-dark rounded-1 committee-button">
                        current status
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="col committee-item">
                <div
                    class="text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <img style="width: 60px; height: 60px;" src="/images/committee-icons/wifi.png" alt="sa">
                </div>
                <div class="committee-content">
                    <h3 class="fs-3 text-body-emphasis">Wifi committee</h3>
                    <h2 class="fs-4 text-body-emphasis"><small class="fs-5">Leader -</small> Abishek K | B.E EEE</h2>
                    <p>Welcome to the Wi-Fi Committee section of our hostel website! Here, we focus on ensuring a
                        reliable and efficient internet experience for all hostel residents. Your input and
                        collaboration are essential in helping us maintain and improve our Wi-Fi services.</p>
                    <a href="#" class="btn btn-dark rounded-1 committee-button">
                        current status
                    </a>
                </div>
            </div>
            <div class="col committee-item">
                <div
                    class="text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <img style="width: 60px; height: 60px;" src="/images/committee-icons/library.png" alt="sa">
                </div>
                <div class="committee-content">
                    <h3 class="fs-3 text-body-emphasis">Library committee</h3>
                    <h2 class="fs-4 text-body-emphasis"><small class="fs-5">Leader -</small> Sujith | B.E CSC</h2>
                    <p>Welcome to the Library Committee section of our hostel website! Here, we aim to create a
                        conducive environment for study and research, ensuring that all residents have access to the
                        resources they need for academic success. Your involvement is crucial in maintaining and
                        enhancing our library services.</p>
                    <a href="#" class="btn btn-dark rounded-1 committee-button">
                        current status
                    </a>
                </div>
            </div>
            <div class="col committee-item">
                <div
                    class="text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <img style="width: 60px; height: 60px;" src="/images/committee-icons/broom.png" alt="sa">
                </div>
                <div class="committee-content">
                    <h3 class="fs-3 text-body-emphasis">Cleanliness committee</h3>
                    <h2 class="fs-4 text-body-emphasis"><small class="fs-5">Leader -</small> Balaji J | B.Tech AIDS</h2>
                    <p>Welcome to the Cleanliness Committee section of our hostel website! Here, we focus on maintaining
                        a clean and hygienic environment for all residents. Your participation is vital in promoting
                        good health and a pleasant living atmosphere within the hostel.</p>
                    <a href="#" class="btn btn-dark rounded-1 committee-button">
                        current status
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>