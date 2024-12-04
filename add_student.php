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
        // Redirect to admin.php after successful insertion
        header("Location: class.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>