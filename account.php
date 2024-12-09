<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MCC Grading System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../jayriel/css/styles.css" />
</head>

<body>
    <nav class="sidenav">
        <a href="admin.php">
            <img src="../jayriel/image/user_icon.png" alt="User Icon" width="80" height="80" /><span>Welcome</span>
        </a>
        <a href="admin.php">Home</a>
        <a href="login.php">LOGOUT</a>
    </nav>
    <div class="main">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">ADD
                ACCOUNT</button>
        </div>
        <h1>Account List</h1>
        <?php
        // Include the database connection file
        require 'connection.php';

        // Check if the delete button is clicked
        if (isset($_POST['delete'])) {
            $userId = $_POST['user_id'];

            // SQL query to delete a user record based on user ID
            $sql = "DELETE FROM user WHERE id = $userId";

            if ($conn->query($sql) === TRUE) {
                echo "User deleted successfully";
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        }

        // SQL query to fetch user data from the database
        $sql = "SELECT id, name, username, password FROM user";
        $result = $conn->query($sql);
        ?>
        <table class="instructor-table">
            <thead>
                <tr>
                    <th>Instructor Name</th>
                    <th>User Name</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>
                        <button class='edit-button btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-user-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-username='" . $row['username'] . "' data-password='" . $row['password'] . "'>Edit</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>0 results</td></tr>";
                }
                ?>
                <!-- Add rows for instructor and subject information here -->
            </tbody>
        </table>
        <?php
        // Close the database connection
        $conn->close();
        ?>

        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="post" action="update_user.php">
                            <input type="hidden" name="user_id" id="editUserId">
                            <label for="editName">Name:</label>
                            <input type="text" id="editName" name="name" class="form-control">

                            <label for="editUsername">Username:</label>
                            <input type="text" id="editUsername" name="username" class="form-control">

                            <label for="editPassword">Password:</label>
                            <input type="password" id="editPassword" name="password" class="form-control">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="editForm" class="btn btn-primary">Update User</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Get the modal element
            var editModal = document.getElementById('editModal');

            // Get the button that opens the modal
            var editButtons = document.querySelectorAll('.edit-button');

            // Get the form inside the modal
            var editForm = document.getElementById('editForm');

            // Get the <span> element that closes the modal
            var closeBtn = document.querySelector("#editModal .btn-close");

            // When the user clicks the button, open the modal and populate the form fields
            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    editModal.style.display = "block";
                    var userId = this.getAttribute('data-user-id');
                    var name = this.getAttribute('data-name');
                    var username = this.getAttribute('data-username');
                    var password = this.getAttribute('data-password');
                    document.getElementById('editUserId').value = userId;
                    document.getElementById('editName').value = name;
                    document.getElementById('editUsername').value = username;
                    document.getElementById('editPassword').value = password;
                });
            });

            // When the user clicks on <span> (x) or close button, close the modal
            closeBtn.addEventListener('click', function () {
                editModal.style.display = "none";
            });

            // When the user clicks anywhere outside of the modal, close it
            window.addEventListener('click', function (event) {
                if (event.target === editModal) {
                    editModal.style.display = "none";
                }
            });
        </script>

        <!-- Add Account Modal -->
        <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAccountModalLabel">Add Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="add_account.php">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control">

                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" class="form-control">

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Account</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>