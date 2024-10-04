<?php
header('Content-Type: application/json');


include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/admin.class.php";

$admin = new Admin();

$name = isset($_GET['name']) ? $_GET['name'] : '';
$rollno = isset($_GET['rollno']) ? $_GET['rollno'] : '';
$dept = isset($_GET['dept']) ? $_GET['dept'] : '';

$response = $admin->search_students($name, $rollno, $dept);
$s = $_SERVER['DOCUMENT_ROOT'];
echo json_encode('{"a":"'.$s.'"},'.$response);

