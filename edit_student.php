<?php
// Require the database connection file
require 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];
    $studentMidterm = $_POST['studentMidterm'];
    $studentFinal = $_POST['studentFinal'];

    // Prepare and execute the SQL query to update the student data
    $sql = "UPDATE student SET student_name='$studentName', midterm='$studentMidterm', final='$studentFinal' WHERE student_id='$studentId'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>window.location.href = "student.php?subject=IT101";</script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>