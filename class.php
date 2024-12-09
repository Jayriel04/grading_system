<?php
// Include the database connection file
require 'connection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query the database to fetch the user's name
$userSql = "SELECT username FROM user WHERE id = $user_id";
$userResult = $conn->query($userSql);

if ($userResult->num_rows == 1) {
    $user = $userResult->fetch_assoc();
    $name = $user['username'];
} else {
    $name = "Guest";
}

// Query the database to fetch subject data related to the user
$subjectSql = "SELECT subject_id, subject_name FROM subject WHERE instructor_id = $user_id";
$subjectResult = $conn->query($subjectSql);

if ($subjectResult->num_rows > 0) {
    $subjects = [];
    while ($row = $subjectResult->fetch_assoc()) {
        $subjects[$row['subject_id']] = $row['subject_name'];
    }
    $_SESSION['subjects'] = $subjects; // Add subject IDs and names to the session
} else {
    // If no subjects are found for the user, set subjects to an empty array
    $_SESSION['subjects'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MCC Grading System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../JAYRIEL/css/bootstrap.css">
    <link rel="stylesheet" href="../jayriel/css/styles.css">
    <link rel="stylesheet" href="../jayriel/css/styles_2.css" />
</head>

<body>
<nav class="sidenav">
        <a href="index.php">
            <img src="../jayriel/image/user_icon.png" alt="User Icon" width="80" height="80" />
            <span>Welcome, <?php echo $name; ?></span>
        </a>
        <a href="index.php">HOME</a>
        <a href="login.php">LOGOUT</a>
    </nav>

    <div class="main">
        <h1>CLASSES</h1>
        <div class="button-grid">
            <?php
            if (isset($_SESSION['subjects']) && count($_SESSION['subjects']) > 0) {
                foreach ($_SESSION['subjects'] as $subjectId => $subjectName) {
                    echo "<a href='student.php?subject=" . urlencode($subjectName) . "'><button class='btn btn-primary btn-lg'>" . $subjectName . "</button></a>";
                }
            } else {
                echo "<p>No classes found</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>