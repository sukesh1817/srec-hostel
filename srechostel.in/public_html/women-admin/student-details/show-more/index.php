<?php
// Include the main connection class
require_once $_SERVER['DOCUMENT_ROOT']."/../../".'class-files/connection.class.php';

// Check if roll_no is set in the URL
if (isset($_GET['roll_no'])) {
    $roll_no = $_GET['roll_no'];

    // Create a connection instance
    $conn = new Connection();
    $sqlConn = $conn->returnConn();

    // Prepare the SQL statement
    $sql = "SELECT * FROM stud_details WHERE roll_no = ?";
    $stmt = $sqlConn->prepare($sql);
    $stmt->bind_param('i', $roll_no); // Assuming roll_no is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the student details
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        // Display student details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student Details</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Student Details</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($student['name']); ?></h5>
                        <p class="card-text"><strong>Roll No:</strong> <?php echo htmlspecialchars($student['roll_no']); ?></p>
                        <p class="card-text"><strong>Department:</strong> <?php echo htmlspecialchars($student['department']); ?></p>
                        <p class="card-text"><strong>Hostel:</strong> <?php echo htmlspecialchars($student['hostel']); ?></p>
                        <p class="card-text"><strong>Year of Study:</strong> <?php echo htmlspecialchars($student['year_of_study']); ?></p>
                        <p class="card-text"><strong>Tutor Name:</strong> <?php echo htmlspecialchars($student['tutor_name']); ?></p>
                        <p class="card-text"><strong>AC Name:</strong> <?php echo htmlspecialchars($student['ac_name']); ?></p>
                    </div>
                </div>
                <a href="/student-details/" class="btn btn-dark mt-3">Back</a> <!-- Link to go back to the previous page -->
            </div>
        </body>
        </html>
        <?php
    } else {
        // If no student found, display a message
        echo "<div class='container mt-5'><h4>No student found with the provided Roll Number.</h4></div>";
    }

    $stmt->close();
} else {
    echo "<div class='container mt-5'><h4>Roll Number is not specified.</h4></div>";
}
?>
