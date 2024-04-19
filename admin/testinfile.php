<?php
session_start();
require_once '../Database.php';

$error_message = ''; // Initialize error message variable

if(isset($_POST['adminlogin'])){
    try {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = htmlspecialchars($_POST['password']);

        if($email && $password){
            $database = new Database();
            $conn = $database->getConnection();

            $query ="SELECT id, name FROM admins WHERE email = ? AND password = ?";
            $stmt = $conn->prepare($query);

            if(!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            $stmt->bind_param("ss", $email, $password);
            if(!$stmt->execute()) {
                throw new Exception("Execution error: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $row = $result->fetch_assoc();
                $_SESSION['admin_email'] = $email;
                $_SESSION['admin_name'] = $row['name'];
                
                // Redirect to admin dashboard
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Please enter valid email and password.";
        }
    } catch (Exception $e) {
        $error_message = "An error occurred: " . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <title>TMS</title>
</head>
<body>
<div class="row">
    <div class="col-md-3 m-auto">
        <h3>Admin login</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                <input type="submit" name="adminlogin" value="Login" class="btn btn-warning">
            </div>
            <?php if(!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </form>
        <a href="../index.php" class="btn btn-danger">Back to home</a>
    </div>
</div>
</body>
</html>
