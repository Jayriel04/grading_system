<?php
// Include the database connection file
require 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $instructorId = $_POST['instructorIdHidden'];
    $subjectId = $_POST['subjectId'];
    $name = $_POST['studentName'];
    $midterm = $_POST['studentMidterm'];
    $final = $_POST['studentFinal'];

    // Insert data into the student table
    $sql = "INSERT INTO student (subject_id, instructor_id, student_name, midterm, final) 
            VALUES ('$subjectId', '$instructorId', '$name', '$midterm', '$final')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Start the session
        session_start();

        // Set session variable to indicate successful insertion
        $_SESSION['student_inserted'] = true;

        // Redirect to a new page using JavaScript
        echo '<script>window.location.href = "student.php?subject=IT101";</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>