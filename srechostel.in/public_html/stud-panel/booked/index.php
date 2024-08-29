
    <?php
    /*
    first this code check the token is already booked or not if booked this show the message token is booked
    */
    if($_SESSION['yourToken']){
    include_once $_SERVER["DOCUMENT_ROOT"] . "../" . "class-files/token.class.php";
    $rollNo=isset($_SESSION["yourToken"]) ? $_SESSION["yourToken"] : "1" ;
    $token = new Token($rollNo);
    $res=$token->isTokenBooked($rollNo);
    if ($res) {
        ?>
        <div class="p-5 m-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 mb-2 fw-bold">Token Already Booked</h1>
                <p class="col-md-8 fs-4">Please Check It :)</p>
                <a href="../" class="btn btn-orange btn-lg text-white" type=".btn-orange">Go Back</a>
            </div>
        </div>
        <?php

    } else {
        if (
            isset ($_SESSION["yourToken"])
            and isset ($_POST["tuesdayCount"])
            and isset ($_POST["wednesdayCount"])
            and isset ($_POST["thursdayCount"])
            and isset ($_POST["sundayCount"])
            and ( date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")
        ) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "../" . "class-files/token.class.php";
            $conn = new Connection();
            $result = false;
            $sqlConn = $conn->returnConn();
            $tuesday = $_POST["tuesdayCount"];
            $wednesday = $_POST["wednesdayCount"];
            $thursday = $_POST["thursdayCount"];
            $sunday = $_POST["sundayCount"];
            $rollNo = $_SESSION["yourToken"];
            $day = date("l");
            $nextTuesday = "";
            if ($day == "Tuesday") {
                $date = strtotime("+7 day", strtotime(date("Y-m-d")));
                $nextTuesday = date("Y-m-d", $date);
            } else if ($day == "Wednesday") {
                $date = strtotime("+6 day", strtotime(date("Y-m-d")));
                $nextTuesday = date("Y-m-d", $date);
            } else if ($day == "Thursday") {
                $date = strtotime("+5 day", strtotime(date("Y-m-d")));
                $nextTuesday = date("Y-m-d", $date);
            } else if ($day == "Friday") {
                ;
                $date = strtotime("+4 day", strtotime(date("Y-m-d")));
                $nextTuesday = date("Y-m-d", $date);
            }
            else if ($day == "Saturday") {
                ;
                $date = strtotime("+3 day", strtotime(date("Y-m-d")));
                $nextTuesday = date("Y-m-d", $date);
            }

            $date = strtotime("+1 day", strtotime($nextTuesday));
            $nextWednesday = date("Y-m-d", $date);

            $date = strtotime("+1 day", strtotime($nextWednesday));
            $nextThursday = date("Y-m-d", $date);

            $date = strtotime("+3 day", strtotime($nextThursday));
            $nextSunday = date("Y-m-d", $date);

            // }
            $array = array(
                "rollNo" => $rollNo,

                "tuesdayCount" => $tuesday,
                "tuesdayDate" => $nextTuesday,

                "wednesdayCount" => $wednesday,
                "wednesdayDate" => $nextWednesday,

                "thursdayCount" => $thursday,
                "thursdayDate" => $nextThursday,

                "sundayCount" => $sunday,
                "sundayDate" => $nextSunday

            );
            $token = new Token($rollNo);
            if ($token->isTokenIdPresent) {
                $result = $token->updateToken($array);

            } else {
                $result = $token->createNewToken($array);
            }
            if ($result) {
                ?>
                <div class="p-5 m-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">Token Successfully Booked</h1>
                        <p class="col-md-8 fs-4">Enjoy Your Meal :)</p>
                        <a href="../" class="btn btn-orange btn-lg text-white" type=".btn-orange">Go Back</a>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="p-5 m-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
                        <p class="col-md-8 fs-4">Please Try Again :(</p>
                        <a href="../" class="btn btn-orange btn-lg text-white" type=".btn-orange">Go Back</a>
                    </div>
                </div>
                <?php
            }

        } else {
            ?>
            <div class="p-5 m-4 bg-body-tertiary rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
                    <p class="col-md-8 fs-4">Please Try Again :(</p>
                    <a href="../" class="btn btn-orange btn-lg text-white" type=".btn-orange">Go Back</a>
                </div>
            </div>
            <?php
        }
    }
} else {
    // comes when the session is not set
    ?>
    <div class="p-5 m-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
            <p class="col-md-8 fs-4">Please Try Again :(</p>
            <a href="../" class="btn btn-orange btn-lg text-white" type=".btn-orange">Go Back</a>
        </div>
    </div>
    <?php
}
    ?>
