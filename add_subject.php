<?php
// Include the database connection file
require 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $instructorId = $_POST['instructorIdHidden']; // Corrected to use instructorId instead of instructorName
    $subjectName = $_POST['subjectName'];
    $Time = $_POST['Time'];
    $Day = $_POST['Day'];
    $Room = $_POST['Room'];
    $Course = $_POST['Course'];
    $Year = $_POST['Year'];

    // Insert data into the subject table
    $sql = "INSERT INTO subject (subject_name, instructor_id, Time, Day, Room, Course, Year) 
            VALUES ('$subjectName', '$instructorId', '$Time', '$Day', '$Room', '$Course', '$Year')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Redirect to admin.php after successful insertion
        header("Location: admin.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>