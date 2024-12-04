<?php
// Include the database connection file
require 'connection.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];

    // Query the admin table for admin account
    $adminSql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $adminResult = $conn->query($adminSql);

    // Query the user table for regular user account if admin login fails
    if ($adminResult->num_rows == 1) {
        // Admin login successful
        $admin = $adminResult->fetch_assoc();

        // Store the admin's ID in a session variable
        $_SESSION['admin_id'] = $admin['id'];

        // Redirect to admin page
        header("Location: admin.php");
        exit();
    } else {
        // Query the user table for regular user account
        $userSql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $userResult = $conn->query($userSql);

        if ($userResult->num_rows == 1) {
            // User login successful
            $user = $userResult->fetch_assoc();

            // Store the user's ID in a session variable
            $_SESSION['user_id'] = $user['id'];

            // Redirect to index page
            header("Location: index.php");
            exit();
        } else {
            // Redirect to login.php if login fails
            header("Location: login.php");
            exit();
        }
    }
}
?>