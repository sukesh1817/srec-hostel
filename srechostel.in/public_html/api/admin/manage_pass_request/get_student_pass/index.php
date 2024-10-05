<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/api/admin.class.php";

$admin = new Admin();

if (isset($_GET['pass_type']) && isset($_GET['pass_status'])) {
    $pass_type = $_GET['pass_type'];
    $pass_status = $_GET['pass_status'];
    $year = null;
    $department = null;
    if (isset($_POST['year'])) {
        if ($_POST['year'] != 'NULL') {
            $year = $_GET['year'];
        } 
    }
    if (isset($_POST['department'])) {
        if ($_POST['department'] != 'NULL') {
            $department = $_GET['department'] ;
        } 
    }

    $data = $admin->getPassData($admin, $pass_type, $pass_status, $department, $year);

    // Return data in JSON format
    echo json_encode($data);
}
?>
