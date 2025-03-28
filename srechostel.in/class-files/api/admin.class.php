<?php
// this file gets the connection from the database
include_once($_SERVER['DOCUMENT_ROOT'] . "/.." . "/class-files/mainconn.class.php");

class Admin
{
    // This function deletes users based on provided user data.
    // It handles deletion in two ways:
    // 1. Single user deletion (using the roll number of the student).
    // 2. Multi user deletion (using some of the data of the students).
    public function deleteUser($keys, $values)
    {
        # Getting connection from MySQL
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();

        # Sanitize the input values
        $pointer = 0;
        foreach ($values as $value) {
            $values[$pointer] = mysqli_real_escape_string($sqlConn, $value);
            $pointer++;
        }

        if (in_array("dept", $keys) && in_array("year", $keys)) {
            // Handle department and year deletion if required
        } elseif (in_array("group_of_roll_no", $keys)) {
            $rollNos = $values[0]; // Assuming this is a comma-separated string of roll numbers
            $rollNoArray = explode(",", $rollNos); // Split into an array

            // Sanitize roll numbers for the SQL query
            $rollNoArray = array_map(function ($num) use ($sqlConn) {
                return "'" . mysqli_real_escape_string($sqlConn, trim($num)) . "'";
            }, $rollNoArray);

            $rollNoList = implode(",", $rollNoArray); // Create a comma-separated list

            // Execute deletion queries
            $query1 = "DELETE FROM `login_auth` WHERE user_id IN ($rollNoList);";
            $query2 = "DELETE FROM `stud_details` WHERE roll_no IN ($rollNoList);";
            $query3 = "DELETE FROM `stud_personal_details` WHERE roll_no IN ($rollNoList);";
            $query4 = "DELETE FROM `stud_gurdian_details` WHERE roll_no IN ($rollNoList);";
            $query5 = "DELETE FROM `student_session` WHERE student_rollno IN ($rollNoList);";

            // Check if all deletions were successful
            if (
                $sqlConn->query($query1) && $sqlConn->query($query2) &&
                $sqlConn->query($query3) && $sqlConn->query($query4) &&
                $sqlConn->query($query5)
            ) {
                // Check if the records still exist
                $checkQueries = [
                    "SELECT user_id FROM `login_auth` WHERE user_id IN ($rollNoList);",
                    "SELECT roll_no FROM `stud_details` WHERE roll_no IN ($rollNoList);",
                    "SELECT roll_no FROM `stud_personal_details` WHERE roll_no IN ($rollNoList);",
                    "SELECT roll_no FROM `stud_gurdian_details` WHERE roll_no IN ($rollNoList);",
                    "SELECT student_rollno FROM `student_session` WHERE student_rollno IN ($rollNoList);"
                ];

                $stillExists = false;
                foreach ($checkQueries as $query) {
                    if ($sqlConn->query($query)->num_rows > 0) {
                        $stillExists = true;
                        break;
                    }
                }

                return $stillExists
                    ? array("ACCOUNT_DELETED_FAILED_STUDENT_GROUP", "group")
                    : array("ACCOUNT_DELETED_SUCCESS_STUDENT_GROUP", "group");
            }
        } elseif ($keys[0] == "user_id") {
            # This code checks who the user is (student, staff, or watchman).
            # Then it backs up the data to another table before deletion in the main table.
            # If the user accounts are deleted successfully, it gives a success message.
            # Else it gives the message account deletion failed.
            $rollNo = $values[0];

            try {
                $query0 = "SELECT who_is FROM `login_auth` WHERE user_id='$rollNo';";
                $result = $sqlConn->query($query0);
                error_reporting(0);
                $whois = $result->fetch_assoc()['who_is'];

                if ($whois == "Student") {
                    $query1 = "DELETE FROM `login_auth` WHERE user_id='$rollNo';";
                    $query2 = "DELETE FROM `stud_details` WHERE roll_no='$rollNo';";
                    $query3 = "DELETE FROM `stud_personal_details` WHERE roll_no='$rollNo';";
                    $query4 = "DELETE FROM `stud_gurdian_details` WHERE roll_no='$rollNo';";
                    $query5 = "DELETE FROM `student_session` WHERE student_rollno='$rollNo';";

                    if (
                        $sqlConn->query($query1) && $sqlConn->query($query2) &&
                        $sqlConn->query($query3) && $sqlConn->query($query4) &&
                        $sqlConn->query($query5)
                    ) {
                        // Check if the records still exist
                        $checkQueries = [
                            "SELECT user_id FROM `login_auth` WHERE user_id='$rollNo';",
                            "SELECT roll_no FROM `stud_details` WHERE roll_no='$rollNo';",
                            "SELECT roll_no FROM `stud_personal_details` WHERE roll_no='$rollNo';",
                            "SELECT roll_no FROM `stud_gurdian_details` WHERE roll_no='$rollNo';",
                            "SELECT student_rollno FROM `student_session` WHERE student_rollno='$rollNo';"
                        ];

                        $stillExists = false;
                        foreach ($checkQueries as $query) {
                            if ($sqlConn->query($query)->num_rows > 0) {
                                $stillExists = true;
                                break;
                            }
                        }

                        return $stillExists
                            ? array("ACCOUNT_DELETED_FAILED_STUDENT", $rollNo)
                            : array("ACCOUNT_DELETED_SUCCESS_STUDENT", $rollNo);
                    } else {
                        return array("ACCOUNT_DELETED_FAILED_STUDENT", $rollNo);
                    }
                } elseif ($whois == "Staff") {
                    // TODO: Implement staff account deletion logic
                    return array("STAFF_DELETION_NOT_IMPLEMENTED", $rollNo);
                } else {
                    return array("ACCOUNT_DELETED_FAILED_STUDENT", $rollNo);
                }
            } catch (Exception $e) {
                // Log the error or handle it
                return array("ACCOUNT_DELETION_EXCEPTION", $e->getMessage());
            }
        } elseif ($keys[0] == "year") {
            // Handle deletion by year if required
        } else {
            // Handle other cases if needed
        }
    }

