<?php

header('Content-Type: application/json');
include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/api/admin.class.php";

$admin = new Admin();

if (isset($_POST['year']) || isset($_POST['department'])) {
    $year = $_POST['year'] ?? null;
    $department = $_POST['department'] ?? null;

    $students = $admin->search_students_group($year, $department);

    if (!empty($students)) {
        foreach ($students as $student) {
            echo "<p>" . $student['name'] . " - " . $student['department'] . " - Year " . $student['year_of_study'] . "</p>";
        }
    } else {
        echo "<p class='alert alert-warning'>No records found.</p>";
    }
}


// $name = isset($_GET['name']) ? $_GET['name'] : '';
// $rollno = isset($_GET['rollno']) ? $_GET['rollno'] : '';
// $dept = isset($_GET['dept']) ? $_GET['dept'] : '';

// $response = $admin->search_students($name, $rollno, $dept);
// $s = $_SERVER['DOCUMENT_ROOT'];
// $result = [
//     'a' => $s,
//     'response' => $response
// ];
// echo json_encode($result);
