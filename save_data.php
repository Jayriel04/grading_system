<?php
// Assuming you have a database connection established
require 'connection.php';

$names = json_decode(file_get_contents('php://input'), true);

foreach ($names as $name) {
    // Insert each name into the "student" table
    $sql = "INSERT INTO student (student_name) VALUES ('$name')";
    // Execute the SQL query
    mysqli_query($connection, $sql); // Uncomment this line after establishing database connection
}

echo 'Names saved successfully';
?>