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
    $response = [];

    if (!empty($students)) {
        foreach ($students as $student) {
            // Append student details to the response array
            $response[] = [
                'name' => $student['name'],
                'department' => $student['department'],
                'year' => $student['year_of_study'],
                'hostel' => $student['hostel']  // Include any additional fields as needed
            ];
        }
    } else {
        $response = [
            'message' => 'No records found.',
            'alert' => 'warning'
        ];
    }

    // Set the content type to JSON and return the response
    echo json_encode($response);
}


// $query = isset($_GET['query']) ? $_GET['query'] : '';


// $response = $admin->search_students_individual($query);

// echo json_encode($response);
