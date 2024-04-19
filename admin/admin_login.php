<?php
require_once '../Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

if(isset($_POST['adminlogin'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $query = "SELECT email, password, name FROM admins WHERE email = '$email' AND password = '$password'";
    $query_run = mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run)){
        echo "<script type='text/javascript'>
        window.location.href = 'admin_dashboard.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Please enter correct detail.');
        window.location.href = 'admin_login.php';
        </script>";
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
        </form>
        <a href="../index.php" class="btn btn-danger">Back to home</a>
    </div>
</div>
</body>
</html>
