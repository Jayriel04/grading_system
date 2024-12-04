<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../JAYRIEL/css/styles_3.css">
    <style>
        .container {
                /* background-image: url(../JAYRIEL/image/mcc.jpg); */
                background-size: cover;
                /* Adjust the size to cover the entire element */
                background-position: center;
                /* Center the background image */
                background-repeat: no-repeat;
                /* Prevent the background image from repeating */
        }

        .box {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="account_login.php" method="post" onsubmit="return test()" class="box">
            <h1 class="text-center">Grading Portal</h1>
            <div class="mb-3">
                <label for="login_username" class="form-label">Username</label>
                <input type="text" class="form-control" name="login_username" id="login_username"
                    placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="login_password" class="form-label">Password</label>
                <input type="password" class="form-control" name="login_password" id="login_password"
                    placeholder="Enter your password" required>
            </div>
            <div class="invalid-feedback" id="failed_login" style="display: none; color: red;"></div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS and JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function test() {
            // Add your validation logic here
            return true; // Return true if validation passes, false if it fails
        }
    </script>
</body>

</html>