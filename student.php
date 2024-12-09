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

// Function to fetch user's name
function fetchUserName($conn, $user_id)
{
    $userSql = "SELECT username FROM user WHERE id = $user_id";
    $userResult = $conn->query($userSql);

    if ($userResult->num_rows == 1) {
        $user = $userResult->fetch_assoc();
        return $user['username'];
    } else {
        return "Guest";
    }
}

// Fetch the user's name
$name = fetchUserName($conn, $user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Grading System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../JAYRIEL/css/bootstrap.css">
    <link rel="stylesheet" href="../jayriel/css/styles.css">
</head>

<body>
    <nav class="sidenav">
        <a href="index.php">
            <img src="../jayriel/image/user_icon.png" alt="User Icon" width="80" height="80" />
            <span>Welcome, <?php echo $name; ?></span>
        </a>
        <a href="index.php">HOME</a>
        <a href="class.php">CLASS</a>
        <a href="login.php">LOGOUT</a>
    </nav>
    <div class="main">
        <div class="dropdown">
            <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Option
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add</a>
                </li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">Import</a>
                </li>
            </ul>
        </div>
        <?php
        // Include the database connection file
        require 'connection.php';

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if user is not logged in
            header("Location: login.php");
            exit();
        }

        // Retrieve the logged-in user's ID
        $user_id = $_SESSION['user_id'];

        // Query the database to fetch student data based on instructor_id and subject_id
        if (isset($_SESSION['subjects']) && !empty($_SESSION['subjects']) && isset($_GET['subject']) && !empty($_GET['subject'])) {
            $selectedSubjectName = $_GET['subject'];
            $selectedSubjectId = array_search($selectedSubjectName, $_SESSION['subjects']);

            if ($selectedSubjectId !== false) {
                $_SESSION['subject_id'] = $selectedSubjectId; // Add selected subject ID to the session
        
                $studentSql = "SELECT * FROM student WHERE instructor_id = $user_id AND subject_id = $selectedSubjectId";
                $studentResult = $conn->query($studentSql);

                if ($studentResult->num_rows > 0) {
                    // Output student data in the table
                    echo '<table class="teacher-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Name</th>';
                    echo '<th>Midterm</th>';
                    echo '<th>Final</th>';
                    echo '<th>GPA</th>';
                    echo '<th>Remarks</th>';
                    echo '<th>Action</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    // Function to map score to GPA
                    function mapScoreToGPA($score)
                    {
                        if ($score >= 1 && $score < 1.5)
                            return 1.00;
                        if ($score >= 1.5 && $score < 2)
                            return 1.25;
                        if ($score >= 2 && $score < 2.5)
                            return 1.50;
                        if ($score >= 2.5 && $score < 3)
                            return 1.75;
                        if ($score >= 3 && $score < 3.5)
                            return 2.00;
                        if ($score >= 3.5 && $score < 4)
                            return 2.25;
                        if ($score >= 4 && $score < 4.5)
                            return 2.50;
                        if ($score >= 4.5 && $score < 5)
                            return 2.75;
                        if ($score == 5)
                            return 3.00; // 5 is considered a fail
                        return 5.00; // Failing grade
                    }

                    while ($row = $studentResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['student_id'] . '</td>';
                        echo '<td>' . $row['student_name'] . '</td>';

                        // Assume user inputs for midterm and final grades are provided as 1 to 5
                        $midterm = isset($row['midterm']) ? $row['midterm'] : 0; // Use existing data or 0 if not set
                        $final = isset($row['final']) ? $row['final'] : 0; // Use existing data or 0 if not set
        
                        echo '<td>' . number_format($midterm, 2) . '</td>';
                        echo '<td>' . number_format($final, 2) . '</td>';

                        // Define weights for midterm and final
                        $midtermWeight = 0.4; // 40% weight for midterm
                        $finalWeight = 0.6;   // 60% weight for final
        
                        // Calculate weighted average score
                        $weightedScore = ($midterm * $midtermWeight) + ($final * $finalWeight);

                        // Get GPA from the weighted score
                        $gpa = mapScoreToGPA($weightedScore);

                        // Determine remarks based on GPA
                        $remarks = ($gpa > 3.0) ? 'Failed' : 'Passed';

                        echo '<td>' . number_format($gpa, 2) . '</td>'; // Format GPA to two decimal places
                        echo '<td>' . $remarks . '</td>';
                        echo '<td><button class="edit-button btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStudentModal" data-student-id="' . $row['student_id'] . '">Edit</button></td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo 'No student data found for this subject.';
                }
            }
        }
        ?>
    </div>

    <!-- Modal for editing student data -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStudentForm" action="edit_student.php" method="POST">
                    <div class="modal-body">
                        <!-- Form fields for editing student data -->
                        <input type="hidden" id="editStudentId" name="studentId">
                        <label for="editStudentName">Name:</label>
                        <input type="text" id="editStudentName" name="studentName" class="form-control">
                        <label for="editStudentMidterm">Midterm Grade:</label>
                        <input type="number" id="editStudentMidterm" name="studentMidterm" class="form-control">
                        <label for="editStudentFinal">Final Grade:</label>
                        <input type="number" id="editStudentFinal" name="studentFinal" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // JavaScript code to populate the modal with student data from the table
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function () {
                // Get the table row associated with the clicked button
                const tableRow = this.closest('tr');

                // Extract student data from the table row
                const studentId = tableRow.dataset.studentId;
                const studentName = tableRow.cells[1].innerText; // Assuming the student name is in the second cell
                const studentMidterm = tableRow.cells[2].innerText; // Assuming the midterm grade is in the third cell
                const studentFinal = tableRow.cells[3].innerText; // Assuming the final grade is in the fourth cell

                // Populate the modal input fields with the student data
                document.getElementById('editStudentId').value = studentId;
                document.getElementById('editStudentName').value = studentName;
                document.getElementById('editStudentMidterm').value = studentMidterm;
                document.getElementById('editStudentFinal').value = studentFinal;
            });
        });
    </script>


    <!-- Modal form for adding grades -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm" method="post" action="add_student.php">
                        <input type="hidden" id="subjectId" name="subjectId">
                        <input type="hidden" id="instructorIdHidden" name="instructorIdHidden">

                        <label for="studentName">Student Name:</label>
                        <input type="text" id="studentName" name="studentName" class="form-control">

                        <label for="studentMidterm">Midterm:</label>
                        <input type="number" id="studentMidterm" name="studentMidterm" class="form-control">

                        <label for="studentFinal">Final:</label>
                        <input type="text" id="studentFinal" name="studentFinal" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addStudentBtn">Add Student</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for importing Excel file -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Excel File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" accept=".xls,.xlsx" id="fileInput">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="importBtn">Import</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('importBtn').addEventListener('click', function () {
            var fileInput = document.getElementById('fileInput');
            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, { type: 'array' });
                    var sheetName = workbook.SheetNames[0];
                    var sheet = workbook.Sheets[sheetName];
                    var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                    var names = jsonData.map(function (row) {
                        return row[0]; // Assuming the names are in the first column
                    });

                    // Send the names to a PHP script via AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'save_data.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.send(JSON.stringify(names));
                };
                reader.readAsArrayBuffer(file);
            } else {
                alert('Please select a file to import.');
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Fetch subject ID from the session
            const subjectId = <?php echo isset($_SESSION['subject_id']) ? $_SESSION['subject_id'] : 'null'; ?>;
            const instructorId = <?php echo $user_id; ?>;

            // Update form fields with subject ID and instructor ID
            document.getElementById('subjectId').value = subjectId;
            document.getElementById('instructorIdHidden').value = instructorId;
        });

        // Assuming you have a button with id 'addStudentBtn' to submit the form
        document.getElementById('addStudentBtn').addEventListener('click', function () {
            // Add user ID and subject ID to the form before submitting
            document.getElementById('instructorIdHidden').value = <?php echo $user_id; ?>;
            document.getElementById('addStudentForm').submit();
        });
    </script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../JAYRIEL/css/bootstrap.css"></script> -->
</body>

</html>