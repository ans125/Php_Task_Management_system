<?php
require_once '../Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

// Check if the form is submitted
if(isset($_POST['create_task'])){
    // Process form submission and insert task into database
    $query = "INSERT INTO tasks VALUES (null, ?, ?, ?, ?, ?)";
    $uid = $_SESSION['uid'];
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issss", $_POST['id'], $_POST['description'], $_POST['start_date'], $_POST['end_date'], $status);
    $status = 'Not Started';
    if(mysqli_stmt_execute($stmt)){
        // Task created successfully, redirect to another page or the same page
        header("Location: admin_dashboard.php"); // Change to the appropriate URL
        exit();
    } else {
        echo "Error";
    }
    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../dashboard.css">
    <!-- jQuery code -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#create_task").click(function(){
                $("#main_content").load("create_task.php");
            });
        });
        // for manage task slideshow
        $(document).ready(function(){
            $("#manage_task").click(function(){
                $("#main_content").load("manage_task.php");
            });
        });
        // for leave application task slideshow
        $(document).ready(function(){
            $("#leave_task").click(function(){
                $("#main_content").load("leave_task.php");
            });
        });
    </script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-md-6 text-right">
                    <!-- You can remove the user details section since we are not using sessions -->
                </div>
            </div>
        </div>
    </header>
    <!-- /Header -->

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Side Menu -->
            <div id="side-menu" class="col-md-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="create_task">Create task</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="manage_task">Manage task</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="leave_task">Leave Application</a>
                    </li>
                    <li class="nav-item">
                        <a href="../logout.php" class="nav-link" id="create_task">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /Side Menu -->

            <!-- Main Content Area -->
            <div id="main_content" class="col-md-9">
                <div class="instructions">
                    <h2>Instructions for Admin</h2>
                    <ul>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, reprehenderit.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, reprehenderit.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, reprehenderit.</li>
                    </ul>
                </div>
            </div>
            <!-- /Main Content Area -->
        </div>
    </div>
    <!-- /Main Content -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
