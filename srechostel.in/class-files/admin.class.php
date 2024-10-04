<?php
// Include the connection class to establish a database connection
include_once("mainconn.class.php");

class Admin
{
    private $conn;

    public function __construct()
    {
        $connection = new Connection();
        $this->conn = $connection->returnConn();
    }

    // Method to delete users (single or multiple)
    public function deleteUser($keys, $values)
    {
        $sqlConn = $this->conn;

        // Sanitize input values
        foreach ($values as &$value) {
            $value = mysqli_real_escape_string($sqlConn, $value);
        }

        if (in_array("group_of_roll_no", $keys)) {
            $rollNos = $values[0];
            $rollNoArray = explode(",", $rollNos);
            $rollNoList = "'" . implode("','", $rollNoArray) . "'";

            // Prepare deletion queries
            $queries = [
                "DELETE FROM `login_auth` WHERE user_id IN ($rollNoList)",
                "DELETE FROM `stud_details` WHERE roll_no IN ($rollNoList)",
                "DELETE FROM `stud_personal_details` WHERE roll_no IN ($rollNoList)",
                "DELETE FROM `stud_gurdian_details` WHERE roll_no IN ($rollNoList)",
                "DELETE FROM `student_session` WHERE student_rollno IN ($rollNoList)"
            ];

            foreach ($queries as $query) {
                if (!$sqlConn->query($query)) {
                    return ["ACCOUNT_DELETED_FAILED_STUDENT_GROUP", "group"];
                }
            }
            return ["ACCOUNT_DELETED_SUCCESS_STUDENT_GROUP", "group"];
        } elseif ($keys[0] == "user_id") {
            $rollNo = $values[0];
            $whois = $this->getUserRole($rollNo);

            if ($whois == "Student") {
                return $this->deleteStudent($rollNo);
            } elseif ($whois == "Staff") {
                // TODO: Add staff deletion logic here
            } else {
                return ["ACCOUNT_DELETED_FAILED_STUDENT", $rollNo];
            }
        }

        return ["ACCOUNT_DELETED_FAILED_STUDENT", "Invalid request"];
    }

    private function getUserRole($rollNo)
    {
        $query = "SELECT who_is FROM `login_auth` WHERE user_id='$rollNo'";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['who_is'] ?? null;
    }

    private function deleteStudent($rollNo)
    {
        $queries = [
            "DELETE FROM `login_auth` WHERE user_id='$rollNo'",
            "DELETE FROM `stud_details` WHERE roll_no='$rollNo'",
            "DELETE FROM `stud_personal_details` WHERE roll_no='$rollNo'",
            "DELETE FROM `stud_gurdian_details` WHERE roll_no='$rollNo'",
            "DELETE FROM `student_session` WHERE student_rollno='$rollNo'"
        ];

        foreach ($queries as $query) {
            if (!$this->conn->query($query)) {
                return ["ACCOUNT_DELETED_FAILED_STUDENT", $rollNo];
            }
        }
        return ["ACCOUNT_DELETED_SUCCESS_STUDENT", $rollNo];
    }

    // Method to search for students
    public function search_students($name = '', $rollno = '', $dept = '')
    {
        $sql = "SELECT * FROM students WHERE 1=1";
        $params = [];

        if (!empty($name)) {
            $sql .= " AND name LIKE ?";
            $params[] = "%" . $this->conn->real_escape_string($name) . "%";
        }

        if (!empty($rollno)) {
            $sql .= " AND rollno = ?";
            $params[] = $this->conn->real_escape_string($rollno);
        }

        if (!empty($dept)) {
            $sql .= " AND dept = ?";
            $params[] = $this->conn->real_escape_string($dept);
        }

        $stmt = $this->conn->prepare($sql);
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
        return ['status' => 'success', 'data' => $students];
    }
}
?>