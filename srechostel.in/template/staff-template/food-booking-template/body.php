

<body>
<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";
  ?>
    <?php
    if (isset($_SESSION['yourToken'])) {
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/food.class.php");
        $food = new Food_class();
        $alreadyBooked = $food->isFoodBooked($_SESSION['yourToken']);
        if ($alreadyBooked) {
            ?>
            <div class="p-5 m-4 bg-body-tertiary rounded-2">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">You Already Booked Food</h1>
                    <p class="col-md-8 fs-4">Please Wait ...</p>
                    <div class="col-width">
                    </div>
                    <a href="/staff-panel/order-status/" class="btn btn-dark btn-lg text-white mt-1 rounded-1 w-md-100" >Order status</a>
                    <a href="/staff-panel/food-booking/download-bill-info/" class="btn btn-dark btn-lg text-white mt-1 rounded-1 w-md-100" >Download bill</a>

                </div>
            </div>
            <?php
        } else if (
            isset($_POST["event-name"]) and
            isset($_POST["event-date"]) and
            isset($_POST["food-type"]) and
            isset($_POST["food-quantity"])
        ) {
            //check they enter the data correct
            if (
                1 == 1 && 2 == 2
            ) {
                include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/food.class.php");
                $data = array(
                    "eventName" => $_POST["event-name"],
                    "eventDate" => $_POST["event-date"],
                    "foodType" => $_POST["food-type"],
                    "foodQuantity" => $_POST["food-quantity"],
                );
                $food = new Food_class();
                $result = $food->putFoodOrder($data);
                if ($result) {
                    ?>
                        <div class="p-5 m-4 bg-body-tertiary rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="display-5 mb-2 fw-bold">Food order booked successfully</h1>
                                <p class="col-md-8 fs-4">Order Is Processing....</p>
                                <a href="../" class="btn btn-dark btn-lg text-white">Go back</a>
                            </div>
                        </div>
                    <?php
                } else {
                    ?>
                        <div class="p-5 m-4 bg-body-tertiary rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="display-5 mb-2 fw-bold">Your Data may Be Incorrect</h1>
                                <p class="col-md-8 fs-4">Please Refill it</p>
                                <a href="../" class="btn btn-orange btn-lg text-white">Refill It</a>
                            </div>
                        </div>
                    <?php
                }
            } else {
                ?>
                    <div class="p-5 m-4 bg-body-tertiary rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 mb-2 fw-bold">Your Data may Be Incorrect</h1>
                            <p class="col-md-8 fs-4">Please Refill it</p>
                            <a href=".." class="btn btn-orange btn-lg text-white">Refill It</a>
                        </div>
                    </div>
                <?php
            }

        } else {
            ?>
                <style>
                    /* body {
                        font-family: Arial, sans-serif;
                        background-color: #f9f9f9;
                       
                    } */

                    .container-1 {
                        margin: 20px;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        max-width: 600px;
                        height: auto;
                        background-color: #fff;
                        padding: 10px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        align-content: center;
                        margin: 5px;
                        align-items: center;
                    }



                    h1,
                    h2 {
                        text-align: center;
                        color: #ff9900;
                    }

                    label {
                        display: block;
                        margin-bottom: 5px;
                        color: #555;
                    }



                    input[type="tel"],
                    input[type="text"],
                    input[type="number"],
                    input[type="date"],
                    input[type="email"],
                    textarea,

                    select {
                        width: 100%;
                        padding: 30px;
                        margin-bottom: 5px;
                        border-radius: 7px;
                        padding: 10px;
                        border-radius: 6px;
                        border: 1px solid #ccc;
                        margin-bottom: 15px;
                    }


                    @media screen and (max-width: 600px) {
                        .icon-rtl {
                            /* padding-right: 50px; */
                            /* margin: 10px; */
                            background: url("/pic/calendar-date.svg") no-repeat left;
                            /* background-size: 20px; */
                            background-position: 300px 10px;
                            background-size: 25px;
                        }
                    }

                    .w-full {
                        width: 100px;
                    }

                    input::-webkit-outer-spin-button,
                    input::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }

                    .mt-6 {
                        margin-top: 90px;
                    }
                </style>
                <div class="container-1 mt-6 mx-auto">
                    <div class="container-fluid">
                        <h1 class="text-dark">Book Food</h1>
                        <hr>
                        <!-- <h2>Hostel Accommodation Form</h2> -->
                        <form action="/staff-panel/food-booking/" method="POST" enctype="multipart/form-data">
                            <label class="form-label mt-1 ms-1 text-dark" for="event-name">Event Name</label>
                            <input class="form-control m-1 mb-2 w-full" type="text" id="event-name" name="event-name" required>


                            <label class="form-label mt-1 ms-1 text-dark" for="event-date">Event Date</label>
                            <input class="form-control m-1 mb-2 icon-rtl w-100" type="date" id="event-date" name="event-date"
                                placeholder="No of Male Staffs" required />


                            <label class="form-label mt-1 ms-1 text-dark" for="food-type">Food Type</label>

                            <select class="m-1 form-select  mb-2 w-100 " id="food-type" name="food-type" required>
                                <option value="">Select</option>
                                <option value="Normal">
                                    Normal - 100 Rs</option>
                                <option value="Vegetarian">
                                    Vegetarian - 200 Rs</option>
                                <option value="Non-Vegetarian">Non-vegetarian - 350 Rs</option>
                            </select>


                            <label class="form-label mt-1 ms-1 text-dark" for="food-quantity">Food Quantity <small>(number of
                                    person)</small> </label>
                            <input class="form-control m-1 mb-2 w-100 " type="number" id="food-quantity" name="food-quantity"
                                required>

                            <label class="form-label mt-2 ms-1 text-dark" for="pdfFile">Authorization Letter</label>
                            <input class="form-control mb-3" class="mb-5" type="file" id="pdfFile" name="pdfFile" accept=".pdf"
                                required>

                            <input class="btn btn-dark container-fluid mb-3" type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            <?php
        }
    } else {
        ?>
        <div class="p-5 m-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display- fw-bold">Something went erong</h1>
                <p class="col-md-8 fs-4">Please Wait</p>
                <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
            </div>
        </div>
        <?php
    }
    ?>
 