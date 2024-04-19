<?php
session_start(); // Start session to manage user sessions
require_once 'Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

// Check if the user registration form has been submitted
if (isset($_POST['userRegistration'])) {
    // Get user inputs from the form
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $mobile = preg_replace('/[^0-9]/', '', $_POST['mobile']); // Remove non-numeric characters from mobile number

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare a SQL statement to insert user data into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, mobile) VALUES (?, ?, ?, ?)");
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $mobile);
        // Execute the prepared statement
        if ($stmt->execute()) {
            // Registration successful message
            $registration_success = "Registration successful. You can now login.";
        } else {
            // Set an error message if user registration fails
            $stmt_error = "Error: User registration failed.";
        }

        $stmt->close();
    } catch (Exception $e) {
        // Set an error message if an exception occurs during the database operation
        $stmt_error = "Error: " . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
    <title>TMS</title>
</head>
<body>
<div class="row">
    <div class="col-md-3 m-auto">
        <h3>User Registration</h3>
        <!-- User registration form -->
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile no" required>
                <input type="Submit" name="userRegistration" value="Register" class="btn btn-warning">
            </div>
        </form>
        <!-- Link to go back to home page -->
        <a href="index.php" class="btn btn-danger">Back to home</a>
        <?php if (isset($registration_success)) { ?>
            <!-- Display registration successful message -->
            <div class="alert alert-success" role="alert">
                <?php echo $registration_success; ?>
            </div>
        <?php } elseif (isset($stmt_error)) { ?>
            <!-- Display an error message if user registration fails -->
            <div class="alert alert-danger" role="alert">
                <?php echo $stmt_error; ?>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
