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
$subjectSql = "SELECT Time, Day, subject_name, Room, Course, Year 
               FROM subject 
               WHERE instructor_id = $user_id";
$subjectResult = $conn->query($subjectSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MCC Grading System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../JAYRIEL/css/bootstrap.css">
    <link rel="stylesheet" href="../jayriel/css/styles.css" />
</head>

<body>
    <nav class="sidenav">
        <a href="index.php">
            <img src="../jayriel/image/user_icon.png" alt="User Icon" width="80" height="80" />
            <span>Welcome, <?php echo $name; ?></span>
        </a>
        <a href="class.php">CLASS</a>
        <a href="login.php">LOGOUT</a>
    </nav>

    <div class="main">
        <table class="teacher-table">
            <h1>Class Schedule</h1>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Course</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($subjectResult->num_rows > 0) {
                    while ($row = $subjectResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['subject_name'] . "</td>";
                        echo "<td>" . $row['Day'] . "</td>";
                        echo "<td>" . $row['Time'] . "</td>";
                        echo "<td>" . $row['Room'] . "</td>";
                        echo "<td>" . $row['Course'] . "</td>";
                        echo "<td>" . $row['Year'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>