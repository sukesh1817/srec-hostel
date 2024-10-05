<?php

header("Access-Control-Allow-Origin: *");  // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');
include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/api/admin.class.php";

$admin = new Admin();

if (isset($_POST['year']) || isset($_POST['department'])) {
    $year = null;
    $department = null;
    if (isset($_POST['year'])) {
        if ($_POST['year'] != 'NULL') {
            $year = $_POST['year'];
        } 
    }
    if (isset($_POST['department'])) {
        if ($_POST['department'] != 'NULL') {
            $department = $_POST['department'] ;
        } 
    }

    $students = $admin->search_students_group($year, $department);
    $students = json_decode($students, true);
    echo json_encode($students);
} else {
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $response = $admin->search_students_individual($query);
    echo json_encode($response);
}



