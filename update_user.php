<?php
// Include the database connection file
require 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID and form data from the POST request
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update the user data in the database
    $sql = "UPDATE user SET name='$name', username='$username', password='$password' WHERE id=$userId";

    if (mysqli_query($conn, $sql)) {
        header("Location: account.php");
    } else {
        echo "Error updating user data: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>