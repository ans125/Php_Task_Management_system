<?php
session_start();
// Include the Database.php file which contains the database connection code
require_once 'Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

// Check if the user login form has been submitted
if (isset($_POST['userlogin'])) {
    // Sanitize and validate the email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // Get the password from the form
    $password = $_POST['password'];

    try {
        // Prepare a SQL statement to select user data based on email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        // Bind the email parameter to the prepared statement
        $stmt->bind_param("s", $email);
        // Execute the prepared statement
        $stmt->execute();
        // Get the result of the executed statement
        $result = $stmt->get_result();

        // Check if there is a user with the provided email
        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();
            // Verify if the provided password matches the hashed password in the database
            if (password_verify($password, $user['password'])) {

                
                // Set session variables
                $_SESSION['uid'] = $user['uid'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                // Redirect the user to the user dashboard if login is successful
                header("Location: user_dashboard.php");
                exit();
            } else {
                // Set an error message if the provided password is incorrect
                $message = 'Incorrect email or password.';
            }
        } else {
            // Set an error message if the provided email is not found in the database
            $message = 'Incorrect email or password.';
        }

        // Close the prepared statement
        $stmt->close();
    } catch (Exception $e) {
        // Set an error message if an exception occurs during the database operation
        $message = 'An error occurred. Please try again later.';
        // Log the error message to the server's error log
        error_log("Login Error: " . $e->getMessage());
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>TMS</title>
</head>
<body>
<div class="row">
    <div class="col-md-3 m-auto">
        <h3>User Login</h3>
        <?php if(isset($message)): ?>
            <!-- Display an error message if it's set -->
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <!-- User login form -->
        <form action="" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                <input type="submit" name="userlogin" value="Login" class="btn btn-warning">
            </div>
        </form>
        <!-- Link to go back to home page -->
        <a href="index.php" class="btn btn-danger">Back to home</a>
    </div>
</div>

<!-- Bootstrap and jQuery JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
