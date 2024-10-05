<?php
// Include the main connection class
require_once $_SERVER['DOCUMENT_ROOT'] . "/../../" . 'class-files/connection.class.php';

// Check if roll_no is set in the URL
if (isset($_GET['roll_no'])) {
    $roll_no = $_GET['roll_no'];

    // Create a connection instance
    $conn = new Connection();
    $sqlConn = $conn->returnConn();

    // Prepare the SQL statement for student details
    $sql = "SELECT * FROM stud_details WHERE roll_no = ?";
    $stmt = $sqlConn->prepare($sql);
    $stmt->bind_param('i', $roll_no); // Assuming roll_no is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the student details
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Prepare SQL for additional details
        $sql2 = "SELECT * FROM stud_personal_details WHERE roll_no = ?";
        $stmt2 = $sqlConn->prepare($sql2);
        $stmt2->bind_param('i', $roll_no);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $personal_details = $result2->fetch_assoc();

        $sql3 = "SELECT * FROM stud_gurdian_details WHERE roll_no = ?";
        $stmt3 = $sqlConn->prepare($sql3);
        $stmt3->bind_param('i', $roll_no);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $guardian_details = $result3->fetch_assoc();

        // Display student details
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student Details</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php"; ?>
            <style>
                .card {
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .card-text {
                    margin-bottom: 0.5rem;
                }
            </style>
        </head>

        <body>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/navbar.php"; ?>
            <div class="container mt-5 mb-4">
                <h2 class="text-center mb-4">Student Details</h2>
                <div class="card mx-auto" style="max-width: 600px;">
                    <div class="card-body">
                        <h4 class="card-title text-center"><?php echo htmlspecialchars($student['name']); ?></h4>
                        <p class="card-text"><strong>Roll No:</strong> <?php echo htmlspecialchars($student['roll_no']); ?></p>
                        <p class="card-text"><strong>Department:</strong>
                            <?php echo htmlspecialchars($student['department']); ?></p>
                        <p class="card-text"><strong>Hostel:</strong> <?php echo htmlspecialchars($student['hostel']); ?></p>
                        <p class="card-text"><strong>Year of Study:</strong>
                            <?php echo htmlspecialchars($student['year_of_study']); ?></p>
                        <p class="card-text"><strong>Tutor Name:</strong>
                            <?php echo htmlspecialchars($student['tutor_name']); ?></p>
                        <p class="card-text"><strong>AC Name:</strong> <?php echo htmlspecialchars($student['ac_name']); ?></p>
                        <hr>

                        <h5 class="mt-4">Personal Details</h5>
                        <?php if ($personal_details): ?>
                            <p class="card-text"><strong>Date of Birth:</strong>
                                <?php echo htmlspecialchars($personal_details['date_of_birth']); ?></p>
                            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($personal_details['email']); ?>
                            </p>
                            <p class="card-text"><strong>Phone:</strong>
                                <?php echo htmlspecialchars($personal_details['phone_no']); ?></p>
                            <p class="card-text"><strong>Blood group:</strong>
                                <?php echo htmlspecialchars($personal_details['blood_group']); ?></p>
                            <p class="card-text"><strong>Address:</strong>
                                <?php echo htmlspecialchars($personal_details['stud_address']) . " - " . htmlspecialchars($personal_details['pincode']); ?>
                            </p>
                        <?php else: ?>
                            <p class="card-text">No personal details found.</p>
                        <?php endif; ?>
                        <hr>

                        <h5 class="mt-4">Guardian Details</h5>
                        <?php if ($guardian_details): ?>
                            <p class="card-text"><strong>Father Name:</strong>
                                <?php echo htmlspecialchars($guardian_details['father_name']); ?></p>
                            <p class="card-text"><strong>Mother Name:</strong>
                                <?php echo htmlspecialchars($guardian_details['mother_name']); ?></p>
                            <p class="card-text"><strong>Father Number:</strong>
                                <?php echo htmlspecialchars($guardian_details['father_contact_no']); ?></p>

                            <?php
                            if ($guardian_details['gurdian_name'] != null) {
                                ?>
                                <p class="card-text"><strong>Local gurdian name:</strong>
                                    <?php echo htmlspecialchars($guardian_details['gurdian_name']); ?></p>
                                <?php
                                if ($guardian_details['gurdian_contact_no'] != 0) {
                                    ?>
                                    <p class="card-text"><strong>Local gurdian number:</strong>
                                        <?php echo htmlspecialchars($guardian_details['gurdian_contact_no']); ?></p>
                                    <?php

                                }
                            }
                            ?>
                        <?php else: ?>
                            <p class="card-text">No guardian details found.</p>
                        <?php endif; ?>
                    </div>
                    <div class="text-center mt-3 mb-3">
                        <a href="/student-details/" class="btn btn-dark btn-lg rounded-1 px-3">Back</a>
                    </div>
                </div>

            </div>
        </body>

        </html>
        <?php

    } else {
        echo "<div class='container mt-5'><h4>No student found with the provided Roll Number.</h4></div>";
    }

} else {
    echo "<div class='container mt-5'><h4>Roll Number is not specified.</h4></div>";
}
?>