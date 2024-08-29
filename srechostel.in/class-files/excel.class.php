<?php
//this file get the connection from the database
require $_SERVER['DOCUMENT_ROOT'] . '/../composer/vendor/autoload.php';

use League\Csv\Reader;
use League\Csv\Writer;

include_once ("connection.class.php");

class Excel_class
{
    public $forWhose;

    private function insert_csv_to_database($inputFilePath, $mysqli, $tableName, $columnMappings)
    {
        // Load the CSV document from a file path
        $csv = Reader::createFromPath($inputFilePath, 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        $records = iterator_to_array($csv->getRecords());
        $columns = '(';
        // Prepare the SQL insert statement base
        foreach ($columnMappings as $column) {
            $columns .= $column . ',';
        }
        if (substr($columns, -1) === ',') {
            // Remove the last character (comma)
            $columns = substr($columns, 0, -1);
        }
        $columns .= ")";
        // $finalcolumns = implode(',', array_keys($columnMappings));

        // print_r($columns."<br>");

        // Insert each record into the database
        foreach ($records as $record) {
            $values = "(";
            foreach ($record as $singleRec) {
                $values .= "'" . $singleRec . "'" . ",";
                // print_r($csvColumn);
                // print_r($record[$csvColumn]."\n");
            }
            if (substr($values, -1) === ',') {
                // Remove the last character (comma)
                $values = substr($values, 0, -1);
            }
            $values .= ")";
            // print_r($values."<br>");

            // exit;
            $sql = "INSERT INTO $tableName $columns VALUES $values ;";
            try {
                if ($mysqli->query($sql)) {

                }
            } catch (Exception $e) {
                print_r($values);
                print_r($e);
                exit(-1);
            }

        }
        return true;
    }
    private function filter_csv_columns($inputFilePath, $outputFilePath, $columnNames)
    {
        // Load the CSV document from a file path
        $csv = Reader::createFromPath($inputFilePath, 'r');
        // chdir($_SERVER['DOCUMENT_ROOT']."/../files/excel-files/student-excel-files/");

        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        $records = iterator_to_array($csv->getRecords());

        // Find the indices of the specified columns
        $columnIndices = [];
        foreach ($columnNames as $columnName) {
            $columnIndex = array_search($columnName, $header);
            if ($columnIndex === false) {
                throw new Exception("Column '$columnName' not found in CSV file.");
            }
            $columnIndices[] = $columnIndex;
        }

        // Create a new CSV writer
        $writer = Writer::createFromPath($outputFilePath, 'w+');

        // Write the header row
        $writer->insertOne($columnNames);

        // Write the filtered rows
        foreach ($records as $record) {
            $filteredRecord = [];
            foreach ($columnIndices as $columnIndex) {
                $filteredRecord[] = $record[$header[$columnIndex]];
            }
            $writer->insertOne($filteredRecord);
        }
        return true;
    }

    public function uploadTheFile($FILE)
    {
        chdir($_SERVER["DOCUMENT_ROOT"] . '/..' . "/files/excel-files/main-excel-files/");
        $extension = pathinfo($FILE['name'], PATHINFO_EXTENSION);
        $excelName = time() . '.' . $extension;
        if (move_uploaded_file($FILE['tmp_name'], $excelName)) {
            return $excelName;
        } else {
            return false;
        }
    }
    public function splitTheSheet($FILE_NAME, $forWhose)
    {
        chdir($_SERVER["DOCUMENT_ROOT"] . '/..' . "/files/excel-files/main-excel-files/");
        if ($forWhose == "staff") {


        } else if ($forWhose == "student") {
            $sqlConn = new Connection();
            $conn = $sqlConn->returnConn();
            $filePath_1 = $_SERVER['DOCUMENT_ROOT'] . "/../files/excel-files/student-excel-files/" . "stud_details-" . 
date('d-m-Y', time()) . ".csv";
            $filePath_2 = $_SERVER['DOCUMENT_ROOT'] . "/../files/excel-files/student-excel-files/" . "stud_personal_details-" 
. date('d-m-Y', time()) . ".csv";
            $filePath_3 = $_SERVER['DOCUMENT_ROOT'] . "/../files/excel-files/student-excel-files/" . "stud_gurdian_details-" 
. date('d-m-Y', time()) . ".csv";
            $filters_1 = ["hostel", "year_of_study", "name", "roll_no", "department", "tutor_name", "ac_name"];
            $filters_2 = ["name", "roll_no", "email", "date_of_birth", "blood_group", "department", "room_no", "phone_no", 
"stud_address", "pincode"];
            $filters_3 = ["name", "roll_no", "father_name", "mother_name", "guardian_name", "father_contact_no", 
"mother_contact_no", "guardian_contact_no"];
            $stud_details_result = $this->filter_csv_columns($FILE_NAME, $filePath_1, $filters_1);
            $stud_personal_details_result = $this->filter_csv_columns($FILE_NAME, $filePath_2, $filters_2);
            $stud_gurdian_details_result = $this->filter_csv_columns($FILE_NAME, $filePath_3, $filters_3);
            if ($stud_details_result and $stud_personal_details_result and $stud_gurdian_details_result) {
                $result_1 = $this->insert_csv_to_database($_SERVER['DOCUMENT_ROOT'] . 
"/../files/excel-files/student-excel-files/" . "stud_details-" . date('d-m-Y', time()) . ".csv", $conn, "stud_details", 
$filters_1);
                $result_2 = $this->insert_csv_to_database($_SERVER['DOCUMENT_ROOT'] . 
"/../files/excel-files/student-excel-files/" . "stud_personal_details-" . date('d-m-Y', time()) . ".csv", $conn, 
"stud_personal_details", $filters_2);
                $result_3 = $this->insert_csv_to_database($_SERVER['DOCUMENT_ROOT'] . 
"/../files/excel-files/student-excel-files/" . "stud_gurdian_details-" . date('d-m-Y', time()) . ".csv", $conn, 
"stud_gurdian_details", $filters_3);

                if ($result_1 and $result_2 and $result_3) {
                    echo "success";
                }
            } else {
                return false;
            }

        } else {
            $result = array(
                "result" => 0,
                "message" => "wrong user represented "
            );
            return $result;
        }
    }
}

