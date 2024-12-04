<?php
// Include the database connection file
require 'connection.php';

// Fetch data from the subject table
$sql = "SELECT subject_id, instructor_id FROM subject";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $subjectId = $row['subject_id'];
    $instructorId = $row['instructor_id'];

    // Return data in JSON format
    $data = array('subjectId' => $subjectId, 'instructorId' => $instructorId);
    echo json_encode($data);
} else {
    // Handle case where no data is found
    $errorData = array('error' => 'No data found');
    echo json_encode($errorData);
}

// Close the database connection
$conn->close();
?>