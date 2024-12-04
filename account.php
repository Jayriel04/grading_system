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
        <a href="account.php">Account</a>
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
                        <form method='post'>
                            <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                            <button type='submit' name='delete'>Delete</button>
                        </form>
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