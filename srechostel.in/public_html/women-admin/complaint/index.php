<?php
// Session_id check code
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-women-admin.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
    // included the poppins font.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
    ?>
</head>

<?php
function echo_main_template()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../../config/' . "domain.php";
    ?>
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4" src="<?php echo $domain; ?>/images/icons/complaint.jpg" alt="" width="72"
            height="57">
        <h1 class="display-5 fw-bold text-body-emphasis">Complaint page</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">You can explore the common and individual complaint.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="?c_type=common_c" class="btn btn-primary btn-lg px-4 gap-3">Common</a>
                <a href="?c_type=individual_c" class="btn btn-outline-secondary btn-lg px-4">Individual</a>
            </div>
        </div>
    </div>
    <?php
}

function echo_logs($type)
{
    ?>
    <div class="float-end mx-3 my-3">
        <a href="/comaplint/logs/?c_type=<?php
        if ($type == "common") {
            echo "common";
        } else {
            echo "individual";
        } ?>" class="btn btn-sm btn-dark rounded-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pass"
                viewBox="0 0 16 16">
                <path d="M5.5 5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z" />
                <path
                    d="M8 2a2 2 0 0 0 2-2h2.5A1.5 1.5 0 0 1 14 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-13A1.5 1.5 0 0 1 3.5 0H6a2 2 0 0 0 2 2m0 1a3 3 0 0 1-2.83-2H3.5a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-1.67A3 3 0 0 1 8 3" />
            </svg>
            Logs
        </a>
        </span>
    </div>
    <?php
}

function get_all_comaplaint($type)
{
    $complaint = new commonClass();
    $row = [];
    if ($type == 1) {
        $row = $complaint->retriveComplaint("common_complaint");
    } else {
        $row = $complaint->retriveComplaint("individual_complaint");
    }
    $temp = 0;
    ?>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
                while (isset($row[$temp])) {
                    ?>
                    <div class="col images">
                        <div class="card shadow-sm" style="height: 100%; min-height: 350px;">
                            <!-- Adjust min-height as needed -->
                            <div class="card-body d-flex flex-column" style="height: 200px;">
                                <!-- Fixed height for card body with flex column -->
                                <ul class="list-group list-group-flush mb-3 flex-grow-1">
                                    <?php if ($type != 1) { ?>
                                        <li class="list-group-item"><strong>Name:</strong> <?php echo $row[$temp]["stud_name"] ?>
                                        </li>
                                        <li class="list-group-item"><strong>Room No:</strong> <?php echo $row[$temp]["room_no"] ?>
                                        </li>
                                    <?php } ?>
                                    <li class="list-group-item"><strong>Department:</strong>
                                        <?php echo $row[$temp]["department"] ?></li>
                                    <li class="list-group-item"><strong>Complaint Date:</strong>
                                        <?php echo $row[$temp]["date_of_complaint"] ?></li>
                                    <li class="list-group-item"><strong>Complaint Summary:</strong>
                                        <?php echo $row[$temp]["complaint_summary"] ?></li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div class="btn-group">
                                        <a href="/evidence-photo/?roll-no=<?php echo $row[$temp]["roll_no"] ?>&w=i"
                                            class="btn btn-sm btn-outline-secondary photo me-2">
                                            Evidence Photo
                                        </a>
                                        <?php if ($row[$temp]["complaint_satisfied"] == 0) { ?>
                                            <a href="/address-complaint/?roll-no=<?php echo $row[$temp]["roll_no"] ?>&w=i"
                                                class="btn btn-sm btn-outline-secondary me-2">
                                                Address It
                                            </a>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-success" disabled>Complaint Addressed</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $temp++;
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>

<body>
    <?php
    // included the navbar.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php";

    // Included the complaint breadcrumbs.
    include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/__breadcrumbs/complaint.php";

    if (isset($_GET['c_type'])) {
        // Including complaint class
        include_once($_SERVER["DOCUMENT_ROOT"] . "/../../class-files/common.class.php");

        // Check which type of complaint
        if ($_GET['c_type'] == "common_c") {
            bread_crumb_complaint("common");
            echo_logs("common");
            get_all_comaplaint(1);
        } else if ($_GET['c_type'] == "individual_c") {
            bread_crumb_complaint("individual");
            echo_logs("individual");
            get_all_comaplaint(2);
        } else {
            echo_main_template();
        }
    } else {
        echo_main_template();
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>