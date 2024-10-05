<?php

header("Access-Control-Allow-Origin: *");  // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');
include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/api/admin.class.php";

$admin = new Admin();

if (isset($_POST['year']) || isset($_POST['department'])) {
    $year = $_POST['year'] ?? null;
    $department = $_POST['department'] ?? null;
    $students = $admin->search_students_group($year, $department);
    $students = json_decode($students, true);

  
    // Set the content type to JSON and return the response
    echo json_encode($students);
}


// $query = isset($_GET['query']) ? $_GET['query'] : '';


// $response = $admin->search_students_individual($query);

// echo json_encode($response);
