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
        <a href="admin.php">
            <img src="../jayriel/image/user_icon.png" alt="User Icon" width="80" height="80" /><span>Welcome</span>
        </a>
        <a href="account.php">Account</a>
        <a href="login.php">LOGOUT</a>
    </nav>
    <div class="main">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">Add
                Subject</button>
        </div>
        <h1>Instructor List</h1>
        <?php
        // Include the database connection file
        require 'connection.php';

        // Fetch data from the subject table and user table
        $sql = "SELECT u.name AS instructor_name, 
               s.subject_name,
               s.Time,
               s.Day,
               s.Room,
               s.Course,
               s.Year
        FROM subject s
        INNER JOIN user u ON s.instructor_id = u.id
        ORDER BY u.name";
        $result = $conn->query($sql);
        ?>

        <table class="instructor-table">
            <thead>
                <tr>
                    <th>Instructor Name</th>
                    <th>Subject Name</th>
                    <th>Time</th>
                    <th>Day</th>
                    <th>Room</th>
                    <th>Course</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['instructor_name'] . "</td>";
                        echo "<td>" . $row['subject_name'] . "</td>";
                        echo "<td>" . $row['Time'] . "</td>";
                        echo "<td>" . $row['Day'] . "</td>";
                        echo "<td>" . $row['Room'] . "</td>";
                        echo "<td>" . $row['Course'] . "</td>";
                        echo "<td>" . $row['Year'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No subjects found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
        </tbody>
        </table>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSubjectForm" method="post" action="add_subject.php">
                        <label for="instructorName">Instructor Name:</label>
                        <select id="instructorName" name="instructorName" class="form-control">
                            <!-- Options populated dynamically from database -->
                            <?php
                            // Include the database connection file
                            require 'connection.php';

                            // SQL query to fetch instructor names from the user table
                            $sql = "SELECT id, name FROM user";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No Instructors found</option>";
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                        </select>
                        <input type="hidden" id="instructorNameHidden" name="instructorNameHidden">
                        <input type="hidden" id="instructorIdHidden" name="instructorIdHidden">

                        <label for="subjectName">Subject Name:</label>
                        <input type="text" id="subjectName" name="subjectName" class="form-control">

                        <label for="Time">Time:</label>
                        <input type="text" id="Time" name="Time" class="form-control">

                        <label for="Day">Day:</label>
                        <input type="text" id="Day" name="Day" class="form-control">

                        <label for="Room">Room:</label>
                        <input type="text" id="Room" name="Room" class="form-control">

                        <label for="Course">Course:</label>
                        <input type="text" id="Course" name="Course" class="form-control">

                        <label for="Year">Year:</label>
                        <input type="text" id="Year" name="Year" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addSubjectBtn">Add Subject</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../JAYRIEL/css/bootstrap.css"></script> -->
    <script>
        document.getElementById('addSubjectBtn').addEventListener('click', function () {
            var instructorName = document.getElementById('instructorName').value;
            var instructorId = document.getElementById('instructorName').selectedOptions[0].value;
            document.getElementById('instructorNameHidden').value = instructorName;
            document.getElementById('instructorIdHidden').value = instructorId;
            document.getElementById('addSubjectForm').submit();
        });
    </script>
</body>

</html>