    public function search_students_group($year = null, $department = null)
    {
        // Create a new connection object
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();

        // Initialize an empty array to store search conditions
        $conditions = [];

        // Add year condition if provided
        if (!empty($year)) {
            $conditions[] = "year_of_study = $year";
        }

        // Add department condition if provided
        if (!empty($department)) {
            $conditions[] = "department = '$department'";
        }

        // Form the WHERE clause if there are any conditions
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // Define the SQL query
        $sqlQuery = "SELECT * FROM stud_details $whereClause";

        // Execute the query and fetch results
        $result = $sqlConn->query($sqlQuery);

        // Prepare the response array
        $response = [];

        // Check if results are found
        if ($result->num_rows > 0) {
            // Fetch all matching rows and add them to the response array
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        }

        // Return the JSON response as a string
        return json_encode($response);
    }

    public function search_students_individual($query = '')
    {
        # Getting connection from MySQL
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();
        $sql = "SELECT * FROM stud_details WHERE 1=1";
        $params = [];

        if (!empty($query)) {
            // Check if the query is numeric (assuming roll number is numeric)
            if (is_numeric($query)) {
                // Use LIKE to find roll numbers starting with the given query
                $sql .= " AND roll_no LIKE ?";
                $params[] = $sqlConn->real_escape_string($query) . "%"; // Append % for partial matching
            }
            // Check if the query is in the list of departments
            else if (in_array(strtoupper($query), ['AI&DS', 'IT', 'ECE', 'EEE', 'MECH', 'BME', 'CIVIL', 'AERO', 'CSE', 'EIE', 'MBA'])) {
                $sql .= " AND deptment = ?";
                $params[] = $sqlConn->real_escape_string($query);
            }
            // Otherwise, treat it as a name search
            else {
                $sql .= " AND name LIKE ?";
                $params[] = "%" . $sqlConn->real_escape_string($query) . "%";
            }
        }

        $stmt = $sqlConn->prepare($sql);

        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $students = [];

        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        $stmt->close();

        return ['data' => $students];
    }

    function getPassData($admin, $pass_type, $pass_status, $department = null, $year = null)
    {

        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();

        $sql = "";
        $conditions = [];
        $params = [];
        $types = "";

        switch ($pass_type) {
            case 1:
                $sql = "SELECT g.*, s.year_of_study FROM gate_pass g JOIN stud_details s ON g.roll_no = s.roll_no WHERE 1=1";
                break;
            case 2:
                $sql = "SELECT g.*, s.year_of_study FROM general_home_pass g JOIN stud_details s ON g.roll_no = s.roll_no WHERE 1=1";
                break;
            case 3:
                $sql = "SELECT w.*, s.year_of_study FROM working_days_pass w JOIN stud_details s ON w.roll_no = s.roll_no WHERE 1=1";
                break;
            default:
                return ['error' => 'Invalid pass type'];
        }

        // Add pass_status condition
        if ($pass_status == 1) {
            $conditions[] = "already_booked = 1 AND allowed_or_not = 1";
        } else {
            $conditions[] = "already_booked = 1 AND allowed_or_not = 0";
        }

        // Add optional department condition
        if ($department) {
            $conditions[] = "s.department = ?";
            $params[] = $department;
            $types .= "s"; // 's' for string
        }

        // Add optional year condition
        if ($year) {
            $conditions[] = "s.year_of_study = ?";
            $params[] = $year;
            $types .= "i"; // 'i' for integer (if year is an integer)
        }

        // Combine conditions into the SQL query
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        // Prepare the statement
        $stmt = $sqlConn->prepare($sql);
        if ($stmt === false) {
            return ['error' => 'Failed to prepare statement'];
        }

        // Bind parameters
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $data;
    }

    private function generateToken($length = 32) {
        // Generate a random string
        return bin2hex(random_bytes($length / 2));
    }

    public function acceptThePass($rollNo, $type, $whois)
    {
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();

        date_default_timezone_set("Asia/Kolkata");
        $time = date('Y-m-d H:i:s', time());

        // Define table mapping based on pass type
        $tableMap = [
            '1' => 'gate_pass',
            '2' => 'general_home_pass',
            '3' => 'working_days_pass'
        ];

        // Check if the pass type is valid
        if (!isset($tableMap[$type])) {
            return false;
        }

        // Get the corresponding table
        $table = $tableMap[$type];
        $token = $this->generateToken();
        try {

            // Update query using prepared statements to prevent SQL injection
            $stmt = $sqlConn->prepare("UPDATE `$table` SET allowed_or_not = 1, accepted_by = ?, time_of_approval = ?, recent_pass_id = ? WHERE roll_no = ?");
            $stmt->bind_param('sssi', $whois, $time, $token,$rollNo);
            $updateResult = $stmt->execute();

            if ($updateResult) {
                $stmt = $sqlConn->prepare("SELECT * FROM `$table` WHERE roll_no = ?");
                $stmt->bind_param('i', $rollNo);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                if (isset($row['allowed_or_not']) && $row['allowed_or_not'] == 1) {
                    # TODO : SEPRATE CODE WRITING FOR EACH ADMIN.
                    // print_r($stud_details);
                    $stmt = $sqlConn->prepare("INSERT INTO women_hostel_entry_log (
                        roll_no, name, department, approved_warden, approved_watch_man, 
                        time_of_approval_by_warden, time_of_entry_by_watch_man, status, pass_id
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $approvedWatchman = "-";
                    $timeOfApprovalByWatchman=null;
                    $status=0;
                    $stmt->bind_param(
                        "issssssis",
                        $rollNo,
                        $row['stud_name'],
                        $row['department'],
                        $whois,
                        $approvedWatchman,
                        $time,
                        $timeOfApprovalByWatchman,
                        $status,
                        $token
                    );

                    $updateResult = $stmt->execute();
                    if($updateResult) {
                        return true;
                    } else {
                        return false;
                    }
                    
                }
            }
            return false;

        } catch (Exception $e) {
            // Log the error message (this could be replaced with actual logging)
            // print_r($e);
            error_log("Error in acceptThePass: " . $e->getMessage());
            return false;
        }
    }

    public function declineThePass($rollNo, $type)
    {
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();

        // Define table mapping based on pass type
        $tableMap = [
            '1' => 'gate_pass',
            '2' => 'general_home_pass',
            '3' => 'working_days_pass'
        ];

        // Check if the pass type is valid
        if (!isset($tableMap[$type])) {
            return false;
        }

        // Get the corresponding table
        $table = $tableMap[$type];

        try {
            // Update query using prepared statements
            $stmt = $sqlConn->prepare("UPDATE `$table` SET allowed_or_not = 0, already_booked = 0 WHERE roll_no = ?");
            $stmt->bind_param('i', $rollNo);
            $updateResult = $stmt->execute();

            if ($updateResult) {
                // Query to verify if the pass was successfully updated
                $stmt = $sqlConn->prepare("SELECT allowed_or_not FROM `$table` WHERE roll_no = ?");
                $stmt->bind_param('i', $rollNo);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if (isset($row['allowed_or_not']) && $row['allowed_or_not'] == 0) {
                    return true; // Pass successfully declined
                }
            }
            return false; // Pass not declined

        } catch (Exception $e) {
            // Log the error message (replace this with actual logging)
            error_log("Error in declineThePass: " . $e->getMessage());
            return false;
        }
    }


}
